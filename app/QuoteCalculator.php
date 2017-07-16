<?php

namespace App;

class QuoteCalculator
{
    private $base_cost = 25;
    private $gnome_cost = 5;
    private $chocolate_fountain_cost = 50;
    private $astro_turf_cost = 4;

    private function getOption($options, $key)
    {
        return $options[$key] ?? 0;
    }

    public function calculate($options)
    {
        return $this->base_cost
        + $this->getOption($options, 'num_gnomes') * $this->gnome_cost
        + $this->getOption($options, 'chocolate_fountains') * $this->chocolate_fountain_cost
        + $this->getOption($options, 'astro_width') * $this->getOption($options, 'astro_depth') * $this->astro_turf_cost;
    }
}