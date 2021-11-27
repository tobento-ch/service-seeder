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
use Tobento\Service\Seeder\Lorem;

/**
 * LoremTest
 */
class LoremTest extends TestCase
{    
    public function testWordMethod()
    {
        $this->assertSame(
            0,
            substr_count(Lorem::word(number: 1), ' ')
        );
        
        $this->assertSame(
            4,
            substr_count(Lorem::word(number: 5), ' ')
        );
        
        $this->assertSame(
            7,
            substr_count(Lorem::word(number: 8, separator: '/'), '/')
        );         
    }
    
    public function testWordsMethod()
    {
        $this->assertTrue(
            in_array(
                count(explode(' ', Lorem::words(minWords: 1, maxWords: 10))),
                range(1,10)
            )
        );

        $this->assertTrue(
            in_array(
                count(explode(' ', Lorem::words(minWords: 8, maxWords: 10))),
                range(8,10)
            )
        );
        
        $this->assertTrue(
            in_array(
                count(explode('/', Lorem::words(minWords: 1, maxWords: 1, separator: '/'))),
                [1]
            )
        );         
    }
    
    public function testSentenceMethod()
    {        
        $this->assertSame(
            1,
            substr_count(Lorem::sentence(number: 1), '.')
        );
        
        $this->assertSame(
            4,
            substr_count(Lorem::sentence(number: 4), '.')
        );        
    }
    
    public function testSlugMethod()
    {
        $this->assertTrue(
            in_array(
                count(explode('-', Lorem::slug(minWords: 8, maxWords: 10))),
                range(8,10)
            )
        );
        
        $this->assertTrue(
            in_array(
                count(explode('-', Lorem::slug(minWords: 2, maxWords: 3))),
                range(2,3)
            )
        );        
    }    
}