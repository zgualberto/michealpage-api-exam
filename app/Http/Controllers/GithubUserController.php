<?php

namespace App\Http\Controllers;

use App\Services\GithubApiService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\GithubUserPostRequest;

class GithubUserController extends Controller
{
    private $githubApiService;

    public function __construct()
    {
        $this->githubApiService = new GithubApiService();
    }

    /**
     * Display a listing of the GitHub Users.
     *
     * @param App\Http\Requests\GithubUserPostRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(GithubUserPostRequest $request): JsonResponse
    {
        return $this->handleResponse($this->githubApiService->list($request->get('users')));
    }
}
