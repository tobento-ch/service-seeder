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
use Tobento\Service\Seeder\Str;
use InvalidArgumentException;

/**
 * StrTest tests
 */
class StrTest extends TestCase
{    
    public function testStringMethodReturnsSpecifiedLength()
    {
        $this->assertSame(15, strlen(Str::string(length: 15)));
        $this->assertSame(241, strlen(Str::string(length: 241)));
    }
    
    public function testStringMethodReturnsSpecifiedCharsOnly()
    {        
        $string = Str::string(chars: '123abc');
        
        $this->assertTrue(
            (bool)preg_match('/^[123abc]+$/', $string)
        );
    }
    
    public function testLengthMethod()
    {
        $this->assertTrue(
            in_array(strlen(Str::length(min: 1, max: 8)), range(1,8))
        );
        
        $this->assertTrue(
            in_array(strlen(Str::length(min: 1, max: 2)), range(1,2))
        );
        
        $this->assertTrue(
            in_array(strlen(Str::length(min: 1, max: 1)), [1])
        );     
    }
    
    public function testLengthMethodReturnsSpecifiedCharsOnly()
    {
        $string = Str::length(min: 1, max: 60, chars: '123abc');
        
        $this->assertTrue(
            (bool)preg_match('/^[123abc]+$/', $string)
        );
    }     
    
    public function testLengthMethodThrowsInvalidArgumentException()
    {
        $this->expectException(InvalidArgumentException::class);
        
        Str::length(min: 20, max: 10);       
    }
    
    public function testReplaceMethod()
    {
        $this->assertSame(
            '1/2',
            Str::replace(string: 'foo/bar', with: [
                'foo' => '1',
                'bar' => '2',
            ])
        );
        
        $this->assertSame(
            '1/:2',
            Str::replace(string: ':foo/:bar', with: [
                ':foo' => '1',
                'bar' => '2',
            ])
        );
        
        $this->assertSame(
            '1/2/1',
            Str::replace(string: 'foo/bar/foo', with: [
                'foo' => '1',
                'bar' => '2',
            ])
        );        
    }    
}