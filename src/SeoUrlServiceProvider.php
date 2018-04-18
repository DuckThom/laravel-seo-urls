<?php

namespace Luna\SeoUrls;

use App\Http\Kernel;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Routing\RouteCompiler;
use Illuminate\Routing\RouteCollection;
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
     * Register the new SEO router.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton('router', function ($app) {
            return new SeoRouter($app['events'], $app);
        });
    }

    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../migrations');
        $requestPath = request()->path();

        if (! $requestPath) {
            return;
        }

        try {
            if (($seoUrl = $this->isSeoUrl($requestPath)) === null) {
                return;
            }
        } catch (\Illuminate\Database\QueryException $e) {
            // Prevent crashes if the table has not been created yet
            \Log::warning($e->getMessage());

            return;
        }

        if ($this->needsRedirect($seoUrl)) {
            // If the url is a redirect, generate a redirect response and send it

            redirect()
                ->to(
                    $seoUrl->getAttribute('target_path'),
                    $seoUrl->getAttribute('http_code')
                )
                ->send();
        } else {
            // If it's not a redirect, rewrite it internally so the user stays
            // on the same url, but laravel will serve a different page from
            // the one that was requested by the client.

            $sourcePath = $seoUrl->getAttribute('source_path');
            $targetPath = $seoUrl->getAttribute('target_path');

            // Pull the server values from the request object
            $server = request()->server;

            // Replace the current request uri with the target path from the SeoUrl model
            $server->set('REQUEST_URI', str_replace($sourcePath, $targetPath, $server->get('REQUEST_URI')));

            // Duplicate the request instance
            $request = request()->duplicate(null, null, null, null, null, $server->all());

            /** @var RouteCollection $routes */
            $routes = $this->app['router']->getRoutes();
            $route = $routes->match($request);

            if (! $route) {
                return;
            }

            // Set the active route, so Laravel doesnt do a lookup again
            $this->app['router']->setRoute($route);
        }
    }

    /**
     * Check if the request path is a seo url.
     *
     * @param  string  $path
     * @return SeoUrl|null
     */
    protected function isSeoUrl(string $path): ?SeoUrl
    {
        if (strpos($path, '/') !== 0) {
            $path = '/' . $path;
        }

        return SeoUrl::where('source_path', $path)->first();
    }

    /**
     * Check if the seo url is a redirect url.
     *
     * @param  SeoUrl  $seoUrl
     * @return bool
     */
    protected function needsRedirect(SeoUrl $seoUrl): bool
    {
        return $seoUrl->getAttribute('is_redirect');
    }
}
