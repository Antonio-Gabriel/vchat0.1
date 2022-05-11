<?php

namespace Vchat\Events;

class ResponseEvent
{
    public static function sendResponse(
        string $type,
        string $state,
        ...$args
    ) {

        $responseArr = [
            "0" => $type,
            "1" => $state,
            ...$args
        ];

        $keys = ["type", "status", "others"];

        return json_encode(self::renameKeys($responseArr, $keys));
    }

    private static function renameKeys($array, $replacementKeys)
    {
        return array_combine(
            $replacementKeys,
            array_values($array)
        );
    }
}
