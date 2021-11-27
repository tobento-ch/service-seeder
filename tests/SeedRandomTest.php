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

/**
 * SeedRandomTest
 */
class SeedRandomTest extends TestCase
{    
    public function testRandomTrue()
    {
        $seed = new Seed(
            new Resources(
                new Resource('countries', 'en', [
                    'Usa',
                ]),
            ),
        );

        $seed->addSeeder('resource', new ResourceSeeder($seed));

        $value = $seed->random(
            value: 'foo',
            probability: 100 // between 0 (always get false) and 100 (always get true)
        )->itemFrom(resource: 'countries');
        
        $this->assertSame('foo', $value);        
    }
    
    public function testRandomFalse()
    {
        $seed = new Seed(
            new Resources(
                new Resource('countries', 'en', [
                    'Usa',
                ]),
            ),
        );

        $seed->addSeeder('resource', new ResourceSeeder($seed));

        $value = $seed->random(
            value: 'foo',
            probability: 0 // between 0 (always get false) and 100 (always get true)
        )->itemFrom(resource: 'countries');
        
        $this->assertSame('Usa', $value);        
    }    
}