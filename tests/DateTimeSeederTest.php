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
use Tobento\Service\Seeder\DateTimeSeeder;
use Tobento\Service\Dater\DateFormatter;
use DateTimeInterface;

/**
 * DateTimeSeederTest
 */
class DateTimeSeederTest extends TestCase
{    
    public function testThatImplementsSeederInterface()
    {
        $this->assertInstanceOf(
            SeederInterface::class,
            new DateTimeSeeder(new DateFormatter())
        );     
    }
    
    public function testDateTimeMethod()
    {
        $seed = new Seed(new Resources(), 'en');
        
        $df = new DateFormatter(locale: $seed->getLocale());
        
        $seed->addSeeder('dateTime', new DateTimeSeeder($df));
        
        $dateTime = $seed->dateTime(from: '-30 years', to: 'now');
        
        $this->assertInstanceOf(
            DateTimeInterface::class,
            $dateTime
        );
        
        $this->assertTrue(
            $df->inBetween('-30 years', 'now', $dateTime)
        );        
    }
    
    public function testMonthMethod()
    {
        $seed = new Seed(new Resources(), 'en');
        
        $df = new DateFormatter(locale: $seed->getLocale());
        
        $seed->addSeeder('dateTime', new DateTimeSeeder($df));
        
        $month = $seed->locale('de')->month(3, 6, 'MMM');
        
        $this->assertTrue(is_string($month));
        
        // overflow
        $month = $seed->locale('de')->month(13, 15, 'MMM');
        
        $this->assertTrue(is_string($month));         
    }
    
    public function testWeekdayMethod()
    {
        $seed = new Seed(new Resources(), 'en');
        
        $df = new DateFormatter(locale: $seed->getLocale());
        
        $seed->addSeeder('dateTime', new DateTimeSeeder($df));
        
        $weekday = $seed->locale('de')->weekday(1, 7, 'EEEE');
        
        $this->assertTrue(is_string($weekday));
        
        // overflow
        $weekday = $seed->locale('de')->weekday(10, 17, 'EEEE');
        
        $this->assertTrue(is_string($weekday));         
    }     
}