# Plano de Migração: gta_api (Node/Prisma) → Laravel (gtat)

## 1. Visão Geral

**Origem:** `gta_api` — API REST em Node.js + Hono + Prisma + SQLite
**Destino:** `gtat` — Laravel 13 (fresh scaffold, sem customizações)
**Objetivo:** Migrar toda a funcionalidade da API Node para o ecossistema Laravel, substituindo SQLite por MySQL e usando os padrões Laravel (Eloquent, Migrations, Form Requests, etc.).

---

## 2. Fase 1 — Models + Migrations + Factories + Seeders

### 2.1. Tabelas a criar

Seguindo o schema do Prisma, criar migrations para:

| Tabela | Model | Notas |
|--------|-------|-------|
| `users` | `User` | Já existe (estender com `username`, `role`, `display_name`, `active`, `last_login_at`) |
| `personal_access_tokens` | — | Usar Sanctum (substitui refresh_tokens + JWT) |
| `services` | `Service` | `title`, `description`, `icon`, `features` (JSON), `price_range`, `avg_time` |
| `products` | `Product` | `name`, `category`, `price`, `original_price`, `image`, `description`, `specs` (JSON) |
| `testimonials` | `Testimonial` | `name`, `role`, `avatar`, `rating`, `text` |
| `faqs` | `Faq` | `question`, `answer`, `sort_order` |
| `brands` | `Brand` | `name`, `logo` |
| `process_steps` | `ProcessStep` | `step` (int), `title`, `description`, `icon` |
| `estimator_devices` | `EstimatorDevice` | `name`, `icon`, `base_price` |
| `estimator_issues` | `EstimatorIssue` | `device_id` (FK), `name`, `price_multiplier` |
| `business_infos` | `BusinessInfo` | Singleton (`id` fixo), `company_name`, `address`, `phone`, `email`, `working_hours`, `about`, `facebook`, `instagram`, `whatsapp` |
| `contacts` | `Contact` | `name`, `email`, `phone`, `message`, `read` (boolean) |

### 2.2. Comandos

```bash
# Estender users table
php artisan make:migration add_fields_to_users_table --table=users

# Criar models com migrations, factories, seeders
php artisan make:model Service -mf    # (-m = migration, -f = factory, -s = seeder)
php artisan make:model Product -mf
php artisan make:model Testimonial -mf
php artisan make:model Faq -mf
php artisan make:model Brand -mf
php artisan make:model ProcessStep -mf
php artisan make:model EstimatorDevice -mf
php artisan make:model EstimatorIssue -mf
php artisan make:model BusinessInfo -mf
php artisan make:model Contact -mf
```

### 2.3. Relacionamentos

- `EstimatorIssue` belongsTo `EstimatorDevice`
- `EstimatorDevice` hasMany `EstimatorIssue`
- `User` tem os tokens Sanctum (não precisa model separado)

### 2.4. Seeders

Criar `DatabaseSeeder` com dados iniciais:
- Admin user: `admin` / `gta2026`
- `BusinessInfo` padrão (GTA Tech, Luanda)
- Services, Brands, ProcessSteps, Testimonials, FAQs, Products, EstimatorDevices + Issues

---

## 3. Fase 2 — Autenticação (Laravel Sanctum)

### 3.1. Setup

```bash
php artisan install:api
# Instala o Laravel Sanctum + cria routes/api.php
```

### 3.2. Endpoints de Auth

| Método | Rota | Descrição |
|--------|------|-----------|
| `POST` | `/api/auth/login` | Login retorna token Sanctum |
| `POST` | `/api/auth/logout` | Revogar token atual |
| `GET` | `/api/auth/me` | Perfil do usuário logado |

### 3.3. Funcionalidades do JWT atual que o Sanctum cobre

| Funcionalidade gta_api | Como fazer no Sanctum |
|------------------------|----------------------|
| Access token (15min) | Sanctum tokens com expiração configurável |
| Refresh token | Cliente faz login novamente ou usa `abilities` |
| Token rotation | Revogar + criar novo token a cada refresh |
| Rate limit no login | `RateLimiter` do Laravel |
| Middleware de proteção | `auth:sanctum` nas rotas admin |

### 3.4. User model — alterações

Adicionar campos: `username` (unique), `role` (default `'admin'`), `display_name`, `active` (boolean), `last_login_at` (timestamp nullable).

---

## 4. Fase 3 — API Routes e Controllers

