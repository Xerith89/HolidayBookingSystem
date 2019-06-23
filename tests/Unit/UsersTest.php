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
        $response = $this->get('/dashboard')->assertRedirect('/');
   }

   /** @test */
   public function logged_in_does_not_see_index()
   {
        $response = $this->actingAs(factory(User::class)->create());

        $response = $this->get('/')->assertRedirect('/dashboard');
   }

   /** @test */
   public function logged_in_sees_dashboard()
   {
        $response = $this->actingAs(factory(User::class)->create());

        $response = $this->get('/dashboard')->assertOk();
   }

   /** @test */
   public function user_can_be_added_through_form()
   {
        $response = $this->actingAs(factory(User::class)->create());

        $response = $this->post('/dashboard/users', [
        'name' => 'Alex Coupe',
        'email' => 'test@test.com',
        'staff_id' => 'AC001',        
        'admin_user' => 'True',
        'currentyear_holiday_entitlement' => '24.0',
        'currentyear_holiday_used'  => '0',
        'nextyear_holiday_entitlement'  => '24.0',
        'nextyear_holiday_used'  => '0',
        'pending_holiday_used'  => '0',
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);

        $this->assertCount(1, User::all());
   }


}
