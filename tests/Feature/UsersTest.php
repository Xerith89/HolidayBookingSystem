<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class UsersTest extends TestCase
{
    use RefreshDatabase;
    
   /** @test */
   public function not_logged_in_does_not_see_dashboard()
   {
        $this->get('/dashboard')->assertRedirect('/');
   }

   /** @test */
   public function logged_in_does_not_see_index()
   {
        $this->actingAs(factory(User::class)->create());

        $response = $this->get('/')->assertRedirect('/dashboard');
   }

   /** @test */
   public function logged_in_sees_dashboard()
   {
        $this->actingAs(factory(User::class)->create());

        $this->get('/dashboard')->assertOk();
   }

   
}
