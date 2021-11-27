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
use Tobento\Service\Seeder\FilesResources;
use Tobento\Service\Seeder\ResourcesInterface;
use Tobento\Service\Seeder\Resource;
use Tobento\Service\Seeder\ResourceInterface;
use Tobento\Service\Seeder\Resources;
use Tobento\Service\Seeder\ResourceFactory;
use Tobento\Service\Dir\Dirs;

/**
 * FilesResourcesTest
 */
class FilesResourcesTest extends TestCase
{    
    public function testThatImplementsResourcesInterface()
    {
        $this->assertInstanceOf(
            ResourcesInterface::class,
            new FilesResources(new Dirs())
        );     
    }

    public function testConstructorWithResourceFactory()
    {        
        $resources = new FilesResources(
            new Dirs(),
            new ResourceFactory()
        );
            
        $this->assertInstanceOf(
            ResourcesInterface::class,
            $resources
        );
    }
    
    public function testAddMethod()
    {
        $resource = new Resource(
            name: 'colors',
            locale: 'en', 
            items: ['blue'],
        );
        
        $resources = new FilesResources(new Dirs());
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
                name: 'colors',
                locale: 'en', 
                items: ['blue'],
            ),
        );
        
        $resources = new FilesResources(new Dirs());
        $resources->add($subresources);
            
        $this->assertSame(
            'colors',
            $resources->locale('en')->all()[0]->name()
        );
    }    
    
    public function testLocaleMethod()
    {
        $resources = new FilesResources(
            (new Dirs())->dir( __DIR__.'/seeder/')
        ); 

        $newResources = $resources->locale('de-CH');

        $this->assertFalse($resources === $newResources);
        
        $this->assertSame(1, count($newResources->all()));
        
        $this->assertSame(
            'de-CH',
            $newResources->all()[0]->locale()
        );
    }
    
    public function testLocalesMethod()
    {
        $resources = new FilesResources(
            (new Dirs())->dir( __DIR__.'/seeder/')
        ); 

        $newResources = $resources->locales(['de-CH', 'fr']);

        $this->assertFalse($resources === $newResources);
        
        $this->assertSame(1, count($newResources->all()));
        
        $this->assertSame(
            'de-CH',
            $newResources->all()[0]->locale()
        );       
    }
    
    public function testNameMethod()
    {
        $resources = new FilesResources(
            (new Dirs())->dir( __DIR__.'/seeder/')
        );

        $newResources = $resources->locale('en')->name('countries');

        $this->assertFalse($resources === $newResources);
        
        $this->assertSame(1, count($newResources->all()));
    }
    
    public function testAllMethod()
    {
        $resources = new FilesResources(
            (new Dirs())->dir( __DIR__.'/seeder/')
        );

        $resource = new Resource(
            name: 'colors',
            locale: 'de-CH', 
            items: ['blau'],
        );

        $resources->add($resource);  
        
        $names = [];
        
        foreach($resources->locale('de-CH')->all() as $resource) {
            $names[] = $resource->name();
        }
        
        $this->assertSame(
            ['colors', 'countries'],
            $names
        );     
    }
    
    public function testItemsMethod()
    {
        $resources = new FilesResources(
            (new Dirs())->dir( __DIR__.'/seeder/')
        );
        
        $this->assertSame(
            [
                'Switzerland',
                'Germany',
            ],
            $resources->locale('en')->items()
        );     
    }
}