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
 * SeederInterface
 */
interface SeederInterface
{
    /**
     * Returns the seed method names the seeder provides.
     *
     * @return array<int, string>
     */    
    public function seeds(): array;
    
    /**
     * Set the locale(s).
     *
     * @param null|string|array $locale
     *     null: default locale used
     *     string: specific locale
     *     array: [] uses all locales
     *     array: ['de', 'en'] sepcific locales
     * @return static $this
     */    
    public function locale(null|string|array $locale): static;    
}