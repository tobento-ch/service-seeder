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
use Tobento\Service\Seeder\ResourceFactory;
use Tobento\Service\Seeder\ResourceFactoryInterface;
use Tobento\Service\Filesystem\File;

/**
 * ResourceFactoryTest
 */
class ResourceFactoryTest extends TestCase
{    
    public function testThatImplementsResourceFactoryInterface()
    {
        $this->assertInstanceOf(
            ResourceFactoryInterface::class,
            new ResourceFactory()
        );     
    }

    public function testCreateResourceMethod()
    {
        $factory = new ResourceFactory();
        
        $resource = new Resource(
            name: 'colors',
            locale: 'en', 
            items: ['blue'],
        );
        
        $this->assertInstanceOf(
            ResourceInterface::class,
            $resource
        ); 
    }
    
    public function testCreateResourceFromFileMethod()
    {
        $factory = new ResourceFactory();
        
        $resource = $factory->createResourceFromFile(
            file: new File(__DIR__.'/seeder/de-CH/countries.json'),
            locale: 'de-CH',     
        );
        
        $this->assertInstanceOf(
            ResourceInterface::class,
            $resource
        );
        
        $this->assertSame(
            'countries',
            $resource->name()
        );         
    }
    
    public function testCreateResourceFromFileMethodWithSpecifiedResourceName()
    {
        $factory = new ResourceFactory();
        
        $resource = $factory->createResourceFromFile(
            file: new File(__DIR__.'/seeder/de-CH/countries.json'),
            locale: 'de-CH',
            resourceName: 'foo'
        );
        
        $this->assertSame(
            'foo',
            $resource->name()
        );         
    }    
    
    public function testCreateResourceFromFileMethodWithStringFile()
    {
        $factory = new ResourceFactory();
        
        $resource = $factory->createResourceFromFile(
            file: __DIR__.'/seeder/de-CH/countries.json',
            locale: 'de-CH',     
        );
        
        $this->assertInstanceOf(
            ResourceInterface::class,
            $resource
        ); 
    }
}