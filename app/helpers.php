<?php
use Illuminate\Support\Facades\Route;

if (! function_exists("test") ){

    function test()
    {
        
        return app("test");

    }

}

if (! function_exists("active_link") ){

    function active_link( string $link, string $class = "active fw-bold" ):string
    {
        
        return Route::is($link)? $class : "";

    }

}

if (! function_exists("alert") ){

    function alert( string $value, string $type = "success" )
    {
        
        session([
            'alert' => [
                'value' => $value,
                'type' => $type,
            ]
        ]);


    }

}

if (! function_exists("validate") ){

    function validate( array $attributes, array $rules ): array
    {
        // dd($attributes);
        return validator($attributes, $rules)->validated();

    }

}

if (! function_exists("__money") ){

    function __money( string $amount, string $currency_id ): string
    {

        $value = number_format($amount, 2, '.',' ');

        return "{$value} {$currency_id}";
    }

}