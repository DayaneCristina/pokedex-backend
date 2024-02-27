<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;

class HealthController extends Controller
{
    public function health() : Response
    {
        return response()
            ->json([
                'api' => 'up'
            ]);
    }
}
