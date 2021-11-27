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
 * ResourceSeeder
 */
class ResourceSeeder extends Seeder
{
    /**
     * Create a new ResourceSeeder.
     *
     * @param SeedInterface $seed
     */    
    public function __construct(
        protected SeedInterface $seed,
    ) {}
    
    /**
     * Returns the seed method names the seeder provides.
     *
     * @return array<int, string>
     */    
    public function seeds(): array
    {
        return [
            'itemFrom', 'itemsFrom',
        ];
    }

    /**
     * Returns a randomly selected item from the specified resource items.
     *
     * @param string $resource The resource name
     * @return mixed
     */
    public function itemFrom(string $resource): mixed
    {
        $items = $this->seed->getItems($resource, $this->locale);

        if (!empty($items)) {
            return Arr::item($items);
        }
        
        return Lorem::word(number: 1);
    }
    
    /**
     * Returns randomly selected items from the specified resource items.
     *
     * @param string $resource The resource name
     * @param int $number The number of items
     * @param bool $unique     
     * @return mixed
     */
    public function itemsFrom(string $resource, int $number = 1, bool $unique = false): mixed
    {
        $items = $this->seed->getItems($resource, $this->locale);

        return Arr::items($items, $number, $unique);
    }    
}