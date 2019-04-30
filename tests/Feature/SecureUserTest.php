<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SecureUserTest extends TestCase
{
    use DatabaseTransactions;

    public function testUserList()
    {
        $users = factory(User::class, 33)->create();

        $response = $this->graphql("{ secureUsers(count:10) { paginatorInfo { currentPage lastPage total } data { id name email } } }", $users[0]);

        $this->assertTrue($response->json('data.secureUsers.paginatorInfo.currentPage') == 1);
        $this->assertNotNull($response->json('data.secureUsers.paginatorInfo.lastPage'));
        $this->assertNotNull($response->json('data.secureUsers.paginatorInfo.total'));
        $this->assertNotNull($response->json('data.secureUsers.data.0.id'));
        $this->assertNotNull($response->json('data.secureUsers.data.0.name'));
        $this->assertNotNull($response->json('data.secureUsers.data.0.email'));
    }

    public function testUserListNonAuth()
    {
        factory(User::class, 33)->create();

        $response = $this->graphql("{ secureUsers(count:10) { paginatorInfo { currentPage lastPage total } data { id name email } } }");

        $this->assertNull($response->json('data.secureUsers'));
        $this->assertNotNull($response->json('errors.0.message'));
    }

    public function testUserGet()
    {
        $user = factory(User::class)->create();

        $response = $this->graphql("{ secureUser(id:{$user->id}) { id name email } }", $user);

        $response->assertSee($user->name);
        $this->assertNotNull($response->json('data.secureUser.id'));
        $this->assertNotNull($response->json('data.secureUser.name'));
        $this->assertNotNull($response->json('data.secureUser.email'));
    }

    public function testUserGetNonAuth()
    {
        $user = factory(User::class)->create();

        $response = $this->graphql("{ secureUser(id:{$user->id}) { id name email } }");

        $this->assertNull($response->json('data.secureUsers'));
        $this->assertNotNull($response->json('errors.0.message'));
    }

    public function testWrongUser()
    {
        $users = factory(User::class, 2)->create();

        $response = $this->graphql("{ secureUser(id:{$users[1]->id}) { id name email } }", $users[0]);

        $this->assertNull($response->json('data.secureUsers'));
        $this->assertNotNull($response->json('errors.0.message'));
    }
}
