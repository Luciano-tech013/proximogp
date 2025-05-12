<?php

declare(strict_types=1);

class Content {
    private const API_URL = "https://f1api.dev/api/current";

    public static function get_races(): ?array {
        $request = file_get_contents(self::API_URL);

        return !empty($request) ? json_decode($request, true) : null;
    }
}