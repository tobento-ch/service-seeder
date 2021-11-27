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
use Tobento\Service\Seeder\SeederInterface;
use Tobento\Service\Seeder\UserSeeder;

/**
 * UserSeederTest
 */
class UserSeederTest extends TestCase
{    
    public function testThatImplementsSeederInterface()
    {
        $seed = new Seed(new Resources());

        $this->assertInstanceOf(
            SeederInterface::class,
            new UserSeeder($seed)
        );     
    }
    
    public function testFirstnameFemaleMethod()
    {
        $seed = new Seed(
            resources: new Resources(
                new Resource('firstnamesFemale', 'en', ['Hanna']),
                new Resource('firstnamesFemale', 'de', ['Tina']),
            ),
            locale: 'en',
        );

        $seed->addSeeder('user', new UserSeeder($seed));
        
        // default locale
        $this->assertSame('Hanna', $seed->firstnameFemale());
        
        // specific locale
        $this->assertSame('Tina', $seed->locale('de')->firstnameFemale());  
    }
    
    public function testFirstnameFemaleMethodWithResources()
    {
        $seed = new Seed(
            resources: new Resources(),
            locale: 'en',
        );

        $seed->addSeeder('user', new UserSeeder($seed));

        $this->assertTrue(is_string($seed->firstnameFemale()));
    }
    
    public function testFirstnameMaleMethod()
    {
        $seed = new Seed(
            resources: new Resources(
                new Resource('firstnamesMale', 'en', ['John']),
                new Resource('firstnamesMale', 'de', ['Werner']),
            ),
            locale: 'en',
        );

        $seed->addSeeder('user', new UserSeeder($seed));
        
        // default locale
        $this->assertSame('John', $seed->firstnameMale());
        
        // specific locale
        $this->assertSame('Werner', $seed->locale('de')->firstnameMale());  
    }
    
    public function testFirstnameMaleMethodWithResources()
    {
        $seed = new Seed(
            resources: new Resources(),
            locale: 'en',
        );

        $seed->addSeeder('user', new UserSeeder($seed));

        $this->assertTrue(is_string($seed->firstnameMale()));
    }
    
    public function testFirstnameMethod()
    {
        $seed = new Seed(
            resources: new Resources(),
            locale: 'en',
        );

        $seed->addSeeder('user', new UserSeeder($seed));

        $this->assertTrue(is_string($seed->firstname()));
    }
    
    public function testLastnameMethod()
    {
        $seed = new Seed(
            resources: new Resources(
                new Resource('lastnames', 'en', ['Pitt']),
                new Resource('lastnames', 'de', ['Wegmann']),
            ),
            locale: 'en',
        );

        $seed->addSeeder('user', new UserSeeder($seed));
        
        // default locale
        $this->assertSame('Pitt', $seed->lastname());
        
        // specific locale
        $this->assertSame('Wegmann', $seed->locale('de')->lastname());
    }
    
    public function testLastnameMethodWithResources()
    {
        $seed = new Seed(
            resources: new Resources(),
            locale: 'en',
        );

        $seed->addSeeder('user', new UserSeeder($seed));

        $this->assertTrue(is_string($seed->lastname()));
    }
    
    public function testFullnameFemaleMethod()
    {
        $seed = new Seed(
            resources: new Resources(
                new Resource('firstnamesFemale', 'en', ['Hanna']),
                new Resource('firstnamesFemale', 'de', ['Tina']),                
                new Resource('lastnames', 'en', ['Pitt']),
                new Resource('lastnames', 'de', ['Wegmann']),
            ),
            locale: 'en',
        );

        $seed->addSeeder('user', new UserSeeder($seed));

        // default locale
        $this->assertSame('Hanna Pitt', $seed->fullnameFemale());
        
        // specific locale
        $this->assertSame('Tina Wegmann', $seed->locale('de')->fullnameFemale());
        
        // with specific separator
        $this->assertSame('Hanna/Pitt', $seed->fullnameFemale('/'));
    }
    
