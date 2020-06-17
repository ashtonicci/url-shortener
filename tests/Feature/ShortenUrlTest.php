<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Url;

class ShortenUrlTest extends TestCase
{
    use RefreshDatabase;
    /** @test */ 
    public function a_url_can_be_inserted()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/urls',[
            'full_url' => 'https://google.com',
            'description' => 'this is a short link for google.com',
            'times_used' => 0,
        ]);
        $response->assertOk();
        $this->assertCount(1, Url::All());
    }
    /** @test */
    public function a_url_is_required()
    {
        $response = $this->post('/urls',[
            'full_url' => '',
        ]);
        $response->assertSessionHasErrors('full_url');
    }
    /** @test */
    public function a_shortened_url_cannot_be_submitted()
    {
        $response = $this->post('/urls',[
            'full_url' => 'http://url.app/passport',
            'description' => 'this is a short link for google.com',
            'times_used' => 0,
        ]);
        $response->assertOk();
        $this->assertCount(1, Url::All());
    }
}
