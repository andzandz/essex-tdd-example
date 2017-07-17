<?php

namespace Tests\Unit;

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
        $quote = $this->quote_calculator->calculate(['chocolate_fountains' => 1]);
        $this->assertSame(75, $quote);
    }

    public function testAstroTurf()
    {
        // 4 per square smoot - 25 + 16
        $quote = $this->quote_calculator->calculate(['astro_width' => 2, 'astro_depth' => 2]);

        $this->assertSame(41, $quote);
    }
}