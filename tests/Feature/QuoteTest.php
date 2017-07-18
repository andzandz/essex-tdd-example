<?php

namespace Tests\Feature;

use App\Exceptions\InsufficientFreddosException;
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
        $response = $this->post('/getquote',
            ['chocolate_fountains' => 1, 'chocolate_amount_freddos' => 1]);

        $response->assertStatus(200);
        $this->assertResponseContains($response, '£76');
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

    public function testInsufficientFreddos()
    {
        // Arrange
        $quote_calculator_spy = Mockery::spy()->shouldReceive('calculate')
            ->andThrow(InsufficientFreddosException::class)->getMock();

        $quote_controller = new QuoteController([
            'quote_calculator' => $quote_calculator_spy
        ]);

        app()->instance(QuoteController::class, $quote_controller);

        // Act
        $response = $this->post('/getquote', ['chocolate_fountains' => 1]);

        // Assert
        $this->assertResponseContains($response, 'You need some chocolate with that, buster');
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

    // Chocolate amount validation

    public function testNonNumericChocolateInput()
    {
        $this->assertGivenFormParamsNoQuoteGivenAndResponseContains(
            ['chocolate_amount_freddos' => 'x'], 'By law we only accept human numerals');
    }
    public function testEmptyChocolateInput()
    {
        $response = $this->post('/getquote', ['chocolate_amount_freddos' => '']);

        $this->assertResponseContains($response, '£25');
    }
    public function testNegativeChocolateInput()
    {
        $this->assertGivenFormParamsNoQuoteGivenAndResponseContains(
            ['chocolate_amount_freddos' => '-2'], 'Anti-chocolate is hazardous to your health');
    }

    // Hedge fund validation

    public function testNonNumericHedgeFundInput()
    {
        $this->assertGivenFormParamsNoQuoteGivenAndResponseContains(
            ['hedge_fund_length' => 'x'], 'This confuses me');
    }
    public function testEmptyHedgeFundInput()
    {
        $response = $this->post('/getquote', ['hedge_fund_length' => '']);

        $this->assertResponseContains($response, '£25');
    }
    public function testNegativeHedgeFundInput()
    {
        $this->assertGivenFormParamsNoQuoteGivenAndResponseContains(
            ['hedge_fund_length' => '-2'], "We can&#039;t help you if your hedge fund is in debt");
    }

    // Exorcisms validation

    public function testNonNumericExorcismsInput()
    {
        $this->assertGivenFormParamsNoQuoteGivenAndResponseContains(
            ['exorcisms' => 'x'], "But how many though?");
    }
    public function testEmptyExorcismsInput()
    {
        $response = $this->post('/getquote', ['exorcisms' => '']);

        $this->assertResponseContains($response, '£25');
    }
    public function testNegativeExorcismsInput()
    {
        $this->assertGivenFormParamsNoQuoteGivenAndResponseContains(
            ['exorcisms' => '-2'], "We can&#039;t currently exorcise extra-dimensional ghosts");
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

    public function testQuoteControllerPassesAllFormValuesToQuoteCalculatorAndUsesReturnValue()
    {
        // Arrange
        $quote_calculator_spy = Mockery::spy()->shouldReceive('calculate')->andReturn(123456)->getMock();

        $quote_controller = new QuoteController([
            'quote_calculator' => $quote_calculator_spy
        ]);

        app()->instance(QuoteController::class, $quote_controller);

        $form_parameters = [
            'num_gnomes' => 1,
            'chocolate_fountains' => 2,
            'astro_width' => 3,
            'astro_depth' => 4,
            'chocolate_amount_freddos' => 5,
            'hedge_fund_length' => 6,
            'exorcisms' => 7,
        ];

        // Act
        $response = $this->post('/getquote', $form_parameters);

        // Assert
        $quote_calculator_spy->shouldHaveReceived('calculate')->with($form_parameters);

        $this->assertResponseContains($response, '£123456');
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
