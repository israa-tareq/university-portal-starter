<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controllers\HasMiddleware;

abstract class Controller implements HasMiddleware
{
    /**
     * Middleware applied to every controller that extends this base.
     *
     * The whole portal requires a logged-in user, so the `auth` middleware is
     * attached here once. Public controllers (e.g. AuthController) override
     * this method and return an empty array.
     */
    public static function middleware(): array
    {
        return ['auth'];
    }
}
