<?php

namespace Luna\SeoUrls;

use Illuminate\Routing\Router;

class SeoRouter extends Router
{
    protected $route;

    /**
     * Find the route matching a given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Route
     */
    protected function findRoute($request)
    {
        if (! $this->route) {
            $this->route = $this->routes->match($request);
        }
        dd($this->route);

        $this->current = $this->route;

        $this->container->instance(Route::class, $this->route);

        return $this->route;
    }

    public function setRoute($route)
    {
        $this->route = $route;

        return $this;
    }
}