<?php

namespace Tests\Feature;

use Tests\TestCase;

class QuoteTest extends TestCase
{
    public function testHomePage()
    {
        $response = $this->get('/');

        $this->assertResponseContains($response, 'GET YOUR QUOTE');
    }

    public function testQuote()
    {
        $response = $this->post('/getquote', []);

        $response->assertStatus(200);
        $this->assertResponseContains($response, '£25');
    }

    public function testQuotePageHasNoQuoteBeforeSubmitting()
    {
        $response = $this->get('/getquote');

        $response->assertStatus(200);
        $this->assertResponseDoesNotContain($response, 'Your Quote:');
    }
}
