<?php

namespace App\Services;

use App\Helpers\HttpJsonHelper;
use Illuminate\Support\Facades\Cache;

class GithubApiService
{
    private $httpJsonService;

    public function __construct()
    {
        $this->httpJsonService = new HttpJsonHelper();
    }

    /**
     * Get the list of users from GitHub API
     *
     * @param array $users
     * @return iterable;
     */
    public function list($users): iterable
    {
        $githubUsers = [];
        foreach ($users as $user) {
            $userCache = Cache::remember($user, env('GITHUB_CACHE_TIME_SECONDS', 120), function () use ($user) {
                $userRequest = $this->httpJsonService->getJsonResponse(env('GITHUB_API_URL')."/users/".$user);

                return [
                    'name' => $userRequest['name'],
                    'login' => $userRequest['login'],
                    'company' => $userRequest['company'],
                    'number_of_followers' => $userRequest['followers'],
                    'number_of_public_repositories' => $userRequest['public_repos'],
                    'avg_number_of_followers_per_public_repository' => intval($userRequest['public_repos']) > 0 ?
                        intval($userRequest['followers']) / intval($userRequest['public_repos'])
                        : 0
                ];
            });

            if ($userCache && array_search($userCache['login'], array_column($githubUsers, 'login')) === false) {
                array_push($githubUsers, $userCache);
            }
        }
        usort($githubUsers, function($a, $b) {
            return strcmp($a['name'], $b['name']);
        });
        return $githubUsers;
    }
}
