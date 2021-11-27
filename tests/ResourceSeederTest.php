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
use Tobento\Service\Seeder\Resources;
use Tobento\Service\Seeder\Resource;
use Tobento\Service\Seeder\ResourceSeeder;
use Tobento\Service\Seeder\SeederInterface;

/**
 * ResourceSeederTest
 */
class ResourceSeederTest extends TestCase
{    
    public function testThatImplementsSeederInterface()
    {
        $seed = new Seed(new Resources());

        $this->assertInstanceOf(
            SeederInterface::class,
            new ResourceSeeder($seed)
        );     
    }
    
    public function testItemFromMethodDefaultLocale()
    {
        $seed = new Seed(
            resources: new Resources(
                new Resource('colors', 'en', ['blue']),
                new Resource('colors', 'de', ['blau']),
            ),
            locale: 'en',
        );

        $seed->addSeeder('resource', new ResourceSeeder($seed));
        
        $this->assertSame(
            'blue',
            $seed->itemFrom('colors')
        );
    }
    
    public function testItemFromMethodSpecificLocale()
    {
        $seed = new Seed(
            resources: new Resources(
                new Resource('colors', 'en', ['blue']),
                new Resource('colors', 'de', ['blau']),
            ),
            locale: 'en',
        );

        $seed->addSeeder('resource', new ResourceSeeder($seed));
        
        $this->assertSame(
            'blau',
            $seed->locale('de')->itemFrom('colors')
        );
    }
    
    public function testItemFromMethodFallsbackToLoremStringIfResourceNotFound()
    {
        $seed = new Seed(
            resources: new Resources(),
            locale: 'en',
        );

        $seed->addSeeder('resource', new ResourceSeeder($seed));
        
        $this->assertTrue(
            is_string($seed->itemFrom('colors'))
        );
    }    
    
    public function testItemsFromMethodDefaultLocale()
    {
        $seed = new Seed(
            resources: new Resources(
                new Resource('colors', 'en', ['blue']),
                new Resource('colors', 'de', ['blau']),
            ),
            locale: 'en',
        );

        $seed->addSeeder('resource', new ResourceSeeder($seed));
        
        $this->assertSame(
            ['blue'],
            $seed->itemsFrom('colors')
        );
    }
    
    public function testItemsFromMethodSpecificLocale()
    {
        $seed = new Seed(
            resources: new Resources(
                new Resource('colors', 'en', ['blue']),
                new Resource('colors', 'de', ['blau']),
            ),
            locale: 'en',
        );

        $seed->addSeeder('resource', new ResourceSeeder($seed));
        
        $this->assertSame(
            ['blau'],
            $seed->locale('de')->itemsFrom('colors')
        );
    }
    
    public function testItemsFromMethodFallsbackToNullIfResourceNotFound()
    {
        $seed = new Seed(
            resources: new Resources(),
            locale: 'en',
        );

        $seed->addSeeder('resource', new ResourceSeeder($seed));
        
        $this->assertSame(
            [null],
            $seed->locale('de')->itemsFrom('colors')
        );
    }
    
    public function testItemsFromMethodWithSpecifiedNumber()
    {
        $seed = new Seed(
            resources: new Resources(
                new Resource('colors', 'en', ['blue']),
                new Resource('colors', 'de', ['blau']),
            ),
            locale: 'en',
        );

        $seed->addSeeder('resource', new ResourceSeeder($seed));
        
        $this->assertSame(
            ['blau', 'blau', 'blau'],
            $seed->locale('de')->itemsFrom('colors', 3)
        );
    }
    
    public function testItemsFromMethodWithSpecifiedNumberAndUniqueValues()
    {
        $seed = new Seed(
            resources: new Resources(
                new Resource('colors', 'en', ['blue']),
                new Resource('colors', 'de', ['blau']),
            ),
            locale: 'en',
        );

        $seed->addSeeder('resource', new ResourceSeeder($seed));
        
        $this->assertSame(
            ['blau'],
            $seed->locale('de')->itemsFrom('colors', 3, true)
        );
    }     
}