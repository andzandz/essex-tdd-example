<?php

namespace Tests\Feature;

use App\Http\Controllers\QuoteController;
use Mockery;
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

    // Gnomes

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
    public function testEmptyGnomeInput()
    {
        $response = $this->post('/getquote', ['num_gnomes' => '']);

        $this->assertResponseContains($response, '£25');
    }
    public function testNegativeGnomeInput()
    {
        $this->get('/getquote');
        $response = $this->post('/getquote', ['num_gnomes' => '-2']);
        $response = $this->followRedirects($response);

        $this->assertResponseContains($response, 'Anti-gnomes are not allowed');
        $this->assertResponseDoesNotContain($response, 'Your Quote:');
    }

    // Chocolate fountains

    public function testChocolateFountainCost()
    {
        $response = $this->post('/getquote', ['chocolate_fountains' => 1]);

        $response->assertStatus(200);
        $this->assertResponseContains($response, '£75');
    }
    public function testNonNumericFountainInput()
    {
        $this->get('/getquote');
        $response = $this->post('/getquote', ['chocolate_fountains' => 'x']);
        $response = $this->followRedirects($response);

        $this->assertResponseContains($response, 'The number of fountains must be a number');
        $this->assertResponseDoesNotContain($response, 'Your Quote:');
    }
    public function testEmptyFountainInput()
    {
        $response = $this->post('/getquote', ['chocolate_fountains' => '']);

        $this->assertResponseContains($response, '£25');
    }
    public function testNegativeFountainInput()
    {
        $this->get('/getquote');
        $response = $this->post('/getquote', ['chocolate_fountains' => '-2']);
        $response = $this->followRedirects($response);

        $this->assertResponseContains($response, 'Anti-fountains are not allowed');
        $this->assertResponseDoesNotContain($response, 'Your Quote:');
    }

    // Astro turf

    public function testAstroTurf()
    {
        // 4 per square smoot: 25 + 16
        $response = $this->post('/getquote', ['astro_width' => 2, 'astro_depth' => 2]);

        $response->assertStatus(200);
        $this->assertResponseContains($response, '£41');
    }

    // Integration tests

    public function testQuoteControllerUsesReturnValueOfQuoteCalculator()
    {
        // Arrange
        $quote_calculator_spy = Mockery::spy()->shouldReceive('calculate')->andReturn(1000000)->getMock();

        $quote_controller = new QuoteController([
            'quote_calculator' => $quote_calculator_spy
        ]);

        app()->instance(QuoteController::class, $quote_controller);

        // Act
        $response = $this->post('/getquote', ['chocolate_fountains' => 1]);

        // Assert
        $quote_calculator_spy->shouldHaveReceived('calculate')->with([
            'chocolate_fountains' => '1'
        ]);
        
        $this->assertResponseContains($response, '£1000000');
    }
}
