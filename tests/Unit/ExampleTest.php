<?php

namespace Tests\Unit;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * Basic assertion test to verify PHPUnit is working.
     *
     * @return void
     */
    public function test_basic_assertions_work()
    {
        $this->assertTrue(true);
        $this->assertFalse(false);
        $this->assertEquals(1, 1);
        $this->assertNotEquals(1, 2);
    }
}
