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
use Tobento\Service\Seeder\SeedInterface;
use Tobento\Service\Seeder\Resources;
use Tobento\Service\Seeder\Resource;
use Tobento\Service\Seeder\SeederInterface;
use Tobento\Service\Seeder\SeederNotFoundException;
use Tobento\Service\Seeder\ResourceSeeder;
use Tobento\Service\Seeder\UserSeeder;
use Tobento\Service\Seeder\Arr;
use Tobento\Service\Seeder\Lorem;

/**
 * SeedTest
 */
class SeedTest extends TestCase
{    
    public function testThatImplementsSeedInterface()
    {
        $seed = new Seed(
            resources: new Resources(),
            locale: 'en',
            localeFallbacks: ['de' => 'en'],
            localeMapping: ['de' => 'de-CH'],
        );
        
        $this->assertInstanceOf(
            SeedInterface::class,
            $seed
        );
    }
    
    public function testSetAndGetLocale()
    {
        $seed = new Seed(
            resources: new Resources(),
            locale: 'en',
            localeFallbacks: ['de' => 'en'],
            localeMapping: ['de' => 'de-CH'],
        );
        
        $seed->setLocale('de');
        
        $this->assertSame(
            'de',
            $seed->getLocale()
        );     
    }
    
    public function testLocaleFallbacks()
    {
        $seed = new Seed(
            resources: new Resources(),
            locale: 'en',
            localeFallbacks: ['de' => 'fr'],
            localeMapping: ['de' => 'de-CH'],
        );
        
        $seed->setLocaleFallbacks(['de' => 'en']);
        
        $this->assertSame(
            ['de' => 'en'],
            $seed->getLocaleFallbacks()
        );     
    }
    
    public function testLocaleMapping()
    {
        $seed = new Seed(
            resources: new Resources(),
            locale: 'en',
            localeFallbacks: ['de' => 'fr'],
            localeMapping: ['de' => 'de-CH'],
        );
        
        $seed->setLocaleMapping(['de-DE' => 'de-CH', 'de' => 'de-CH']);
        
        $this->assertSame(
            ['de-DE' => 'de-CH', 'de' => 'de-CH'],
            $seed->getLocaleMapping()
        );     
    }     
    
    public function testAddSeederMethod()
    {
        $seed = new Seed(new Resources());
            
        $this->assertSame(
            $seed,
            $seed->addSeeder('user', new UserSeeder($seed))
        );
    }
    
    public function testAddCallableSeederMethod()
    {
        $seed = new Seed(new Resources());
        
        $seed->addCallableSeeder(
            method: 'word',
            seeder: function(SeedInterface $seed, null|string|array $locale, array $params): string {
                return 'foo';
            }
        );
        
        $this->assertSame(
            'foo',
            $seed->word()
        );
    }
    
    public function testAddCallableSeederMethodUsingResourceItemsAndLocales()
    {
        $seed = new Seed(
            new Resources(
                new Resource('colors', 'en', ['blue']),
                new Resource('colors', 'de', ['blau']),
            ),
        );

        $seed->addCallableSeeder(
            method: 'color',
            seeder: function(SeedInterface $seed, null|string|array $locale, array $params): string {

                $colors = $seed->getItems('colors', $locale);

                if (!empty($colors)) {
                    return Arr::item($colors);
                }

                return ucfirst(Lorem::word(number: 1));
            }
        );
        
        $this->assertSame('blue', $seed->color());
        $this->assertSame('blue', $seed->locale(null)->color());
        $this->assertSame('blau', $seed->locale('de')->color());
        $this->assertSame('blue', $seed->locale('fr')->color());
        $this->assertSame('blau', $seed->locale(['de'])->color());
    }
    
    public function testSeederMethod()
    {
        $seed = new Seed(new Resources());

        $seed->addSeeder('resource', new ResourceSeeder($seed));
        
        $this->assertTrue($seed->seeder('resource') instanceof SeederInterface);
    }
    
    public function testSeederMethodThrowsSeederNotFoundExceptionIfNotFound()
    {
        $this->expectException(SeederNotFoundException::class);
        
        $seed = new Seed(new Resources());
        $seed->seeder('resource');
    }
    
    public function testResourcesMethod()
    {
        $resources = new Resources();
        
        $seed = new Seed($resources);
        
        $this->assertSame($resources, $seed->resources());
    }
}