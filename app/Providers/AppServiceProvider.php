<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Statamic\Facades\Icon;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Icon::register('social', public_path('assets/site/social-icons'));
    }
}
