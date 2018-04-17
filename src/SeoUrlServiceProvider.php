<?php

namespace Luna\SeoUrls;

use Illuminate\Support\ServiceProvider;

/**
 * Seo url service provider.
 *
 * @package     Luna\SeoUrls
 * @author      Thomas Wiringa  <thomas.wiringa@gmail.com>
 */
class SeoUrlServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../migrations');
    }
}
