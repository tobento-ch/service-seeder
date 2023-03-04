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
 * UserSeeder
 */
class UserSeeder extends Seeder
{
    /**
     * Create a new UserSeeder.
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
            'firstnameFemale', 'firstnameMale', 'firstname', 'lastname', 'fullnameFemale', 'fullnameMale', 'fullname', 'firm', 'street', 'postcode', 'city', 'country', 'email', 'smartphone', 'telephone', 'password',
        ];
    }

    /**
     * Returns a female firstname.
     *
     * @return string
     */
    public function firstnameFemale(): string
    {
        $names = $this->seed->getItems('firstnamesFemale', $this->locale);

        if (!empty($names)) {
            return Arr::item($names);
        }
        
        return ucfirst(Lorem::word(number: 1));
    }
    
    /**
     * Returns a male firstname.
     *
     * @return string
     */
    public function firstnameMale(): string
    {
        $names = $this->seed->getItems('firstnamesMale', $this->locale);

        if (!empty($names)) {
            return Arr::item($names);
        }
        
        return ucfirst(Lorem::word(number: 1));
    }
    
    /**
     * Returns a firstname.
     *
     * @return string
     */
    public function firstname(): string
    {
        if (Num::bool()) {
            return $this->firstnameFemale();
        }
        
        return $this->firstnameMale();
    }    
    
    /**
     * Returns a lastname.
     *
     * @return string
     */
    public function lastname(): string
    {
        $names = $this->seed->getItems('lastnames', $this->locale);

        if (!empty($names)) {
            return Arr::item($names);
        }
        
        return ucfirst(Lorem::word(number: 1));
    }
    
    /**
     * Returns a female fullname.
     *
     * @param string $separator
     * @return string
     */
    public function fullnameFemale(string $separator = ' '): string
    {
        return implode($separator, [
            $this->firstnameFemale(),
            $this->lastname(),
        ]);
    }
    
    /**
     * Returns a male fullname.
     *
     * @param string $separator
     * @return string
     */
    public function fullnameMale(string $separator = ' '): string
    {
        return implode($separator, [
            $this->firstnameMale(),
            $this->lastname(),
        ]);
    }
    
    /**
     * Returns a fullname.
     *
     * @return string
     */
    public function fullname(): string
    {
        if (Num::bool()) {
            return $this->fullnameFemale();
        }
        
        return $this->fullnameMale();
    }
    
    /**
     * Returns a firm.
     *
     * @return string
     */
    public function firm(): string
    {
        $names = $this->seed->getItems('firms', $this->locale);

        if (!empty($names)) {
            return Arr::item($names);
        }
        
        return ucfirst(Lorem::word(number: 1));
    }
    
    /**
     * Returns a street.
     *
     * @param bool $withNumber
     * @return string
     */
    public function street(bool $withNumber = true): string
    {
        $streets = $this->seed->getItems('streets', $this->locale);

        if (!empty($streets)) {
            $street = Arr::item($streets);
        } else {
            $street = ucwords(Lorem::words(minWords: 1, maxWords: 3));
        }
        
        if ($withNumber) {
            return $street.' '.Num::int(1, 1000);
        }
        
        return $street;
    }
    
    /**
     * Returns a postcode.
     *
     * @return string
     */
    public function postcode(): string
    {
        $postcodes = $this->seed->getItems('postcodes', $this->locale);

        if (!empty($postcodes)) {
            return Arr::item($postcodes);
        }
        
        return (string) Num::int(1000, 100000);
    }
    
    /**
     * Returns a city name.
     *
     * @return string
     */    
    public function city(): string
    {
        $cities = $this->seed->getItems('cities', $this->locale);
        
        if (!empty($cities)) {
            return Arr::item($cities);
        }

        return ucwords(Lorem::words(minWords: 1, maxWords: 3));
    }
    
    /**
     * Returns a country name.
     *
     * @return string
     */    
    public function country(): string
    {
        $countries = $this->seed->getItems('countries', $this->locale);
        
        if (!empty($countries)) {
            return Arr::item($countries);
        }

        return ucfirst(Lorem::word(number: 1));
    }    
    
    /**
     * Returns an email.
     *
     * @param null|string $from If specified it creates email from
     * @return string
     */    
    public function email(null|string $from = null): string
    {
        if (!empty($from)) {
            $name = Str::replace($from, [' ' => '.']);
        } else {
            if (Num::bool()) {
                $name = $this->fullnameFemale('.');
            } else {
                $name = $this->fullnameMale('.');
            }            
        }
        
        $name = strtolower($name);
        
        $domains = $this->seed->getItems('domains', $this->locale);

        if (empty($domains)) {
            $domains = ['example.com', 'example.org', 'example.net'];
        }
        
        return $name.'@'.Arr::item($domains);
    }
    
    /**
     * Returns a smartphone.
     *
     * @return string
     */
    public function smartphone(): string
    {
        $phones = $this->seed->getItems('smartphones', $this->locale);

        if (!empty($phones)) {
            return Arr::item($phones);
        }
        
        return Num::int(100, 1000).'-'.Num::int(100, 1000).'-'.Num::int(100, 1000);
    }
    
    /**
     * Returns a telephone.
     *
     * @return string
     */
    public function telephone(): string
    {
        $phones = $this->seed->getItems('telephones', $this->locale);

        if (!empty($phones)) {
            return Arr::item($phones);
        }
        
        return Num::int(100, 1000).'-'.Num::int(100, 1000).'-'.Num::int(100, 1000);
    }
    
    /**
     * Returns a password.
     *
     * @return string
     */
    public function password(): string
    {
        return Str::length(
            8,
            20,
            '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ/-_:;%*"+#"?!{}=<>@&()[]');
    }
}