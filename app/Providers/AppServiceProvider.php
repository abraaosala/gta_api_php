<?php

namespace App\Providers;

use App\Models\Brand;
use App\Models\Contact;
use App\Models\EstimatorDevice;
use App\Models\EstimatorIssue;
use App\Models\Faq;
use App\Models\Feature;
use App\Models\Gallery;
use App\Models\ProcessStep;
use App\Models\Product;
use App\Models\Service;
use App\Models\Team;
use App\Models\Testimonial;
use App\Models\User;
use App\Repositories\Contracts\BrandRepositoryInterface;
use App\Repositories\Contracts\BusinessInfoRepositoryInterface;
use App\Repositories\Contracts\ContactRepositoryInterface;
use App\Repositories\Contracts\EstimatorDeviceRepositoryInterface;
use App\Repositories\Contracts\FaqRepositoryInterface;
use App\Repositories\Contracts\ProcessStepRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\ServiceRepositoryInterface;
use App\Repositories\Contracts\TestimonialRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Eloquent\BrandRepository;
use App\Repositories\Eloquent\BusinessInfoRepository;
use App\Repositories\Eloquent\ContactRepository;
use App\Repositories\Eloquent\EstimatorDeviceRepository;
use App\Repositories\Eloquent\FaqRepository;
use App\Repositories\Eloquent\ProcessStepRepository;
use App\Repositories\Eloquent\ProductRepository;
use App\Repositories\Eloquent\ServiceRepository;
use App\Repositories\Eloquent\TestimonialRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Services\AuthService;
use App\Services\ContactService;
use App\Services\Contracts\AuthServiceInterface;
use App\Services\Contracts\ContactServiceInterface;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(AuthServiceInterface::class, AuthService::class);

        $this->app->bind(ServiceRepositoryInterface::class, ServiceRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(TestimonialRepositoryInterface::class, TestimonialRepository::class);
        $this->app->bind(FaqRepositoryInterface::class, FaqRepository::class);
        $this->app->bind(BrandRepositoryInterface::class, BrandRepository::class);
        $this->app->bind(ProcessStepRepositoryInterface::class, ProcessStepRepository::class);
        $this->app->bind(EstimatorDeviceRepositoryInterface::class, EstimatorDeviceRepository::class);
        $this->app->bind(BusinessInfoRepositoryInterface::class, BusinessInfoRepository::class);
        $this->app->bind(ContactRepositoryInterface::class, ContactRepository::class);
        $this->app->bind(ContactServiceInterface::class, ContactService::class);
    }

    public function boot(): void
    {
        RateLimiter::for('login', fn (Request $request) => Limit::perMinute(5)->by($request->ip()));

        Route::bind('service', function (string $value): Service {
            abort_if(! is_numeric($value), 400, 'O ID do serviço deve ser um número.');

            return Service::findOrFail($value);
        });

        Route::bind('product', function (string $value): Product {
            abort_if(! is_numeric($value), 400, 'O ID do produto deve ser um número.');

            return Product::findOrFail($value);
        });

        Route::bind('brand', function (string $value): Brand {
            abort_if(! is_numeric($value), 400, 'O ID da marca deve ser um número.');

            return Brand::findOrFail($value);
        });

        Route::bind('testimonial', function (string $value): Testimonial {
            abort_if(! is_numeric($value), 400, 'O ID do depoimento deve ser um número.');

            return Testimonial::findOrFail($value);
        });

        Route::bind('faq', function (string $value): Faq {
            abort_if(! is_numeric($value), 400, 'O ID da FAQ deve ser um número.');

            return Faq::findOrFail($value);
        });

        Route::bind('feature', function (string $value): Feature {
            abort_if(! is_numeric($value), 400, 'O ID da funcionalidade deve ser um número.');

            return Feature::findOrFail($value);
        });

        Route::bind('gallery', function (string $value): Gallery {
            abort_if(! is_numeric($value), 400, 'O ID da galeria deve ser um número.');

            return Gallery::findOrFail($value);
        });

        Route::bind('team', function (string $value): Team {
            abort_if(! is_numeric($value), 400, 'O ID do membro deve ser um número.');

            return Team::findOrFail($value);
        });

        Route::bind('process', function (string $value): ProcessStep {
            abort_if(! is_numeric($value), 400, 'O ID da etapa deve ser um número.');

            return ProcessStep::findOrFail($value);
        });

        Route::bind('contact', function (string $value): Contact {
            abort_if(! is_numeric($value), 400, 'O ID do contacto deve ser um número.');

            return Contact::findOrFail($value);
        });

        Route::bind('device', function (string $value): EstimatorDevice {
            abort_if(! is_numeric($value), 400, 'O ID do dispositivo deve ser um número.');

            return EstimatorDevice::findOrFail($value);
        });

        Route::bind('issue', function (string $value): EstimatorIssue {
            abort_if(! is_numeric($value), 400, 'O ID do problema deve ser um número.');

            return EstimatorIssue::findOrFail($value);
        });

        Route::bind('user', function (string $value): User {
            abort_if(! is_numeric($value), 400, 'O ID do utilizador deve ser um número.');

            return User::findOrFail($value);
        });
    }
}
