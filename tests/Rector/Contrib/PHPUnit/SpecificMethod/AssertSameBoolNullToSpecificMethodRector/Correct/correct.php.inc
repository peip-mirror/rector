<?php declare(strict_types=1);

final class MyTest extends \PHPUnit\Framework\TestCase
{
    public function test()
    {
        $this->assertNull('second argument');
        $this->assertFalse('second argument');
        $this->assertTrue('second argument');
    }
}