### 4.1. Estrutura de Controllers

```
app/Http/Controllers/Api/
├── AuthController.php
├── Public/
│   ├── ServiceController.php
│   ├── ProductController.php
│   ├── TestimonialController.php
│   ├── FaqController.php
│   ├── BrandController.php
│   ├── ProcessStepController.php
│   ├── EstimatorController.php
│   ├── BusinessInfoController.php
│   └── ContactController.php
├── Admin/
│   ├── ServiceController.php
│   ├── ProductController.php
│   ├── TestimonialController.php
│   ├── FaqController.php
│   ├── BrandController.php
│   ├── ProcessStepController.php
│   ├── EstimatorDeviceController.php
│   ├── EstimatorIssueController.php
│   ├── ContactController.php
│   └── BusinessInfoController.php
└── UploadController.php
```

### 4.2. Rotas (routes/api.php)

```php
// Health check
Route::get('/', fn () => response()->json([
    'message' => 'GTA Tech API',
    'version' => '1.0.0',
]));

// Auth (público)
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/auth/me', [AuthController::class, 'me'])->middleware('auth:sanctum');

// Públicas
Route::post('/public/contacts', [ContactController::class, 'store']);
Route::get('/public/services', [Public\ServiceController::class, 'index']);
Route::get('/public/services/{id}', [Public\ServiceController::class, 'show']);
Route::get('/public/products', [Public\ProductController::class, 'index']);
Route::get('/public/products/{id}', [Public\ProductController::class, 'show']);
Route::get('/public/testimonials', [Public\TestimonialController::class, 'index']);
Route::get('/public/testimonials/{id}', [Public\TestimonialController::class, 'show']);
// etc. para FAQs, Brands, Process, Estimator, Info

// Admin (protegidas)
Route::middleware('auth:sanctum')->prefix('admin')->group(function () {
    Route::apiResource('services', Admin\ServiceController::class);
    Route::apiResource('products', Admin\ProductController::class);
    Route::apiResource('testimonials', Admin\TestimonialController::class);
    Route::apiResource('faqs', Admin\FaqController::class);
    Route::apiResource('brands', Admin\BrandController::class);
    Route::apiResource('process', Admin\ProcessStepController::class);
    Route::apiResource('contacts', Admin\ContactController::class)->only(['index', 'show', 'destroy']);
    Route::apiResource('estimator/devices', Admin\EstimatorDeviceController::class);
    Route::apiResource('estimator/issues', Admin\EstimatorIssueController::class);
    Route::get('info', [Admin\BusinessInfoController::class, 'show']);
    Route::put('info', [Admin\BusinessInfoController::class, 'update']);
    Route::post('upload', [UploadController::class, 'store']);
});
```

### 4.3. API Resources (Eloquent API Resources)

Criar Resource classes para cada model, com campos públicos vs admin:

```bash
php artisan make:resource ServiceResource
php artisan make:resource ServiceAdminResource
php artisan make:resource ProductResource
# etc.
```

Usar `ServiceResource` nas rotas públicas (projeção de campos) e `ServiceAdminResource` nas rotas admin (todos os campos).

### 4.4. Form Requests (Validação)

```bash
php artisan make:request StoreServiceRequest
php artisan make:request UpdateServiceRequest
php artisan make:request StoreContactRequest
# etc.
```

### 4.5. Upload de Imagens

Criar `UploadController` que:
- Usa `$request->file('file')` (Laravel já faz parse de multipart)
- Valida tipos: jpeg, png, webp, gif
- Valida tamanho: max 5MB
- Salva em `storage/app/public/uploads/` com UUID
- Retorna URL: `/storage/uploads/uuid.ext`
- Criar symlink: `php artisan storage:link`

---

## 5. Fase 4 — Segurança e Middleware

### 5.1. Rate Limiting

Usar o `RateLimiter` do Laravel para login:

```php
// AppServiceProvider::boot()
RateLimiter::for('login', fn ($job) => Limit::perMinute(5)->by($job->ip()));
```

### 5.2. CORS

Publicar config do CORS:

```bash
php artisan config:publish cors
```

Configurar para permitir origens do frontend (Vite dev: `localhost:5173`, produção: domínio real).

### 5.3. Exclusão lógica vs física

- `Contact` — usar exclusão física (DELETE simples)
- Demais modelos — usar exclusão física (DELETE)

---

## 6. Fase 5 — Frontend Blade (Opcional)

