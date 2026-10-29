<?php

declare(strict_types=1);

namespace Cws\Bundle\FrontPolyfillBundle\Helper;

use Symfony\Component\HttpFoundation\Request;

class RequestHelper
{
    public static function get(Request $request, string $key, mixed $default = null): mixed
    {
        $result = $request->attributes->get($key, $default);

        if ($default !== $result) {
            return $result;
        }

        if ($request->query->has($key)) {
            return $request->query->all()[$key];
        }

        if ($request->request->has($key)) {
            return $request->request->all()[$key];
        }

        return $default;
    }

    public static function getString(Request $request, string $key, mixed $default = ''): string
    {
        return (string) self::get($request, $key, $default);
    }
}
