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

namespace Tobento\Service\Seeder;

use Tobento\Service\Dater\DateFormatter;
use DateTimeInterface;
use InvalidArgumentException;

/**
 * DateTimeSeeder
 */
class DateTimeSeeder extends Seeder
{
    /**
     * Create a new DateTimeSeeder.
     *
     * @param DateFormatter $dateFormatter
     */    
    public function __construct(
        protected DateFormatter $dateFormatter,
    ) {}
    
    /**
     * Returns the seed method names the seeder provides.
     *
     * @return array<int, string>
     */    
    public function seeds(): array
    {
        return [
            'dateTime', 'month', 'weekday',
        ];
    }

    /**
     * Returns a date time object between the specified from and to date.
     *
     * @param mixed $from
     * @param mixed $to
     * @return DateTimeInterface
     *
     * @psalm-suppress UndefinedInterfaceMethod
     */
    public function dateTime(mixed $from, mixed $to): DateTimeInterface
    {
        $df = $this->dateFormatter;
            
        if (!is_null($locale = $this->getRandomLocale($this->locale))) {
            $df = $this->dateFormatter->withLocale($locale);
        }
        
        $fromTimestamp = $df->toDateTime($from)->getTimestamp();
        $toTimestamp = $df->toDateTime($to)->getTimestamp();
        
        if ($fromTimestamp > $toTimestamp) {
            throw new InvalidArgumentException('Date from must be prior to date to.');
        }
        
        $timestamp = mt_rand($fromTimestamp, $toTimestamp);
        
        return $df->toDateTime('now')->setTimestamp($timestamp);
    }
        
    /**
     * Returns a month between the specified from and to month formatted by pattern.
     *
     * @param mixed $from
     * @param mixed $to
     * @param mixed $pattern The pattern. 'M' = '1', 'MM' = '09', 'MMM' = 'Jan', 'MMMM' = 'January'
     * @return string
     */
    public function month(
        int $from = 1,
        int $to = 12,
        string $pattern = 'MMMM'
    ): string {
        $df = $this->dateFormatter;
            
        if (!is_null($locale = $this->getRandomLocale($this->locale))) {
            $df = $this->dateFormatter->withLocale($locale);
        }
        
        $month = $df->toMonth(mt_rand($from, $to), $pattern);
        
        return $month ?: '';
    }
    
    /**
     * Returns a weekday between the specified from and to weekday formatted by pattern.
     *
     * @param mixed $from
     * @param mixed $to
     * @param mixed $pattern The pattern. E, EE, or EEE = 'Tue', 'EEEE' = 'Tuesday', 'EEEEE' = 'T', 'EEEEEE' = 'Tu'
     * @return string
     */
    public function weekday(
        int $from = 1,
        int $to = 7,
        string $pattern = 'EEEE'
    ): string {
        $df = $this->dateFormatter;
            
        if (!is_null($locale = $this->getRandomLocale($this->locale))) {
            $df = $this->dateFormatter->withLocale($locale);
        }
        
        $weekday = $df->toWeekday(mt_rand($from, $to), $pattern);
        
        return $weekday ?: '';
    }    
}