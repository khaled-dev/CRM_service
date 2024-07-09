<?php

namespace App\Exceptions;

use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExceptionHandler
{
    public function __construct(Exceptions $exceptions)
    {
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            return $this->pageNotFound();
        });
    }

    /**
     * @return JsonResponse
     */
    private function pageNotFound(): JsonResponse
    {
        return response()->json([
            'success' => 'false',
            'message' => 'Page Not Found',
        ], 404);
    }
}
