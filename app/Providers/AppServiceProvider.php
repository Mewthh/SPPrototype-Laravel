<?php

namespace App\Providers;

use App\Models\DownloadCategory;
use App\Models\ProceedingsTemplate;
use App\Models\SppEvent;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Laravel\Fortify\Contracts\LoginResponse;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            LoginResponse::class,
            \App\Http\Responses\LoginResponse::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();

        View::composer('components.public-header', function ($view) {
            $conferences = SppEvent::published()
                ->orderBy('year', 'desc')
                ->orderBy('created_at', 'desc')
                ->get();
            $view->with('headerConferences', $conferences);
        });

        View::composer('components.downloads-modal', function ($view) {
            $columns = [[], [], []];
            $columnDocumentCounts = [0, 0, 0];
            $categories = DownloadCategory::query()
                ->with(['downloads' => fn ($query) => $query->where('status', 'published')->latest('year')->latest('id')])
                ->oldest('id')
                ->get();

            foreach ($categories as $category) {
                $columnIndex = array_keys($columnDocumentCounts, min($columnDocumentCounts))[0];
                $columns[$columnIndex][] = $category;
                $columnDocumentCounts[$columnIndex] += $category->downloads->count();
            }

            $view->with([
                'downloadColumns' => $columns,
                'proceedingsTemplate' => ProceedingsTemplate::first(),
            ]);
        });
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }
}
