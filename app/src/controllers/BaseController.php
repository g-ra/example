<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Response;

class BaseController {
    public function response($data, int $code) {
        return new Response(json_encode($data), $code, ['Content-Type' => 'application/json']);
    }
}