<?php

namespace App\Tests\Utils;

use App\Utils\Slugger;
use PHPUnit\Framework\TestCase;

class SluggerTest extends TestCase
{
    public function testSluggifyMethodWhenAGivenParamaterIsValid(): void
    {
        $slugger = new Slugger();
        $this->assertSame('toto-titi', $slugger->sluggify('ToTo Titi'));
    }
}
