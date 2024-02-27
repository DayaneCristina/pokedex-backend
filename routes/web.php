<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\PokemonController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthenticateOnceWithBasicAuth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group([
    'prefix' => '/api',
    'middleware' => ['api'],
], function() {

    Route::get('/health', [HealthController::class, 'health']);

    Route::group([
        'prefix'     => 'auth',
    ], function() {
        Route::post('/login', [AuthenticationController::class, 'authenticate']);
        Route::post('/register', [UserController::class, 'register']);

        Route::post('/logout', [AuthenticationController::class, 'logout'])
            ->middleware('auth:api');
    });

    Route::group([
        'prefix'     => 'pokemon',
        'middleware' => ['auth:api'],
    ], function() {
            Route::delete('/{externalId}', [PokemonController::class, 'delete']);

            Route::get('/{externalId}', [PokemonController::class, 'getByExternalId'])
                ->where('externalId', '[0-9]+');

            Route::get('/{name}', [PokemonController::class, 'search'])
                ->where('name', '[A-Za-z]+');


            Route::get('/', [PokemonController::class, 'getAll']);

            Route::post('/', [PokemonController::class, 'save']);
        });
});
