<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Admin;
use App\Models\Message;
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
        
        $response = $this->actingAs($admin, 'admin');
        $this->assertAuthenticatedAs($admin, 'admin');
        // dd([\Auth::check(), \Auth::guard('admin')->check()]);
        // dd(\Auth::guard('admin')->user()->profile_picture);
        $response->get(route('admin.login'))->assertRedirect(route('admin.home'));

        $result = $response->get(route('admin.home'))->assertSuccessful();

        $response->get(route('admin.home'))->assertViewIs('admin.other_layouts.home.home');
        $response->get(route('admin.home'))->assertViewHasAll(['allNews', 'weapons', 'gemPacks', 'coinPacks', 'treasures', 'allMessages', 'characters', 'animations', 'parachutes', 'bundlePacks']);



        // $response->get(route('admin.home'))->assertViewHas();
    

        /*
        $admin = Admin::first();
        
        $response = $this->post('/admin', [
            'username'=>'admin-1',
            'password'=>'123456',
        ]);
        
        $response->assertRedirect('admin/email-otp');
        */
    
    }

    /**
        Message View become updated after CRUD
    */
    public function testUpdationViewAfterCRUD()
    {
        $user = factory(Admin::class)->make();
        $response = $this->actingAs($user, 'admin');

        $response->get(route('admin.view_messages'))->assertViewIs('admin.other_layouts.media.all_messages');

        $initialMessageTableView = $response->get(route('admin.view_messages'));

        $initialMessageNumber = substr_count($initialMessageTableView->getContent(),"<tr>");

        // dd($initialMessageNumber);

        $newMessage = factory(Message::class)->create();

        $finalMessageTableView = $response->get(route('admin.view_messages'));

        $finalMessageNumber = substr_count($finalMessageTableView->getContent(),"<tr>");

        $this->assertTrue($finalMessageNumber > $initialMessageNumber);

    }
}