### 6.1. Admin Panel

Se quiser um painel admin Blade:

- Usar Laravel + Blade + Tailwind CSS v4 (já configurado)
- Criar views para CRUD de cada entidade
- Autenticação com session (Breeze) ou manter headless API com Sanctum + frontend React separado

### 6.2. Landing Page

- Migrar conteúdo da landing page (serviços, produtos, depoimentos, FAQ) para views Blade
- Ou manter frontend React separado consumindo a API Laravel

---

## 7. Fase 6 — Testes

### 7.1. Testes de Feature

Usar Pest para testar todos os endpoints:

```bash
php artisan make:test --pest Api/AuthTest
php artisan make:test --pest Api/ServiceTest
php artisan make:test --pest Api/ProductTest
# etc.
```

Testar:
- Login bem-sucedido e falho
- Rotas públicas retornam dados corretos
- Rotas admin exigem autenticação
- CRUD de cada entidade
- Upload de imagem
- Rate limiting no login

### 7.2. Testes Unitários

Testar regras de negócio:
- Cálculo do orçamento: `basePrice * priceMultiplier`
- Validação de senha (mínimo 6 caracteres)
- Impedir auto-exclusão de usuário

---

## 8. Fase 7 — Integrações Futuras

| Integração | Como implementar no Laravel |
|------------|---------------------------|
| WhatsApp API | Notification Channel + `laravel-notification-channels/whatsapp` ou HTTP client |
| Email (leads) | Laravel Mail + Mailable classes |
| Google Gemini AI | HTTP Client para API Gemini |
| Cloudinary | `cloudinary-labs/cloudinary-laravel` ou Storage custom |
| Google Analytics | No frontend (Blade/React) |

---

## 9. Estrutura Final do Projeto

```
gtat/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── Api/
│   │   │       ├── AuthController.php
│   │   │       ├── UploadController.php
│   │   │       ├── Public/
│   │   │       │   ├── ServiceController.php
│   │   │       │   ├── ProductController.php
│   │   │       │   ├── TestimonialController.php
│   │   │       │   ├── FaqController.php
│   │   │       │   ├── BrandController.php
│   │   │       │   ├── ProcessStepController.php
│   │   │       │   ├── EstimatorController.php
│   │   │       │   ├── BusinessInfoController.php
│   │   │       │   └── ContactController.php
│   │   │       └── Admin/
│   │   │           ├── ServiceController.php
│   │   │           ├── ProductController.php
│   │   │           ├── TestimonialController.php
│   │   │           ├── FaqController.php
│   │   │           ├── BrandController.php
│   │   │           ├── ProcessStepController.php
│   │   │           ├── EstimatorDeviceController.php
│   │   │           ├── EstimatorIssueController.php
│   │   │           ├── ContactController.php
│   │   │           └── BusinessInfoController.php
│   │   ├── Requests/
│   │   │   ├── StoreServiceRequest.php
│   │   │   ├── UpdateServiceRequest.php
│   │   │   ├── StoreContactRequest.php
│   │   │   └── ...
│   │   └── Resources/
│   │       ├── ServiceResource.php
│   │       ├── ServiceAdminResource.php
│   │       └── ...
│   ├── Models/
│   │   ├── User.php
│   │   ├── Service.php
│   │   ├── Product.php
│   │   ├── Testimonial.php
│   │   ├── Faq.php
│   │   ├── Brand.php
│   │   ├── ProcessStep.php
│   │   ├── EstimatorDevice.php
│   │   ├── EstimatorIssue.php
│   │   ├── BusinessInfo.php
│   │   └── Contact.php
│   └── Providers/
│       └── AppServiceProvider.php  (modificado)
├── config/
│   └── cors.php
├── database/
│   ├── factories/  (+ 10 factories)
│   ├── migrations/ (+ 11 migrations)
│   └── seeders/
│       └── DatabaseSeeder.php  (expandido)
├── routes/
│   └── api.php
├── storage/
│   └── app/public/uploads/
├── resources/views/  (se usar Blade admin)
└── tests/
    ├── Feature/Api/  (+ test files)
    └── Unit/
```

---

## 10. Resumo de Comandos

