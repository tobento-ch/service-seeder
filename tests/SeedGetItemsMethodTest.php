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

/**
 * SeedGetItemsMethodTest
 */
class SeedGetItemsMethodTest extends TestCase
{    
    public function testUsesDefaultLocale()
    {
        $seed = new Seed(
            resources: new Resources(
                new Resource('colors', 'en', ['blue']),
                new Resource('colors', 'de', ['blau']),
            ),
            locale: 'en',
        );

        $this->assertSame(['blue'], $seed->getItems('colors'));
    }
    
    public function testUsesSpecificLocale()
    {
        $seed = new Seed(
            resources: new Resources(
                new Resource('colors', 'en', ['blue']),
                new Resource('colors', 'de', ['blau']),
            ),
            locale: 'en',
        );

        $this->assertSame(['blau'], $seed->getItems('colors', 'de'));
    }
    
    public function testUsesSpecificLocaleFallsbackToDefaultIfMissing()
    {
        $seed = new Seed(
            resources: new Resources(
                new Resource('colors', 'en', ['blue']),
            ),
            locale: 'en',
        );

        $this->assertSame(['blue'], $seed->getItems('colors', 'de'));
    }
    
    public function testUsesSpecificLocaleFallsbacksToSpecifiedFallback()
    {
        $seed = new Seed(
            resources: new Resources(
                new Resource('colors', 'en', ['blue']),
                new Resource('colors', 'fr', ['bleu']),
            ),         
            locale: 'en',
            localeFallbacks: ['de' => 'fr'],
        );

        $this->assertSame(['bleu'], $seed->getItems('colors', 'de'));
    }
    
    public function testUsesSpecificLocaleUsesMapping()
    {
        $seed = new Seed(
            resources: new Resources(
                new Resource('colors', 'en', ['blue']),
                new Resource('colors', 'de', ['blau']),
            ),         
            locale: 'en',
            localeMapping: ['de-CH' => 'de'],
        );

        $this->assertSame(['blau'], $seed->getItems('colors', 'de-CH'));
    }
    
    public function testUsesSpecificLocaleUsesMappingAndFallsbacksToSpecifiedFallback()
    {
        $seed = new Seed(
            resources: new Resources(
                new Resource('colors', 'en', ['blue']),
                new Resource('colors', 'fr', ['bleu']),
            ),         
            locale: 'en',
            localeFallbacks: ['de' => 'fr'],
            localeMapping: ['de-CH' => 'de'],
        );

        $this->assertSame(['bleu'], $seed->getItems('colors', 'de-CH'));
    }
    
    public function testUsesSpecificLocales()
    {
        $seed = new Seed(
            resources: new Resources(
                new Resource('colors', 'en', ['blue']),
                new Resource('colors', 'fr', ['bleu']),
            ),         
            locale: 'en',
        );

        $this->assertSame(['blue', 'bleu'], $seed->getItems('colors', ['en', 'fr']));
    }
    
    public function testUsesSpecificLocalesWithInvalidLocaleShouldNotFallbackToDefaultLocale()
    {
        $seed = new Seed(
            resources: new Resources(
                new Resource('colors', 'en', ['blue']),
                new Resource('colors', 'fr', ['bleu']),
            ),         
            locale: 'en',
        );

        $this->assertSame(['blue'], $seed->getItems('colors', ['en', 'de']));
    }
    
    public function testUsesSpecificLocalesWithInvalidLocaleUsesFallbacks()
    {
        $seed = new Seed(
            resources: new Resources(
                new Resource('colors', 'en', ['blue']),
                new Resource('colors', 'fr', ['bleu']),
            ),         
            locale: 'en',
            localeFallbacks: ['de' => 'fr'],
        );

        $this->assertSame(['blue', 'bleu'], $seed->getItems('colors', ['en', 'de']));
    }    
    
    public function testUsesAllLocales()
    {
        $seed = new Seed(
            resources: new Resources(
                new Resource('colors', 'en', ['blue']),
                new Resource('colors', 'fr', ['bleu']),
            ),         
            locale: 'en',
        );

        $this->assertSame(['blue', 'bleu'], $seed->getItems('colors', []));
    }    
}