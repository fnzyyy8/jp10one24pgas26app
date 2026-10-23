<?php

use Illuminate\Contracts\Support\Arrayable;

if (!function_exists('ddJson')) {
    function ddJson(mixed $data)
    {
        dd(
            json_encode(
                $data instanceof Arrayable ? $data->toArray() : $data,
                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );
    }
}