```bash
# 1. Setup inicial
php artisan install:api                    # Sanctum + routes/api.php
php artisan storage:link                   # Symlink para uploads
php artisan config:publish cors            # CORS config

# 2. Migrations
php artisan make:migration add_fields_to_users_table --table=users
php artisan make:migration create_services_table
php artisan make:migration create_products_table
php artisan make:migration create_testimonials_table
php artisan make:migration create_faqs_table
php artisan make:migration create_brands_table
php artisan make:migration create_process_steps_table
php artisan make:migration create_estimator_devices_table
php artisan make:migration create_estimator_issues_table
php artisan make:migration create_business_infos_table
php artisan make:migration create_contacts_table

# 3. Models
php artisan make:model Service
php artisan make:model Product
php artisan make:model Testimonial
php artisan make:model Faq
php artisan make:model Brand
php artisan make:model ProcessStep
php artisan make:model EstimatorDevice
php artisan make:model EstimatorIssue
php artisan make:model BusinessInfo
php artisan make:model Contact

# 4. Factories
php artisan make:factory ServiceFactory --model=Service
php artisan make:factory ProductFactory --model=Product
# ... (mesmo para os demais)

# 5. Seeders
php artisan make:seeder ServiceSeeder
php artisan make:seeder ProductSeeder
# ... (mesmo para os demais)

# 6. Resources
php artisan make:resource ServiceResource
php artisan make:resource ServiceAdminResource
php artisan make:resource ProductResource
php artisan make:resource ProductAdminResource
php artisan make:resource TestimonialResource
php artisan make:resource FaqResource
php artisan make:resource BrandResource
php artisan make:resource ProcessStepResource
php artisan make:resource EstimatorDeviceResource
php artisan make:resource EstimatorIssueResource
php artisan make:resource BusinessInfoResource
php artisan make:resource ContactResource

# 7. Form Requests
php artisan make:request StoreServiceRequest
php artisan make:request UpdateServiceRequest
php artisan make:request StoreProductRequest
php artisan make:request UpdateProductRequest
php artisan make:request StoreTestimonialRequest
php artisan make:request UpdateTestimonialRequest
php artisan make:request StoreFaqRequest
php artisan make:request UpdateFaqRequest
php artisan make:request StoreBrandRequest
php artisan make:request UpdateBrandRequest
php artisan make:request StoreProcessStepRequest
php artisan make:request UpdateProcessStepRequest
php artisan make:request StoreEstimatorDeviceRequest
php artisan make:request UpdateEstimatorDeviceRequest
php artisan make:request StoreEstimatorIssueRequest
php artisan make:request UpdateEstimatorIssueRequest
php artisan make:request StoreBusinessInfoRequest
php artisan make:request StoreContactRequest

# 8. Controllers
php artisan make:controller Api/AuthController
php artisan make:controller Api/UploadController
php artisan make:controller Api/Public/ServiceController --resource
php artisan make:controller Api/Public/ProductController --resource
php artisan make:controller Api/Public/TestimonialController --resource
php artisan make:controller Api/Public/FaqController --resource
php artisan make:controller Api/Public/BrandController --resource
php artisan make:controller Api/Public/ProcessStepController --resource
php artisan make:controller Api/Public/EstimatorController
php artisan make:controller Api/Public/BusinessInfoController
php artisan make:controller Api/Public/ContactController
php artisan make:controller Api/Admin/ServiceController --resource
php artisan make:controller Api/Admin/ProductController --resource
php artisan make:controller Api/Admin/TestimonialController --resource
php artisan make:controller Api/Admin/FaqController --resource
php artisan make:controller Api/Admin/BrandController --resource
php artisan make:controller Api/Admin/ProcessStepController --resource
php artisan make:controller Api/Admin/EstimatorDeviceController --resource
php artisan make:controller Api/Admin/EstimatorIssueController --resource
php artisan make:controller Api/Admin/ContactController --resource
php artisan make:controller Api/Admin/BusinessInfoController

# 9. Testes
php artisan make:test --pest Api/AuthTest
php artisan make:test --pest Api/ServiceTest
php artisan make:test --pest Api/ProductTest
php artisan make:test --pest Api/TestimonialTest
php artisan make:test --pest Api/FaqTest
php artisan make:test --pest Api/BrandTest
php artisan make:test --pest Api/ProcessStepTest
php artisan make:test --pest Api/EstimatorTest
php artisan make:test --pest Api/BusinessInfoTest
php artisan make:test --pest Api/ContactTest
php artisan make:test --pest Api/UploadTest

# 10. Rodar tudo
php artisan migrate
php artisan db:seed
php artisan test --compact
vendor/bin/pint --format agent
```
