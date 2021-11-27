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
 * SeedInterface
 */
interface SeedInterface
{
    /**
     * Set the locale.
     *
     * @param string $locale
     * @return static $this
     */    
    public function setLocale(string $locale): static;
    
    /**
     * Set the locale(s) for the current seed method call.
     *
     * @param null|string|array $locale
     *     null: default locale used
     *     string: specific locale
     *     array: [] uses all locales
     *     array: ['de', 'en'] sepcific locales
     * @return static $this
     */    
    public function locale(null|string|array $locale): static;
    
    /**
     * Returns the locale.
     *
     * @return string
     */    
    public function getLocale(): string;

    /**
     * Set the locale fallbacks. ['de-CH' => 'en-US']
     *
     * @param array<string, string> $localeFallbacks
     * @return static $this
     */    
    public function setLocaleFallbacks(array $localeFallbacks): static;
    
    /**
     * Returns the locale fallbacks.
     *
     * @return array<string, string>
     */    
    public function getLocaleFallbacks(): array;
    
    /**
     * Set the locale mapping. ['de' (requested) => '1' (stored)]
     *
     * @param array $localeMapping
     * @return static $this
     */    
    public function setLocaleMapping(array $localeMapping): static;
    
    /**
     * Returns the locale mapping.
     *
     * @return array
     */    
    public function getLocaleMapping(): array;

    /**
     * Set a random value for the current seed method call.
     *
     * @param mixed $value
     * @param int $probability Between 1 and 100
     * @return static $this
     */    
    public function random(mixed $value, int $probability = 10): static;
    
    /**
     * Adds a seeder.
     *
     * @param string $name
     * @param SeederInterface $seeder
     * @return static $this
     */    
    public function addSeeder(string $name, SeederInterface $seeder): static;
    
    /**
     * Adds a callable seeder.
     *
     * @param string $method
     * @param callable $seeder
     * @return static $this
     */    
    public function addCallableSeeder(string $method, callable $seeder): static;
    
    /**
     * Returns the seeder or null if not exists.
     *
     * @param string $name
     * @return SeederInterface $seeder
     * @throws SeederNotFoundException
     */    
    public function seeder(string $name): SeederInterface;
    
    /**
     * Returns the items of the specified resource.
     * If multiple locales specified, it merges items.
     *
     * @param string $name The resource name.
     * @param null|string|array $locale
     *     null: default locale used
     *     string: specific locale
     *     array: [] uses all locales
     *     array: ['de', 'en'] sepcific locales
     * @return array
     */
    public function getItems(string $name, null|string|array $locale = null): array;
    
    /**
     * Returns the resources.
     *
     * @return ResourcesInterface
     */
    public function resources(): ResourcesInterface;
}