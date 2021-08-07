<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class HttpJsonHelper
{
    /**
     * Get HTTP request
     *
     * @param string $uri
     * @return array
    */
    public function getJsonResponse($uri): array
    {
        $userRequest = Http::accept('application/json')->get($uri);
        if (200 === $userRequest->getStatusCode()) {
            return $userRequest->json();
        }

        return [];
    }
}
