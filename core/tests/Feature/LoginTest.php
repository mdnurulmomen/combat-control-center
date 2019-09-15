<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Admin;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{   
    // use RefreshDatabase;

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

        // dd($response->getContent());

        /*
        $response = $this->get('/admin/home');
        $response->assertRedirect('/admin');
        $response->assertStatus(302);
        */
    }

    /**
        @User Can view home page, when logged in
    */
    public function testUserCantViewLoginPageWhenLoggedIn()
    {       

        $admin = factory(Admin::class)->make();
        
        /*
        $response = $this->actingAs($admin, 'admin')->get('/admin')->assertRedirect('admin/home');
        $this->assertAuthenticatedAs($admin);
        */
        
        $response = $this->actingAs($admin, 'admin');
        // dd([\Auth::check(), \Auth::guard('admin')->check()]);
        $this->assertAuthenticatedAs($admin, 'admin');
        $response->get(route('admin.login'))->assertRedirect(route('admin.home'));
    
        // $this->withoutMiddleware();
        $response->get(route('admin.home'))->assertSuccessful();
        // $response->get(route('admin.home'))->assertViewIs('admin.other_layouts.home.home');
        // $response->assertViewHasAll(['username']);
        // $response->assertViewHasAll(['allNews', 'weapons']);
    

        /*
        $admin = Admin::first();
        
        $response = $this->post('/admin', [
            'username'=>'admin-1',
            'password'=>'123456',
        ]);
        
        $response->assertRedirect('admin/email-otp');
        */
    
    }

}
