<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BasicTest extends TestCase
{
    public function testBasicGet()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function testGraphqlHello()
    {
        $response = $this->graphql('{ hello }');
        $response->assertSee('Hello world!');
        $this->assertNotNull($response->json('data.hello'));
    }
}
