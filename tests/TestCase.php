<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @param $query
     * @param null|string|User $userToken
     * @param null $variables
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function graphql($query, $userToken = null, $variables = null)
    {
        $userToken = $userToken instanceof User ? $userToken->createToken('TestCaseRequest')->accessToken : $userToken;

        $headers = $userToken ? ['Authorization' => 'Bearer ' . $userToken] : [];

        return $this->post('/graphql', compact('query', 'variables'), $headers);
    }
}
