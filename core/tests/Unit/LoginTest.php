<?php

namespace Tests\Unit;

use App\Models\Admin;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

	/**
		Redirection to Prefix
	*/
	public function testRedirectionToAdminPrefix()
	{
		$response = $this->get('/')->assertRedirect('/admin');
	}

	/**
		User view only login page if logged out
	*/
    public function testUserCanViewLoginPageWhenLoggedOut()
    {
    	$response = $this->get('/admin');
    	$response->assertSuccessful();
    	$response->assertViewIs('admin.other_layouts.login.login');
    }

    public function testUserCantViewLoginPageWhenLoggedIn()
    {
    	$admin = factory(Admin::class)->make();
        // $this->sessionStart();
    	$response = $this->actingAs($admin, 'web')->withSession(['applocalemodel' => 'ca'])->get('/');    				
    	$response = $response->assertRedirect('/admin/home');
    }
}
