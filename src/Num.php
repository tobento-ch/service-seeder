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

use InvalidArgumentException;

/**
 * Num
 */
class Num
{
    /**
     * Returns a random int.
     *
     * @param int $min
     * @param int $max
     * @return int
     */
    public static function int(int $min, int $max): int
    {
        if ($min > $max) {
            throw new InvalidArgumentException('Argument #1 ($min) must be less than or equal to argument #2 ($max)');
        }
        
        return random_int($min, $max);
    }
    
    /**
     * Returns a random bool.
     *
     * @return bool
     */
    public static function bool(): bool
    {
        return (bool)random_int(0, 1);
    }
    
    /**
     * Returns a random float.
     *
     * @param float $min
     * @param float $max
     * @return float
     */
    public static function float(float $min, float $max): float
    {
        return ($min+lcg_value()*(abs($max-$min)));
    }
    
    /**
     * Returns a random price.
     *
     * @param float $min
     * @param float $max
     * @param null|int $precision
     * @param float $step For CHF you might want the step 0.05
     * @return float
     */
    public static function price(
        float $min,
        float $max,
        null|int $precision = null,
        float $step = 0
    ): float {
        $price = static::float($min, $max);
        
        if ($step != 0) {
            $price = round($price/$step, 0, \PHP_ROUND_HALF_UP)*$step;
        }
        
        if (is_null($precision)) {
            return $price;
        }
                
        return round($price, $precision);
    }
}