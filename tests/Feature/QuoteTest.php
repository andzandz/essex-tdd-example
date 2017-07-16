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

    public function testGnomeTrainCost()
    {
        $response = $this->post('/getquote', ['num_gnomes' => 2]);

        $response->assertStatus(200);
        $this->assertResponseContains($response, '£35');
    }

    public function testNonNumericGnomeInput()
    {
        $this->get('/getquote');
        $response = $this->post('/getquote', ['num_gnomes' => 'x']);
        $response = $this->followRedirects($response);

        $this->assertResponseContains($response, 'The number of gnomes must be a number');
        $this->assertResponseDoesNotContain($response, 'Your Quote:');
    }

    public function testChocolateFountainCost()
    {
        $response = $this->post('/getquote', ['chocolate_fountains' => 1]);

        $response->assertStatus(200);
        $this->assertResponseContains($response, '£75');
    }
}
