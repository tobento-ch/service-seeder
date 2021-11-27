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
 * Arr
 */
class Arr
{
    /**
     * Returns a randomly selected item from the specified items.
     *
     * @param array $items
     * @return mixed
     */
    public static function item(array $items): mixed
    {
        if (empty($items)) {
            return null;    
        }
        
        return $items[array_rand($items)];
    }
    
    /**
     * Returns randomly selected items from the specified items.
     *
     * @param array $items
     * @param int $number The number of items
     * @param bool $unique
     * @return mixed
     */
    public static function items(array $items, int $number = 1, bool $unique = false): mixed
    {
        $values = [];
        
        for ($i = 1; $i <= $number; $i++) {
            $values[] = static::item($items);
        }
        
        return $unique ? array_unique($values) : $values;
    }    
}