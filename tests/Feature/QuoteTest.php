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
        $this->assertGivenFormParamsNoQuoteGivenAndResponseContains(
            ['num_gnomes' => 'x'], 'The number of gnomes must be a number');
    }
    public function testEmptyGnomeInput()
    {
        $response = $this->post('/getquote', ['num_gnomes' => '']);

        $this->assertResponseContains($response, '£25');
    }
    public function testNegativeGnomeInput()
    {
        $this->assertGivenFormParamsNoQuoteGivenAndResponseContains(
            ['num_gnomes' => '-2'], 'Anti-gnomes are not allowed');
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
        $this->assertGivenFormParamsNoQuoteGivenAndResponseContains(
            ['chocolate_fountains' => 'x'], 'The number of fountains must be a number');
    }
    public function testEmptyFountainInput()
    {
        $response = $this->post('/getquote', ['chocolate_fountains' => '']);

        $this->assertResponseContains($response, '£25');
    }
    public function testNegativeFountainInput()
    {
        $this->assertGivenFormParamsNoQuoteGivenAndResponseContains(
            ['chocolate_fountains' => '-2'], 'Anti-fountains are not allowed');
    }

    // Astro turf

    public function testAstroTurf()
    {
        // 4 per square smoot: 25 + 16
        $response = $this->post('/getquote', ['astro_width' => 2, 'astro_depth' => 2]);

        $response->assertStatus(200);
        $this->assertResponseContains($response, '£41');
    }
    public function testNonNumericTurfWidthInput()
    {
        $this->assertGivenFormParamsNoQuoteGivenAndResponseContains(
            ['astro_width' => 'x'], 'The turf size must be a number');
    }
    public function testNonNumericTurfDepthInput()
    {
        $this->assertGivenFormParamsNoQuoteGivenAndResponseContains(
            ['astro_depth' => 'x'], 'The turf size must be a number');
    }
    public function testNegativeTurfWidthInput()
    {
        $this->assertGivenFormParamsNoQuoteGivenAndResponseContains(
            ['astro_width' => '-2'], 'Anti-turf is not allowed');
    }
    public function testNegativeTurfDepthInput()
    {
        $this->assertGivenFormParamsNoQuoteGivenAndResponseContains(
            ['astro_depth' => '-20'], 'Anti-turf is not allowed');
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

    // Helper functions

    private function assertGivenFormParamsNoQuoteGivenAndResponseContains($form_params, $response_needle)
    {
        $this->get('/getquote');
        $response = $this->post('/getquote', $form_params);
        $response = $this->followRedirects($response);

        $this->assertResponseContains($response, $response_needle);
        $this->assertResponseDoesNotContain($response, 'Your Quote:');
    }
}