    public function testFullnameFemaleMethodWithResources()
    {
        $seed = new Seed(
            resources: new Resources(),
            locale: 'en',
        );

        $seed->addSeeder('user', new UserSeeder($seed));

        $this->assertTrue(is_string($seed->fullnameFemale()));
    }
    
    public function testFullnameMaleMethod()
    {
        $seed = new Seed(
            resources: new Resources(
                new Resource('firstnamesMale', 'en', ['John']),
                new Resource('firstnamesMale', 'de', ['Werner']),              
                new Resource('lastnames', 'en', ['Pitt']),
                new Resource('lastnames', 'de', ['Wegmann']),
            ),
            locale: 'en',
        );

        $seed->addSeeder('user', new UserSeeder($seed));

        // default locale
        $this->assertSame('John Pitt', $seed->fullnameMale());
        
        // specific locale
        $this->assertSame('Werner Wegmann', $seed->locale('de')->fullnameMale());
        
        // with specific separator
        $this->assertSame('John/Pitt', $seed->fullnameMale('/'));
    }
    
    public function testFullnameMaleMethodWithResources()
    {
        $seed = new Seed(
            resources: new Resources(),
            locale: 'en',
        );

        $seed->addSeeder('user', new UserSeeder($seed));

        $this->assertTrue(is_string($seed->fullnameMale()));
    }
    
    public function testFullnameMethod()
    {
        $seed = new Seed(
            resources: new Resources(),
            locale: 'en',
        );

        $seed->addSeeder('user', new UserSeeder($seed));

        $this->assertTrue(is_string($seed->fullname()));
    }
    
    public function testFirmMethod()
    {
        $seed = new Seed(
            resources: new Resources(           
                new Resource('firms', 'en', ['Intra']),
                new Resource('firms', 'de', ['Bohrer']),
            ),
            locale: 'en',
        );

        $seed->addSeeder('user', new UserSeeder($seed));

        // default locale
        $this->assertSame('Intra', $seed->firm());
        
        // specific locale
        $this->assertSame('Bohrer', $seed->locale('de')->firm());
    }
    
    public function testFirmMethodWithResources()
    {
        $seed = new Seed(
            resources: new Resources(),
            locale: 'en',
        );

        $seed->addSeeder('user', new UserSeeder($seed));

        $this->assertTrue(is_string($seed->firm()));
    }
    
    public function testStreetMethod()
    {
        $seed = new Seed(
            resources: new Resources(           
                new Resource('streets', 'en', ['Sunset']),
                new Resource('streets', 'de', ['Muntstrasse']),
            ),
            locale: 'en',
        );

        $seed->addSeeder('user', new UserSeeder($seed));

        // default locale
        $this->assertSame('Sunset', $seed->street(withNumber: false));
        
        // specific locale
        $this->assertSame('Muntstrasse', $seed->locale('de')->street(withNumber: false));
    }
    
    public function testStreetMethodWithResources()
    {
        $seed = new Seed(
            resources: new Resources(),
            locale: 'en',
        );

        $seed->addSeeder('user', new UserSeeder($seed));

        $this->assertTrue(is_string($seed->street()));
    }
    
    public function testPostcodeMethod()
    {
        $seed = new Seed(
            resources: new Resources(),
            locale: 'en',
        );

        $seed->addSeeder('user', new UserSeeder($seed));

        $this->assertTrue(is_string($seed->postcode()));
    }
    
    public function testCityMethod()
    {
        $seed = new Seed(
            resources: new Resources(           
                new Resource('cities', 'en', ['Los Angeles']),
                new Resource('cities', 'de', ['Bern']),
            ),
            locale: 'en',
        );

        $seed->addSeeder('user', new UserSeeder($seed));

        // default locale
        $this->assertSame('Los Angeles', $seed->city());
        
        // specific locale
        $this->assertSame('Bern', $seed->locale('de')->city());
    }
    
