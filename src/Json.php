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

use JsonException;

/**
 * Json
 */
class Json
{
    /**
     * Returns a the json encoded string from the specified items.
     *
     * @param array $items
     * @return string
     */
    public static function encode(array $items): string
    {
        try {
            return json_encode($items, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return '';
        }
    }
    
    /**
     * Returns a the json decoded array from the specified string.
     *
     * @param string $string
     * @return array
     */
    public static function decode(string $string): array
    {
        try {
            return json_decode($string, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return [];
        }
    }    
}