<?php

namespace Tests\Unit;

use App\Exceptions\InsufficientFreddosException;
use App\QuoteCalculator;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class QuoteCalculatorTest extends TestCase
{
    private $quote_calculator;

    public function setUp()
    {
        $this->quote_calculator = new QuoteCalculator();
    }

    public function testEmptyQuote()
    {
        $quote = $this->quote_calculator->calculate([]);
        $this->assertSame(25, $quote);
    }

    public function testGnomeTrainCost()
    {
        $quote = $this->quote_calculator->calculate(['num_gnomes' => 2]);
        $this->assertSame(35, $quote);
    }

    public function testFountainCost()
    {
        $quote = $this->quote_calculator->calculate(['chocolate_fountains' => 1, 'chocolate_amount_freddos' => 1]);
        $this->assertSame(76, $quote);
    }

    public function testExceptionThrownWhenFountainWithoutFreddos()
    {
        $exception_thrown = false;

        try {
            $quote = $this->quote_calculator->calculate(['chocolate_fountains' => 1]);
        } catch (InsufficientFreddosException $e) {
            $exception_thrown = true;
        }

        $this->assertTrue($exception_thrown, 'InsufficientFreddosException should be thrown when chocolate fountain without any Freddos specified in quote parameters');
    }

    public function testAstroTurf()
    {
        // 4 per square smoot - 25 + 16
        $quote = $this->quote_calculator->calculate(['astro_width' => 2, 'astro_depth' => 2]);

        $this->assertSame(41, $quote);
    }

    public function testFreddos()
    {
        $quote = $this->quote_calculator->calculate(['chocolate_amount_freddos' => 2]);

        $this->assertSame(27, $quote);
    }

    public function testHedgeFund()
    {
        $quote = $this->quote_calculator->calculate(['hedge_fund_length' => 1]);

        $this->assertSame(100, $quote);
    }

    public function testExorcisms()
    {
        $quote = $this->quote_calculator->calculate(['exorcisms' => 1]);

        $this->assertSame(1025, $quote);
    }
}
