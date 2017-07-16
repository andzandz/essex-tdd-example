<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function assertResponseContains($response, $needle)
    {
        $contains = !(strpos($response->content(), $needle) === false);

        $this->assertTrue($contains, "'$needle' not found in response content.");
    }
}
