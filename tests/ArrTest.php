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
use Tobento\Service\Seeder\Arr;

/**
 * ArrTest
 */
class ArrTest extends TestCase
{    
    public function testItemMethod()
    {
        $this->assertSame(
            'green',
            Arr::item(['green'])
        );
        
        $this->assertSame(
            null,
            Arr::item([])
        );        
        
        $this->assertTrue(
            in_array(Arr::item(['green', 'blue']), ['green', 'blue'])
        );        
    }
    
    public function testItemsMethod()
    {
        $this->assertSame(
            ['green'],
            Arr::items(['green'], number: 1)
        );
        
        $this->assertSame(
            [null],
            Arr::items([], number: 1)
        );
        
        $this->assertSame(
            [null, null],
            Arr::items([], number: 2)
        );

        $this->assertSame(
            ['green', 'green'],
            Arr::items(['green', 'green'], number: 2)
        );
        
        $this->assertSame(
            ['green'],
            Arr::items(['green', 'green'], number: 2, unique: true)
        );
    }    
}