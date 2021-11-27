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
use Tobento\Service\Seeder\Seed;
use Tobento\Service\Seeder\Resource;
use Tobento\Service\Seeder\ResourceInterface;

/**
 * ResourceTest
 */
class ResourceTest extends TestCase
{    
    public function testThatImplementsResourceInterface()
    {
        $this->assertInstanceOf(
            ResourceInterface::class,
            new Resource(
                name: 'colors',
                locale: 'en', 
                items: ['blue'],
            )
        );     
    }

    public function testNameMethod()
    {
        $resource = new Resource(
            name: 'colors',
            locale: 'en', 
            items: ['blue'],
        );
            
        $this->assertSame(
            'colors',
            $resource->name()
        );
    }
    
    public function testLocaleMethod()
    {
        $resource = new Resource(
            name: 'colors',
            locale: 'en', 
            items: ['blue'],
        );
            
        $this->assertSame(
            'en',
            $resource->locale()
        );
    }
    
    public function testItemsMethod()
    {
        $resource = new Resource(
            name: 'colors',
            locale: 'en', 
            items: ['blue'],
        );
            
        $this->assertSame(
            ['blue'],
            $resource->items()
        );
    }
}