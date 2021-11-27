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
 * ResourceInterface
 */
interface ResourceInterface
{
    /**
     * Returns the resource name.
     *
     * @return string
     */    
    public function name(): string;
    
    /**
     * Returns the resource locale.
     *
     * @return string
     */    
    public function locale(): string;
    
    /**
     * Returns the resource items.
     *
     * @return array
     */
    public function items(): array;
}