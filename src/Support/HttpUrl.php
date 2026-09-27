<?php

declare(strict_types=1);

namespace ZachWatkins\InferLaravelBlueprint\Support;

final class HttpUrl
{
    /**
     * Rejects URLs containing userinfo so credentials are not sent implicitly by HTTP clients.
     */
    public static function assertHasNoUserInfo(string $url): void
    {
        $parts = \parse_url($url);

        if (\is_array($parts) && (\array_key_exists('user', $parts) || \array_key_exists('pass', $parts))) {
            throw new \InvalidArgumentException('HTTP URLs must not contain userinfo credentials.');
        }
    }
}
