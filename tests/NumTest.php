<?php

/**
 * TOBENTO
 *
 * @copyright   Tobias Strub, TOBENTO
 * @license     MIT License, see LICENSE file distributed with this source code.
 * @author      Tobias Strub
 * @link        https://www.tobento.ch
 */

declare(strict_types=1);

namespace Tobento\Service\Seeder\Test;

use PHPUnit\Framework\TestCase;
use Tobento\Service\Seeder\Num;
use InvalidArgumentException;

/**
 * NumTest
 */
class NumTest extends TestCase
{    
    public function testBoolMethod()
    {
        $this->assertTrue(is_bool(Num::bool()));
    }
    
    public function testIntMethod()
    {
        $this->assertTrue(is_int(Num::int(min: 1, max: 10)));
        
        $this->assertTrue(
            in_array(Num::int(min: 1, max: 1), [1])
        );
        
        $this->assertTrue(
            in_array(Num::int(min: 1, max: 2), range(1,2))
        );
        
        $this->assertTrue(
            in_array(Num::int(min: 2, max: 8), range(2,8))
        );        
    }
    
    public function testIntMethodThrowsInvalidArgumentException()
    {
        $this->expectException(InvalidArgumentException::class);
        
        Num::int(min: 11, max: 10);   
    }
    
    public function testFloatMethod()
    {
        $this->assertTrue(is_float(Num::float(min: 1.5, max: 10.5)));
        
        $this->assertTrue(
            in_array(Num::float(min: 1, max: 1), [1])
        );
        
        $float = Num::float(min: 1.1, max: 2.1);
            
        $this->assertTrue($float >= 1.1 && $float <= 2.1);   
    }
    
    public function testPriceMethod()
    {
        $price = Num::price(min: 1.1, max: 2.1);
        $this->assertTrue($price >= 1.1 && $price <= 2.1);
        
        $price = Num::price(min: 2.333, max: 2.333);        
        $this->assertSame(2.333, $price);
        
        $price = Num::price(min: 2.333, max: 2.333, precision: 2);        
        $this->assertSame(2.33, $price);
        
        $price = Num::price(min: 2.333, max: 2.333, precision: 2, step: 0.05);        
        $this->assertSame(2.35, $price);
        
        $price = Num::price(min: 2.333, max: 2.333, step: 0.05);        
        $this->assertSame(2.35, $price);        
    }    
}