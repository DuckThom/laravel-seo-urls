<?php

namespace Luna\SeoUrls;

use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Illuminate\Container\Container;
use Illuminate\Contracts\Events\Dispatcher;

/**
 * Seo router.
 *
 * @package     Luna\SeoUrls
 * @author      Thomas Wiringa  <thomas.wiringa@gmail.com>
 */
class SeoRouter extends Router
{
    /**
     * @var Route
     */
    protected $route;

    /**
     * Find the route matching a given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Route
     */
    protected function findRoute($request): Route
    {
        if (! $this->route) {
            $this->route = $this->routes->match($request);
        }

        $this->current = $this->route;

        $this->container->instance(Route::class, $this->route);

        return $this->route;
    }

    /**
     * Override the route.
     *
     * @param  Route  $route
     * @return $this
     */
    public function setRoute(Route $route): SeoRouter
    {
        $this->route = $route;

        return $this;
    }
}