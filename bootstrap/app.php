<?php

use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectGuestsTo(fn (Request $request) => abort(401, 'Não autenticado.'));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );

        $exceptions->renderable(function (QueryException $e, Request $request): never {
            if (! $request->is('api/*') && ! $request->expectsJson()) {
                abort(500, 'Erro interno do servidor.');
            }

            $msg = $e->getMessage();

            if (preg_match("/Column\s+'(\w+)'\s+cannot be null/i", $msg, $m)) {
                $message = 'O campo "'.$m[1].'" é obrigatório.';
            } elseif (preg_match("/Duplicate entry '([^']+)' for key/i", $msg, $m)) {
                $message = 'O valor "'.$m[1].'" já está em uso.';
            } elseif (str_contains($msg, 'foreign key constraint fails')) {
                $message = 'Registo referenciado não encontrado.';
            } elseif (str_contains($msg, '2002')) {
                $message = 'Serviço temporariamente indisponível.';
            } else {
                $message = 'Ocorreu um erro ao processar a sua solicitação.';
            }

            abort(422, $message);
        });
    })->create();
