
# SEO Urls

## Setup

Add the service provider to the providers in `config/app.php` *AFTER* the RouteServiceProvider.

```php
Luna\SeoUrls\SeoUrlServiceProvider::class
```

Add the following code to app/Http/Kernel.php

```php
    /**
     * Get the route dispatcher callback.
     *
     * @return \Closure
     */
    protected function dispatchToRouter()
    {
        $this->router = $this->app->make('router');

        foreach ($this->routeMiddleware as $key => $middleware) {
            $this->router->middleware($key, $middleware);
        }

        foreach ($this->middlewareGroups as $key => $middleware) {
            $this->router->middlewareGroup($key, $middleware);
        }

        return parent::dispatchToRouter();
    }
```