    public function testCityMethodWithResources()
    {
        $seed = new Seed(
            resources: new Resources(),
            locale: 'en',
        );

        $seed->addSeeder('user', new UserSeeder($seed));

        $this->assertTrue(is_string($seed->city()));
    }
    
    public function testCountryMethod()
    {
        $seed = new Seed(
            resources: new Resources(           
                new Resource('countries', 'en', ['USA']),
                new Resource('countries', 'de', ['Schweiz']),
            ),
            locale: 'en',
        );

        $seed->addSeeder('user', new UserSeeder($seed));

        // default locale
        $this->assertSame('USA', $seed->country());
        
        // specific locale
        $this->assertSame('Schweiz', $seed->locale('de')->country());
    }
    
    public function testCountryMethodWithResources()
    {
        $seed = new Seed(
            resources: new Resources(),
            locale: 'en',
        );

        $seed->addSeeder('user', new UserSeeder($seed));

        $this->assertTrue(is_string($seed->country()));
    } 
    
    public function testEmailMethod()
    {
        $seed = new Seed(
            resources: new Resources(           
                new Resource('domains', 'en', ['example.com']),
                new Resource('domains', 'de', ['example.de']),
                new Resource('firstnamesFemale', 'en', ['Tina']),
                new Resource('firstnamesFemale', 'de', ['Tina']),
                new Resource('firstnamesMale', 'en', ['Tina']),
                new Resource('firstnamesMale', 'de', ['Tina']),                
                new Resource('lastnames', 'en', ['Pitt']),
                new Resource('lastnames', 'de', ['Wegmann']),                  
            ),
            locale: 'en',
        );

        $seed->addSeeder('user', new UserSeeder($seed));

        // default locale
        $this->assertSame('tina.pitt@example.com', $seed->email());
        
        // specific locale
        $this->assertSame('tina.wegmann@example.de', $seed->locale('de')->email());
    }
    
    public function testEmailMethodWithResources()
    {
        $seed = new Seed(
            resources: new Resources(),
            locale: 'en',
        );

        $seed->addSeeder('user', new UserSeeder($seed));

        $this->assertTrue(is_string($seed->email()));
    }
    
    public function testSmartphoneMethod()
    {
        $seed = new Seed(
            resources: new Resources(           
                new Resource('smartphones', 'en', ['+0000']),
                new Resource('smartphones', 'de', ['+0001']),
            ),
            locale: 'en',
        );

        $seed->addSeeder('user', new UserSeeder($seed));

        // default locale
        $this->assertSame('+0000', $seed->smartphone());
        
        // specific locale
        $this->assertSame('+0001', $seed->locale('de')->smartphone());
    }
    
    public function testSmartphoneMethodWithResources()
    {
        $seed = new Seed(
            resources: new Resources(),
            locale: 'en',
        );

        $seed->addSeeder('user', new UserSeeder($seed));

        $this->assertTrue(is_string($seed->smartphone()));
    } 
    
    public function testTelephoneMethod()
    {
        $seed = new Seed(
            resources: new Resources(           
                new Resource('telephones', 'en', ['+0000']),
                new Resource('telephones', 'de', ['+0001']),
            ),
            locale: 'en',
        );

        $seed->addSeeder('user', new UserSeeder($seed));

        // default locale
        $this->assertSame('+0000', $seed->telephone());
        
        // specific locale
        $this->assertSame('+0001', $seed->locale('de')->telephone());
    }
    
    public function testTelephoneMethodWithResources()
    {
        $seed = new Seed(
            resources: new Resources(),
            locale: 'en',
        );

        $seed->addSeeder('user', new UserSeeder($seed));

        $this->assertTrue(is_string($seed->telephone()));
    } 
    
    public function testPasswordMethod()
    {
        $seed = new Seed(
            resources: new Resources(),
            locale: 'en',
        );

        $seed->addSeeder('user', new UserSeeder($seed));

        $this->assertTrue(is_string($seed->password()));
    }     
}