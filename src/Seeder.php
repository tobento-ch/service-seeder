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
 * Seeder
 */
abstract class Seeder implements SeederInterface
{
    /**
     * @var null|string|array
     */
    protected null|string|array $locale = null;
    
    /**
     * Returns the seed method names the seeder provides.
     *
     * @return array<int, string>
     */    
    abstract public function seeds(): array;
    
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
    public function locale(null|string|array $locale): static
    {
        $this->locale = $locale;
        return $this;
    }
    
    /**
     * Returns the locale specified or a random if locale is an array.
     *
     * @param null|string|array $locale
     *     null: default locale used
     *     string: specific locale
     *     array: [] uses all locales
     *     array: ['de', 'en'] sepcific locales
     * @return null|string
     */    
    protected function getRandomLocale(null|string|array $locale): null|string
    {
        if (is_null($locale) || is_string($locale)) {
            return $locale;
        }
        
        if (empty($locale)) {
            return null;
        }
        
        return Arr::item($locale);
    }    
}