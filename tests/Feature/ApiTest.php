<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiTest extends TestCase
{
    public function testFullEmptyPostRequest(){
        $response = $this->post('/api/convert');
        $response->assertStatus(400);

    }
    public function testPostRequestValid(){
        $response = $this->post('/api/convert',  ['userCard' => '22345678901234567890','points' => '1','command' => 'convert']);
        $response->assertStatus(200);
    }
    public function testPostInvalidCardRequest(){
        $response = $this->post('/api/convert',  ['userCard' => '290123420','points' => '1','command' => 'convert']);
        $response->assertStatus(400);
    }
    public function testPointsStringRequest(){
        $response = $this->post('/api/convert',  ['userCard' => '22345678901234567890','points' => 'string','command' => 'convert']);
        $response->assertStatus(400);
    }
    public function testEmptyCardRequest(){
        $response = $this->post('/api/convert',  ['userCard' => '','points' => 'string','command' => 'convert']);
        $response->assertStatus(400);
    }
    public function testEmptyPointsRequest(){
        $response = $this->post('/api/convert',  ['userCard' => '22345678901234567890','points' => '','command' => 'convert']);
        $response->assertStatus(400);
    }
    public function testEmptyCommandRequest(){
        $response = $this->post('/api/convert',  ['userCard' => '','points' => 'string','command' => '']);
        $response->assertStatus(400);
    }
}
