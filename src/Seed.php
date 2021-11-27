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
 * Seed
 */
class Seed implements SeedInterface
{
    /**
     * @var array<string, SeederInterface|callable>
     */
    protected array $seeders = [];
    
    /**
     * @var array<string, string>
     */
    protected array $methodToSeeder = [];
    
    /**
     * @var array Caches items
     */
    protected array $items = [];
    
    /**
     * @var null|string|array
     */
    protected null|string|array $currentLocale = null;
    
    /**
     * @var null|array
     */
    protected null|array $random = null;
    
    /**
     * Create a new Seed.
     *
     * @param ResourcesInterface $resources
     * @param string $locale The default locale such as en-Us
     * @param array $localeFallbacks
     * @param array $localeMapping     
     */    
    public function __construct(
        protected ResourcesInterface $resources,
        protected string $locale = 'en',
        protected array $localeFallbacks = [],
        protected array $localeMapping = [],        
    ) {}
    
    /**
     * Set the locale.
     *
     * @param string $locale
     * @return static $this
     */    
    public function setLocale(string $locale): static
    {
        $this->locale = $locale;
        return $this;
    }
    
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
    public function locale(null|string|array $locale): static
    {
        $this->currentLocale = $locale;
        return $this;
    }    
    
    /**
     * Returns the locale.
     *
     * @return string
     */    
    public function getLocale(): string
    {
        return $this->locale;
    }    

    /**
     * Set the locale fallbacks. ['de-CH' => 'en-US']
     *
     * @param array<string, string> $localeFallbacks
     * @return static $this
     */    
    public function setLocaleFallbacks(array $localeFallbacks): static
    {
        $this->localeFallbacks = $localeFallbacks;
        return $this;
    }
    
    /**
     * Returns the locale fallbacks.
     *
     * @return array<string, string>
     */    
    public function getLocaleFallbacks(): array
    {
        return $this->localeFallbacks;
    }
    
    /**
     * Set the locale mapping. ['de' (requested) => '1' (stored)]
     *
     * @param array $localeMapping
     * @return static $this
     */    
    public function setLocaleMapping(array $localeMapping): static
    {
        $this->localeMapping = $localeMapping;
        return $this;
    }
    
    /**
     * Returns the locale mapping.
     *
     * @return array
     */    
    public function getLocaleMapping(): array
    {
        return $this->localeMapping;
    }
    
    /**
     * Set a random value for the current seed method call.
     *
     * @param mixed $value
     * @param int $probability Between 1 and 100
     * @return static $this
     */    
    public function random(mixed $value, int $probability = 10): static
    {
        $this->random = [$value, $probability];
        return $this;
    }
    
    /**
     * Adds a seeder.
     *
     * @param string $name
     * @param SeederInterface $seeder
     * @return static $this
     */    
    public function addSeeder(string $name, SeederInterface $seeder): static
    {
        $this->seeders[$name] = $seeder;
        
        foreach($seeder->seeds() as $method)
        {                
            if (method_exists($seeder, $method)) {
                $this->methodToSeeder[$method] = $name;
            }
        }
        
        return $this;
    }
    
    /**
     * Adds a callable seeder.
     *
     * @param string $method
     * @param callable $seeder
     * @return static $this
     */    
    public function addCallableSeeder(string $method, callable $seeder): static
    {
        $this->seeders[$method] = $seeder;
        $this->methodToSeeder[$method] = $method;
        return $this;
    }
    
    /**
     * Returns the seeder or null if not exists.
     *
     * @param string $name
     * @return SeederInterface $seeder
     * @throws SeederNotFoundException
     */    
    public function seeder(string $name): SeederInterface
    {
        if (
            isset($this->seeders[$name])
            && $this->seeders[$name] instanceof SeederInterface
        ) {
            return $this->seeders[$name];
        }
        
        throw new SeederNotFoundException($name, 'Seeder ['.$name.'] not found');
    }
    
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
     * @param bool $useFallback
     * @param bool $fallbackToDefault
     * @return array
     */
    public function getItems(
        string $name,
        null|string|array $locale = null,
        bool $useFallback = true,
        bool $fallbackToDefault = true
    ): array {
        if (is_array($locale)) {
            
            if (empty($locale)) {
                // uses all locales:           
                $locales = array_column(
                    $this->resources->name($name)->all(),
                    'locale'
                );
            } else {
                // sepcific locales:
                $locales = $locale;
            }
            
            $items = [];
            
            foreach($locales as $locale)
            {
                $items[] = $this->getItems($name, $locale, true, false);
            }
            
            return array_merge([], ...$items);
        }
        
        $locale = $locale ?: $this->getLocale();
        $locale = $this->localeMapping[$locale] ?? $locale;
        
        if (!empty($items = $this->fetchItems($name, $locale)))
        {
            return $items;
        }
        
        // If resource does not exist for the given locale, use the locale fallback if any.
        if ($this->getLocaleFallback($locale) && $useFallback)
        {            
            $locale = $this->getLocaleFallback($locale);        
            $locale = $this->localeMapping[$locale] ?? $locale;
            
            if (!empty($items = $this->fetchItems($name, $locale)))
            {
                return $items;
            }
        }
        
        if (! $fallbackToDefault) {
            return [];
        }

        // Fallback to default locale.
        if ($locale !== $this->locale)
        {            
            if (!empty($items = $this->fetchItems($name, $this->locale)))
            {
                return $items;
            }
        } 
        
        return [];
    }
    
    /**
     * Returns the resources.
     *
     * @return ResourcesInterface
     */
    public function resources(): ResourcesInterface
    {
        return $this->resources;
    }
    
    /**
     * Call the seeder method.
     *
     * @param string $methodName
     * @param array $parameters
     *
     * @throws SeedMethodCallException
     *
     * @return mixed
     */
    public function __call(string $methodName, array $parameters): mixed
    {
        // check if method exists.
        if (!isset($this->methodToSeeder[$methodName]))
        {
             throw new SeedMethodCallException(
                 $methodName,
                 'Method "'.$methodName.'" does not exist on.'
             );
        }
        
        // random method check.
        if (
            !is_null($this->random)
            && mt_rand(1, 100) <= $this->random[1]
        ) {
            $value = $this->random[0];
            $this->random = null; // reset
            return $value;
        }
        
        // call seeder method.
        $seeder = $this->seeders[$this->methodToSeeder[$methodName]];

        if ($seeder instanceof SeederInterface) {
            $seeder->locale($this->currentLocale);
            $value = $seeder->$methodName(...$parameters);
            $this->currentLocale = null;
            return $value;
        }
        
        $value = call_user_func_array(
            $seeder,
            [$this, $this->currentLocale, $parameters]
        );
        
        $this->currentLocale = null;
        return $value;        
    }

    /**
     * Returns the items from specified resource and locale.
     *
     * @param string $resource The resource name
     * @param string $locale The locale such as de-CH.
     * @return array<string, string>
     */
    protected function fetchItems(string $resource, string $locale): array
    {        
        // Loading resource once.
        if (isset($this->items[$resource][$locale])) {
            return $this->items[$resource][$locale];
        }

        return $this->items[$resource][$locale] = $this->resources->locale($locale)->name($resource)->items();
    } 
    
    /**
     * Returns the locale fallback for the specified locale or null if none.
     *
     * @param string $locale
     * @return null|string
     */    
    protected function getLocaleFallback(string $locale): null|string
    {
        return $this->localeFallbacks[$locale] ?? null;
    }    
}