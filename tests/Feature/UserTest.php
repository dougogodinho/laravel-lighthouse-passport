<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    public function testUserList()
    {
        factory(User::class, 33)->create();

        $response = $this->graphql("{ users(count:10) { paginatorInfo { currentPage lastPage total } data { id name email } } }");

        $this->assertTrue($response->json('data.users.paginatorInfo.currentPage') == 1);
        $this->assertNotNull($response->json('data.users.paginatorInfo.lastPage'));
        $this->assertNotNull($response->json('data.users.paginatorInfo.total'));
        $this->assertNotNull($response->json('data.users.data.0.id'));
        $this->assertNotNull($response->json('data.users.data.0.name'));
        $this->assertNotNull($response->json('data.users.data.0.email'));
    }

    public function testUserPage3()
    {
        factory(User::class, 33)->create();

        $response = $this->graphql("{ users(count:10,page:3) { paginatorInfo { currentPage lastPage total } data { id name email } } }");

        $this->assertTrue($response->json('data.users.paginatorInfo.currentPage') == 3);
        $this->assertNotNull($response->json('data.users.paginatorInfo.lastPage'));
        $this->assertNotNull($response->json('data.users.paginatorInfo.total'));
        $this->assertNotNull($response->json('data.users.data.0.id'));
        $this->assertNotNull($response->json('data.users.data.0.name'));
        $this->assertNotNull($response->json('data.users.data.0.email'));
    }

    public function testUserGet()
    {
        $user = factory(User::class)->create();

        $response = $this->graphql("{ user(id:{$user->id}) { id name email } }");

        $response->assertSee($user->name);
        $this->assertNotNull($response->json('data.user.id'));
        $this->assertNotNull($response->json('data.user.name'));
        $this->assertNotNull($response->json('data.user.email'));
    }

    public function testUserGetWithoutId()
    {
        $user = factory(User::class)->create();

        $response = $this->graphql("{ user { id name email } }");

        $response->assertDontSee($user->name);
        $this->assertNull($response->json('data'));
        $this->assertNotNull($response->json('errors.0.message'));
    }
}
