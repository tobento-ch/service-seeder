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
use Tobento\Service\Seeder\ResourcesInterface;
use Tobento\Service\Seeder\Resource;
use Tobento\Service\Seeder\ResourceInterface;

/**
 * ResourcesTest
 */
class ResourcesTest extends TestCase
{    
    public function testThatImplementsResourcesInterface()
    {
        $this->assertInstanceOf(
            ResourcesInterface::class,
            new Resources()
        );     
    }
    
    public function testAddResourceByConstructor()
    {
        $resource = new Resource(
            name: 'colors',
            locale: 'en', 
            items: ['blue'],
        );
        
        $resources = new Resources($resource);
        
        $this->assertSame(
            $resource,
            $resources->all()[0]
        );
    }

    public function testAddMethod()
    {
        $resource = new Resource(
            name: 'colors',
            locale: 'en', 
            items: ['blue'],
        );
        
        $resources = new Resources();
        $resources->add($resource);
            
        $this->assertSame(
            $resource,
            $resources->all()[0]
        );
    }
    
    public function testAddMethodWithResources()
    {
        $subresources = new Resources(
            new Resource(
                name: 'countries', 
                locale: 'en', 
                items: ['Switzerland'],
            ),  
        );   
        
        $resources = new Resources();
        $resources->add($subresources);
            
        $this->assertSame(
            'countries',
            $resources->locale('en')->all()[0]->name()
        );
    }    
    
    public function testFilterMethod()
    {
        $resources = new Resources(
            new Resource(
                name: 'countries', 
                locale: 'en', 
                items: ['Switzerland'],
            ),
            new Resource(
                name: 'colors',
                locale: 'de', 
                items: ['blue'],
            ),
        ); 

        $newResources = $resources->filter(
            fn(ResourceInterface $r): bool => $r->locale() === 'de'
        );
        
        $this->assertFalse($resources === $newResources);
        
        $this->assertSame(1, count($newResources->all()));
        
        $this->assertSame(
            'de',
            $newResources->all()[1]->locale()
        );
    }
    
    public function testLocaleMethod()
    {
        $resources = new Resources(
            new Resource(
                name: 'countries', 
                locale: 'en', 
                items: ['Switzerland'],
            ),
            new Resource(
                name: 'colors',
                locale: 'de', 
                items: ['blue'],
            ),  
        ); 

        $newResources = $resources->locale('de');

        $this->assertFalse($resources === $newResources);
        
        $this->assertSame(1, count($newResources->all()));
        
        $this->assertSame(
            'de',
            $newResources->all()[1]->locale()
        );
    }
    
    public function testLocalesMethod()
    {
        $resources = new Resources(
            new Resource(
                name: 'countries', 
                locale: 'en', 
                items: ['Switzerland'],
            ),
            new Resource(
                name: 'colors',
                locale: 'de', 
                items: ['blue'],
            ),
            new Resource(
                name: 'colors',
                locale: 'fr', 
                items: ['bleu'],
            ),            
        ); 

        $newResources = $resources->locales(['en', 'fr']);

        $this->assertFalse($resources === $newResources);
        
        $this->assertSame(2, count($newResources->all()));
        
        $this->assertSame(
            'en',
            $newResources->all()[0]->locale()
        );
        
        $this->assertSame(
            'fr',
            $newResources->all()[2]->locale()
        );        
    }
    
    public function testNameMethod()
    {
        $resources = new Resources(
            new Resource(
                name: 'countries', 
                locale: 'en', 
                items: ['Switzerland'],
            ),
            new Resource(
                name: 'colors',
                locale: 'de', 
                items: ['blue'],
            ),  
        ); 

        $newResources = $resources->name('colors');

        $this->assertFalse($resources === $newResources);
        
        $this->assertSame(1, count($newResources->all()));
        
        $this->assertSame(
            'colors',
            $newResources->all()[1]->name()
        );
    }
    
    public function testAllMethod()
    {
        $resources = new Resources(
            new Resource(
                name: 'countries', 
                locale: 'en', 
                items: ['Switzerland'],
            ),
            new Resource(
                name: 'colors',
                locale: 'de', 
                items: ['blue'],
            ),
        ); 

        $resource = new Resource(
            name: 'names', 
            locale: 'en', 
            items: ['John'],
        );

        $resources->add($resource);  
        
        $names = [];
        
        foreach($resources->all() as $resource) {
            $names[] = $resource->name();
        }
        
        $this->assertSame(
            ['countries', 'colors', 'names'],
            $names
        );     
    }
    
    public function testItemsMethod()
    {
        $resources = new Resources(
            new Resource(
                name: 'countries', 
                locale: 'en', 
                items: ['Switzerland'],
            ),
            new Resource(
                name: 'colors',
                locale: 'de', 
                items: ['blue'],
            ),  
        ); 
        
        $this->assertSame(
            [
                'Switzerland',
                'blue',
            ],
            $resources->items()
        );     
    }
}