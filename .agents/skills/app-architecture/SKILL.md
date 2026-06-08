---
name: app-architecture
description: "Use when writing or modifying Laravel backend code in this project. This skill defines the layered architecture (Controller → Service → Repository → Model) used throughout the application. Activate for any task involving controllers, services, repositories, models, form requests, routes, or tests."
---

# App Architecture: Controller → Service → Repository → Model

This project follows a strict **layered architecture** with **Dependency Injection via Service Provider**.

## Architecture Layers

| Layer | Location | Responsibility |
|-------|----------|----------------|
| **Controller** | `app/Http/Controllers/Api/` | HTTP handling — validates input, calls service, returns JSON response |
| **Service** | `app/Services/` | Business logic — orchestrates operations (no HTTP/request knowledge) |
| **Repository** | `app/Repositories/Eloquent/` | Data access — Eloquent queries, DB operations (no business logic) |
| **Model** | `app/Models/` | Entity representation, relationships, casts |

## Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   └── Api/
│   │       ├── AuthController.php
│   │       ├── Public/
│   │       └── Admin/
│   └── Requests/
│       └── Api/
├── Services/
│   ├── Contracts/              (interfaces)
│   └── *Service.php            (implementations)
├── Repositories/
│   ├── Contracts/              (interfaces)
│   └── Eloquent/
│       ├── BaseRepository.php  (abstract — all, find, create, update, delete)
│       └── *Repository.php     (extends BaseRepository)
└── Models/
```

## Dependency Injection

All bindings are registered in `AppServiceProvider::register()`:

```php
$this->app->bind(UserRepositoryInterface::class, UserRepository::class);
$this->app->bind(AuthServiceInterface::class, AuthService::class);
```

Controllers receive services via constructor injection. Services receive repositories via constructor injection.

## Repository Pattern

### BaseRepository (abstract)

```php
abstract class BaseRepository
{
    public function __construct(protected Model $model) {}

    public function all(array $columns = ['*']): Collection
    {
        return $this->model->all($columns);
    }

    public function find(int|string $id): ?Model
    {
        return $this->model->find($id);
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function update(int|string $id, array $data): Model
    {
        $record = $this->find($id);
        $record->update($data);

        return $record;
    }

    public function delete(int|string $id): bool
    {
        return $this->model->destroy($id);
    }
}
```

### Contract Interface

```php
interface UserRepositoryInterface
{
    public function find(int|string $id): ?Model;
    public function findByUsername(string $username): ?User;
    public function create(array $data): Model;
    public function updateLastLogin(User $user): void;
}
```

### Eloquent Implementation

```php
class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new User());
    }

    public function findByUsername(string $username): ?User
    {
        return $this->model->where('username', $username)->first();
    }

    public function updateLastLogin(User $user): void
    {
        $user->update(['last_login_at' => now()]);
    }
}
```

## Service Pattern

### Contract Interface

```php
interface AuthServiceInterface
{
    public function login(string $username, string $password): array;
    public function logout(User $user): void;
    public function me(User $user): User;
}
```

### Implementation

```php
class AuthService implements AuthServiceInterface
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {}

    public function login(string $username, string $password): array
    {
        $user = $this->userRepository->findByUsername($username);

        if (!$user || !$user->active || !Hash::check($password, $user->password)) {
            throw new AuthenticationException('Invalid credentials');
        }

        $this->userRepository->updateLastLogin($user);

        $token = $user->createToken('auth-token')->plainTextToken;

        return [
            'accessToken' => $token,
            'user' => $user->only(['id', 'username', 'name', 'display_name', 'role']),
        ];
    }

    public function logout(User $user): void
    {
        $user->currentAccessToken()->delete();
    }

    public function me(User $user): User
    {
        return $user;
    }
}
```

## Controller Pattern

```php
class AuthController extends Controller
{
    public function __construct(
        protected AuthServiceInterface $authService
    ) {}

    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->authService->login(
            $request->validated('username'),
            $request->validated('password')
        );

        return response()->json($result);
    }

    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout($request->user());

        return response()->json(null, 204);
    }

    public function me(Request $request): JsonResponse
    {
        return response()->json(
            $this->authService->me($request->user())
        );
    }
}
```

## Route Pattern

```php
// routes/api.php
Route::get('/', fn () => response()->json([
    'message' => 'GTA Tech API',
    'version' => '1.0.0',
]));

Route::post('/auth/login', [AuthController::class, 'login'])
    ->middleware('throttle:login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me', [AuthController::class, 'me']);
});
```

## Rate Limiting

Register in `AppServiceProvider::boot()`:

```php
RateLimiter::for('login', fn ($job) => Limit::perMinute(5)->by($job->ip()));
```

## Testing Pattern

```php
// tests/Feature/Api/AuthTest.php
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use function Pest\Laravel\postJson;
use function Pest\Laravel\getJson;

beforeEach(function () {
    $this->user = User::factory()->create([
        'username' => 'admin',
        'password' => Hash::make('gta2026'),
        'active' => true,
    ]);
});

test('login with valid credentials returns token', function () {
    postJson('/api/auth/login', [
        'username' => 'admin',
        'password' => 'gta2026',
    ])
        ->assertOk()
        ->assertJsonStructure(['accessToken', 'user']);
});

test('login with invalid password returns 401', function () {
    postJson('/api/auth/login', [
        'username' => 'admin',
        'password' => 'wrong',
    ])->assertUnauthorized();
});

test('login with inactive user returns 401', function () {
    $this->user->update(['active' => false]);

    postJson('/api/auth/login', [
        'username' => 'admin',
        'password' => 'gta2026',
    ])->assertUnauthorized();
});

test('me returns authenticated user', function () {
    $token = $this->user->createToken('test')->plainTextToken;

    getJson('/api/auth/me', [
        'Authorization' => "Bearer $token",
    ])->assertOk()->assertJsonFragment(['username' => 'admin']);
});

test('me without token returns 401', function () {
    getJson('/api/auth/me')->assertUnauthorized();
});

test('logout revokes token', function () {
    $token = $this->user->createToken('test')->plainTextToken;

    postJson('/api/auth/logout', [], [
        'Authorization' => "Bearer $token",
    ])->assertNoContent();
});
```

## Entity CRUD Pattern (for Phases 3+)

Each entity (Service, Product, etc.) follows:

| File | Pattern |
|------|---------|
| `Model` | Fillable, casts, relationships |
| `RepositoryInterface` | `all()`, `find($id)`, `create($data)`, `update($id, $data)`, `delete($id)` + custom queries |
| `Repository` | Extends `BaseRepository`, implements interface |
| `ServiceInterface` | Business methods |
| `Service` | Inject repository, implement business rules |
| `Controller` (Public) | `index()`, `show($id)` — returns Resource |
| `Controller` (Admin) | Full CRUD — uses FormRequest for validation |
| `FormRequest` | `Store*Request`, `Update*Request` |
| `Resource` | `*Resource` (public), `*AdminResource` (all fields) |
| `Test` | Feature test for all endpoints |
