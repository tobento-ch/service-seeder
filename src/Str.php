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

/**
 * Str
 */
class Str
{
    /**
     * Returns a random string with the chars specified.
     *
     * @param int $length
     * @param null|string $chars
     * @return string
     */
    public static function string(int $length = 15, null|string $chars = null): string
    {
        if (is_null($chars)) {
            $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }
        
        return substr(str_shuffle(str_repeat($chars, $length)), 0, $length);
    }
    
    /**
     * Returns a random string between the min and max length with the chars specified.
     *
     * @param int $min
     * @param int $max
     * @param null|string $chars
     * @return string
     */
    public static function length(int $min = 1, int $max = 10, null|string $chars = null): string
    {
        return static::string(Num::int($min, $max), $chars);
    }    
    
    /**
     * Returns the string replaced with the parameters specified.
     *
     * @param string $string
     * @param array $with
     * @return string
     */
    public static function replace(string $string, array $with): string
    {
        if (empty($with)) {
            return $string;
        }

        return strtr($string, $with);
    }
}