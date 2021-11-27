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
use Tobento\Service\Seeder\ResourceFile;
use Tobento\Service\Seeder\ResourceInterface;
use Tobento\Service\Filesystem\File;

/**
 * ResourceFileTest
 */
class ResourceFileTest extends TestCase
{    
    public function testThatImplementsResourceInterface()
    {
        $resource = new ResourceFile(
            file: __DIR__.'/seeder/de-CH/countries.json', 
            locale: 'de-CH',
        );
        
        $this->assertInstanceOf(
            ResourceInterface::class,
            $resource
        );     
    }

    public function testWithFile()
    {        
        $resource = new ResourceFile(
            file: new File(__DIR__.'/seeder/de-CH/countries.json'),
            locale: 'de-CH'
        );
        
        $this->assertInstanceOf(
            ResourceInterface::class,
            $resource
        );        
    }
    
    public function testNameMethod()
    {        
        $resource = new ResourceFile(
            file: __DIR__.'/seeder/de-CH/countries.json', 
            locale: 'de-CH',
        );
        
        $this->assertSame(
            'countries',
            $resource->name()
        );         
    }
    
    public function testNameMethodWithSpecifiedName()
    {        
        $resource = new ResourceFile(
            file: __DIR__.'/seeder/de-CH/countries.json', 
            locale: 'de-CH', 
            resourceName: 'foo'
        );
        
        $this->assertSame(
            'foo',
            $resource->name()
        );         
    }
    
    public function testFileMethod()
    {
        $file = new File(__DIR__.'/seeder/de-CH/countries.json');
        
        $resource = new ResourceFile(
            file: $file,
            locale: 'de-CH'
        );
        
        $this->assertSame(
            $file,
            $resource->file()
        );         
    }
    
    public function testItemsMethodWithJsonFile()
    {
        $file = new File(__DIR__.'/seeder/de-CH/countries.json');
        
        $resource = new ResourceFile(
            file: $file,
            locale: 'de-CH'
        );
        
        $this->assertSame(
            ['Schweiz', 'Deutschland'],
            $resource->items()
        );         
    }
    
    public function testItemsMethodWithPhpFile()
    {
        $file = new File(__DIR__.'/seeder/en/countries.php');
        
        $resource = new ResourceFile(
            file: $file,
            locale: 'en'
        );
        
        $this->assertSame(
            ['Switzerland', 'Germany'],
            $resource->items()
        );         
    }      
}