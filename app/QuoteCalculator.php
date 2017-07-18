<?php

namespace App;

use App\Exceptions\InsufficientFreddosException;

class QuoteCalculator
{
    private $base_cost = 25;
    private $gnome_cost = 5;
    private $chocolate_fountain_cost = 50;
    private $astro_turf_cost = 4;
    private $chocolate_freddo_cost = 1;
    private $hedge_fund_cost = 75;
    private $exorcism_cost = 1000;

    private function getOption($options, $key)
    {
        return $options[$key] ?? 0;
    }

    public function calculate($options)
    {
        if($this->getOption($options, 'chocolate_fountains') > 0
            && $this->getOption($options, 'chocolate_amount_freddos') == 0) {
            throw new InsufficientFreddosException();
        }

        return $this->base_cost
        + $this->getOption($options, 'num_gnomes') * $this->gnome_cost
        + $this->getOption($options, 'chocolate_fountains') * $this->chocolate_fountain_cost
        + $this->getOption($options, 'astro_width') * $this->getOption($options, 'astro_depth') * $this->astro_turf_cost
        + $this->getOption($options, 'chocolate_amount_freddos') * $this->chocolate_freddo_cost
        + $this->getOption($options, 'hedge_fund_length') * $this->hedge_fund_cost
        + $this->getOption($options, 'exorcisms') * $this->exorcism_cost;
    }
}