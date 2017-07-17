<?php

namespace Tests\Unit;

use App\Http\Controllers\QuoteController;
use Mockery;
use Tests\TestCase;
use Illuminate\Http\Request;

class QuoteControllerTest extends TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    public function testQuoteControllerUsesQuoteCalculator()
    {
        $request = Mockery::spy(Request::class)->shouldReceive('all')->andReturn([
            'chocolate_fountains' => '1'
        ])->getMock();

        $quote_calculator_spy = Mockery::spy();

        $quote_controller = new QuoteController([
            'quote_calculator' => $quote_calculator_spy
        ]);

        $quote_controller->calculate($request);

        $quote_calculator_spy->shouldHaveReceived('calculate')->with([
            'chocolate_fountains' => '1'
        ]);
    }
}
