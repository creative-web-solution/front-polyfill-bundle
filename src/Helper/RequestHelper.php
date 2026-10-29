<?php

declare(strict_types=1);

namespace Cws\Bundle\FrontPolyfillBundle\Helper;

use Symfony\Component\HttpFoundation\Request;

class RequestHelper
{
    public static function get(Request $request, string $key): string
    {
        $value = $request->query->getString(key: $key);

        if ('' === $value) {
            $value = $request->request->get(key: $key);
        }

        if ('' === $value) {
            $value = $request->attributes->getString(key: $key);
        }

        return $value;
    }
}
