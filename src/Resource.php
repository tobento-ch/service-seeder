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
 * Resource
 */
class Resource implements ResourceInterface
{    
    /**
     * Create a new Resource.
     *
     * @param string $name
     * @param string $locale
     * @param array $items
     */    
    public function __construct(
        protected string $name,
        protected string $locale,
        protected array $items,
    ) {}
    
    /**
     * Returns the resource name.
     *
     * @return string
     */    
    public function name(): string
    {
        return $this->name;
    }
    
    /**
     * Returns the resource locale.
     *
     * @return string
     */    
    public function locale(): string
    {
        return $this->locale;
    }
    
    /**
     * Returns the resource items.
     *
     * @return array
     */
    public function items(): array
    {        
        return $this->items;
    }
    
    /**
     * __get For array_column object support
     */
    public function __get(string $prop)
    {
        return $this->{$prop}();
    }

    /**
     * __isset For array_column object support
     */
    public function __isset(string $prop): bool
    {
        return method_exists($this, $prop);
    }
}