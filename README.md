# Seeder Service

Generating fake data customized for your PHP application needs.

## Table of Contents

- [Getting started](#getting-started)
	- [Requirements](#requirements)
    - [Highlights](#highlights)
- [Documentation](#documentation)
    - [Create Seed](#create-seed)
    - [Add Seeders](#add-seeders)
    - [Seed](#seed)
    - [Localization](#localization)
    - [Random Seeding](#random-seeding)
    - [Seeders](#seeders)
        - [Resource Seeder](#resource-seeder)
        - [DateTime Seeder](#datetime-seeder)
        - [User Seeder](#user-seeder)
        - [Create Custom Seeder](#create-custom-seeder)
    - [Resources](#resources)
        - [Create Resources](#create-resources)
        - [Add Resources](#add-resources)
        - [Filter Resources](#filter-resources)
        - [File Resource](#file-resource)
        - [Get Resources And Items](#get-resources-and-items)
    - [Files Resources](#files-resources)
        - [Create Files Resources](#create-files-resources)
        - [Directory Structure](#directory-structure)
        - [Supported Files](#supported-files)
        - [Supporting Other Files](#supporting-other-files)  
    - [Static Seeders](#static-seeders)
        - [Str Seeder](#str-seeder)
        - [Lorem Seeder](#lorem-seeder)
        - [Num Seeder](#num-seeder)
        - [Json Seeder](#json-seeder)
        - [Arr Seeder](#arr-seeder)
- [Credits](#credits)
___

# Getting started

Add the latest version of the Seeder service project running this command.

```
composer require tobento/service-seeder
```

## Requirements

- PHP 8.0 or greater

## Highlights

- Framework-agnostic, will work with any project
- Decoupled design
- Flexible managing your resource data to fit your application
- Easily extendable

# Documentation

Do only use for seeding. It will not generate cryptographically secure string and numbers as it focuses more on speed.

## Create Seed

```php
use Tobento\Service\Seeder\Seed;
use Tobento\Service\Seeder\Resources;
use Tobento\Service\Seeder\SeedInterface;

$seed = new Seed(
    resources: new Resources(),
    locale: 'en',
    localeFallbacks: ['de' => 'en'],
    localeMapping: ['de' => 'de-CH'],
);

var_dump($seed instanceof SeedInterface);
// bool(true)
```

## Add Seeders

```php
use Tobento\Service\Seeder\UserSeeder;

$seed->addSeeder(
    name: 'user',
    seeder: new UserSeeder($seed)
);
```

**Add callable seeder**

```php
use Tobento\Service\Seeder\SeedInterface;
use Tobento\Service\Seeder\Lorem;

$seed->addCallableSeeder(
    method: 'word',
    seeder: function(SeedInterface $seed, null|string|array $locale, array $params): string {
        return Lorem::word(...$params);
    }
);

$words = $seed->word(number: 2);
```

**Add callable seeder using resource items**

```php
use Tobento\Service\Seeder\Seed;
use Tobento\Service\Seeder\Resources;
use Tobento\Service\Seeder\Resource;
use Tobento\Service\Seeder\SeedInterface;
use Tobento\Service\Seeder\Arr;
use Tobento\Service\Seeder\Lorem;

$seed = new Seed(
    new Resources(
        new Resource('colors', 'en', [
            'blue', 'red', 'green', 'yellow', 'pink',
        ]),
        new Resource('colors', 'de', [
            'blau', 'rot', 'grün', 'gelb', 'pink',
        ]),        
    ),
);

$seed->addCallableSeeder(
    method: 'color',
    seeder: function(SeedInterface $seed, null|string|array $locale, array $params): string {
    
        $colors = $seed->getItems('colors', $locale);
        
        if (!empty($colors)) {
            return Arr::item($colors);
        }
        
        return ucfirst(Lorem::word(number: 1));
    }
);

// default locale used:
$color = $seed->color();

// specific locale:
$color = $seed->locale('de')->color();

// specific locales:
$color = $seed->locale(['en', 'de'])->color();

// all locales:
$color = $seed->locale([])->color();
```

## Seed

**seeding**

The Seed::class dynamically calls a seeder method to seed data. It throws a SeedMethodCallException if no seeder is found supporting the called method.

```php
use Tobento\Service\Seeder\Seed;
use Tobento\Service\Seeder\Resources;
use Tobento\Service\Seeder\Resource;
use Tobento\Service\Seeder\ResourceSeeder;
use Tobento\Service\Seeder\SeedMethodCallException;

$seed = new Seed(
    new Resources(
        new Resource('countries', 'en', [
            'Usa', 'Switzerland', 'Germany',
        ]),
    ),
);

$seed->addSeeder('resource', new ResourceSeeder($seed));

try {
    $value = $seed->itemFrom(resource: 'countries');    
    var_dump($value);
    // string(11) "Switzerland"
} catch (SeedMethodCallException $e) {
    // handle
}
```

**seeder**

You may use the **seeder** method to return a seeder added.

```php
use Tobento\Service\Seeder\Seed;
use Tobento\Service\Seeder\Resources;
use Tobento\Service\Seeder\Resource;
use Tobento\Service\Seeder\ResourceSeeder;
use Tobento\Service\Seeder\SeederInterface;
use Tobento\Service\Seeder\SeederNotFoundException;

$seed = new Seed(new Resources());

$seed->addSeeder('resource', new ResourceSeeder($seed));

try {
    var_dump($seed->seeder('resource') instanceof SeederInterface);
    // bool(true)
} catch (SeederNotFoundException $e) {
    // handle
}
```

**resources**

You may use the **resources** method to return the resources.

```php
use Tobento\Service\Seeder\Seed;
use Tobento\Service\Seeder\Resources;
use Tobento\Service\Seeder\ResourcesInterface;

$seed = new Seed(new Resources());

var_dump($seed->resources() instanceof ResourcesInterface);
// bool(true)
```

**getItems**

You may use the **getItems** method to return items of a specified resource. If multiple locales specified, it merges items.

```php
use Tobento\Service\Seeder\Seed;
use Tobento\Service\Seeder\Resources;
use Tobento\Service\Seeder\Resource;

$seed = new Seed(
    new Resources(
        new Resource('countries', 'en', [
            'Usa', 'Switzerland', 'Germany',
        ]),
    ),
);

$items = $seed->getItems(
    name: 'countries',
    locale: 'en', // null|string|array
);

var_dump($items);
// array(3) { [0]=> string(3) "Usa" [1]=> string(11) "Switzerland" [2]=> string(7) "Germany" }

// default locale used:
$items = $seed->getItems('countries');

// specific locale:
$items = $seed->getItems('countries', 'en');

// specific locales:
$items = $seed->getItems('countries', ['en']);

// all locales:
$items = $seed->getItems('countries', []);
```

## Localization

```php
use Tobento\Service\Seeder\Seed;
use Tobento\Service\Seeder\Resources;

$seed = new Seed(
    resources: new Resources(),
    locale: 'en',
    localeFallbacks: ['de' => 'en'],
    localeMapping: ['de' => 'de-CH'],
);

// set the default locale:
$seed->setLocale('de');

// get the default locale:
var_dump($seed->getLocale());
// string(2) "de"

// set the locale fallbacks:
$seed->setLocaleFallbacks(['de' => 'en']);

// get the locale fallbacks:
var_dump($seed->getLocaleFallbacks());
// array(1) { ["de"]=> string(2) "en" }

// set the locale mapping:
$seed->setLocaleMapping(['de' => 'de-CH']);

// get the locale mapping:
var_dump($seed->getLocaleMapping());
// array(1) { ["de"]=> string(5) "de-CH" }
```

**seeding**

Use the **locale** method before calling a seeder method to seed data from resources in the specific locale(s).

```php
use Tobento\Service\Seeder\Seed;
use Tobento\Service\Seeder\Resources;
use Tobento\Service\Seeder\Resource;
use Tobento\Service\Seeder\ResourceSeeder;

$seed = new Seed(
    new Resources(
        new Resource('countries', 'en', [
            'Usa', 'Switzerland', 'Germany',
        ]),
        new Resource('countries', 'de', [
            'Usa', 'Schweiz', 'Deutschland',
        ]),
    ),
);

$seed->addSeeder('resource', new ResourceSeeder($seed));

// default locale used:
var_dump($seed->itemFrom(resource: 'countries'));
// string(7) "Germany"

// specific locale:
var_dump($seed->locale('de')->itemFrom('countries'));
// string(7) "Schweiz"

// specific locales:
var_dump($seed->locale(['en', 'de'])->itemFrom('countries'));
// string(11) "Deutschland"

// all locales:
var_dump($seed->locale([])->itemFrom('countries'));
// string(3) "Usa"
```

## Random Seeding

You may use the **random** method before calling a seeder method to seed the specified value randomly by its probability percentage.

```php
use Tobento\Service\Seeder\Seed;
use Tobento\Service\Seeder\Resources;
use Tobento\Service\Seeder\Resource;
use Tobento\Service\Seeder\ResourceSeeder;

$seed = new Seed(
    new Resources(
        new Resource('countries', 'en', [
            'Usa', 'Switzerland', 'Germany',
        ]),
    ),
);

$seed->addSeeder('resource', new ResourceSeeder($seed));

$value = $seed->random(
    value: null,
    probability: 50 // between 0 (always get false) and 100 (always get true)
)->itemFrom(resource: 'countries');

var_dump($value);
// NULL
```

## Seeders

### Resource Seeder

The resource seeder provides handy methods to seed data using resource items. If no [Resoucres](#resoucres) for the methods are provided, it fallsback to [Lorem Seeder](#lorem-seeder) word(s) depending on methods.

```php
use Tobento\Service\Seeder\Seed;
use Tobento\Service\Seeder\Resources;
use Tobento\Service\Seeder\Resource;
use Tobento\Service\Seeder\ResourceSeeder;

$seed = new Seed(
    new Resources(
        new Resource('countries', 'en', [
            'Usa', 'Switzerland', 'Germany',
        ]),
        new Resource('countries', 'de', [
            'Usa', 'Schweiz', 'Deutschland',
        ]),
    ),
);

$seed->addSeeder('resource', new ResourceSeeder($seed));

// default locale used:
var_dump($seed->itemFrom(resource: 'countries'));
// string(7) "Germany"

// specific locale:
var_dump($seed->locale('de')->itemFrom('countries'));
// string(7) "Schweiz"

// specific locales:
var_dump($seed->locale(['en', 'de'])->itemFrom('countries'));
// string(11) "Deutschland"

// all locales:
var_dump($seed->locale([])->itemFrom('countries'));
// string(3) "Usa"
```

**Available methods**

| Method | Parameters | Description |
| --- | --- | --- |
| **itemFrom** | resource: 'countries' | Returns a randomly selected item from the specified resource items. |
| **itemsFrom** | resource: 'countries', number: 3, unique: true | Returns randomly selected items from the specified resource items. If unique is set to true, it might return fewer items number as specified. |

### DateTime Seeder

The DateTime seeder provides handy methods to seed DateTime data. You may visit [Dater Service](https://github.com/tobento-ch/service-dater#date-formatter) for more detail on the DateFormatter::class.

```php
use Tobento\Service\Seeder\Seed;
use Tobento\Service\Seeder\Resources;
use Tobento\Service\Seeder\DateTimeSeeder;
use Tobento\Service\Dater\DateFormatter;

$seed = new Seed(new Resources());

$df = new DateFormatter(
    locale: $seed->getLocale()
);

$seed->addSeeder('dateTime', new DateTimeSeeder($df));

$dateTime = $seed->dateTime(from: '-30 years', to: 'now');

var_dump($dateTime);
// object(DateTimeImmutable)#8 (3) { ["date"]=> string(26) "2015-11-29 14:55:24.000000" ["timezone_type"]=> int(3) ["timezone"]=> string(13) "Europe/Berlin" }

var_dump($seed->locale('de')->month(3, 6, 'MMM'));
// string(5) "März"

var_dump($seed->locale(['de', 'fr'])->weekday(1, 7, 'EEEE'));
// string(7) "Sonntag"
```

**Available methods**

| Method | Parameters | Description |
| --- | --- | --- |
| **dateTime** | from: '-30 years', to: 'now' | Returns a date time object between the specified from and to date. |
| **month** | from: 1, to: 12, pattern: 'MMMM' | Returns a month between the specified from and to month formatted by pattern. Pattern: 'M' = '1', 'MM' = '09', 'MMM' = 'Jan', 'MMMM' = 'January' |
| **weekday** | from: 1, to: 7, pattern: 'MMMM' | Returns a weekday between the specified from and to weekday formatted by pattern. Pattern: E, EE, or EEE = 'Tue', 'EEEE' = 'Tuesday', 'EEEEE' = 'T', 'EEEEEE' = 'Tu' |

### User Seeder

The user seeder provides handy methods to seed user data. If no [Resoucres](#resoucres) for the methods are provided, it fallsback to [Lorem Seeder](#lorem-seeder) word(s) depending on methods.

```php
use Tobento\Service\Seeder\Seed;
use Tobento\Service\Seeder\Resources;
use Tobento\Service\Seeder\Resource;
use Tobento\Service\Seeder\UserSeeder;

$seed = new Seed(
    new Resources(
        new Resource('countries', 'en', [
            'Usa', 'Switzerland', 'Germany',
        ]),
        new Resource('countries', 'de', [
            'Usa', 'Schweiz', 'Deutschland',
        ]),
    ),
);

$seed->addSeeder('user', new UserSeeder($seed));

// default locale used:
var_dump($seed->country());
// string(7) "Germany"

// specific locale:
var_dump($seed->locale('de')->country());
// string(7) "Schweiz"

// specific locales:
var_dump($seed->locale(['en', 'de'])->country());
// string(11) "Deutschland"

// all locales:
var_dump($seed->locale([])->country());
// string(3) "Usa"
```

**Available methods**

| Method | Parameters | Resource(s) Used | Description |
| --- | --- | --- | --- |
| **firstnameFemale** | | firstnamesFemale | Returns a random female firstname. |
| **firstnameMale** | | firstnamesMale | Returns a random male firstname. |
| **firstname** | | firstnamesFemale, firstnamesMale | Returns a random firstname. |
| **lastname** | | lastnames | Returns a random lastname. |
| **fullnameFemale** | separator: ' ' | firstnamesFemale, lastnames | Returns a random female fullname. |
| **fullnameMale** | separator: ' ' | firstnamesMale, lastnames | Returns a random male fullname. |
| **fullname** | | firstnamesFemale, firstnamesMale, lastnames | Returns a random fullname. |
| **firm** | | firms | Returns a random firm. |
| **street** | withNumber: false | streets | Returns a random street. |
| **postcode** | | postcodes | Returns a random postcode. |
| **city** | | cities | Returns a random city. |
| **country** | | countries | Returns a random country. |
| **email** | | domains, firstnamesFemale, firstnamesMale, lastnames | Returns a random email. |
| **smartphone** | | smartphones | Returns a random smartphone number. |
| **telephone** | | telephones | Returns a random telephone number. |
| **password** | |  | Returns a random password. |

### Create Custom Seeder

You may create a custom seeder for your application.

```php
use Tobento\Service\Seeder\Seeder;
use Tobento\Service\Seeder\Seed;
use Tobento\Service\Seeder\SeedInterface;
use Tobento\Service\Seeder\Resources;
use Tobento\Service\Seeder\Arr;
use Tobento\Service\Seeder\Lorem;

class CustomSeeder extends Seeder
{
    /**
     * Create a new CustomSeeder.
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
            'paymentMethod',
        ];
    }

    /**
     * Returns a randomly selected item from the specified resource items.
     *
     * @return mixed
     */
    public function paymentMethod(): mixed
    {
        // get items from resource.
        $items = $this->seed->getItems('payment_methods', $this->locale);

        if (empty($items)) {
            // if no payment_methods resource is defined fallback to:
            $items = ['invoice', 'creditcard', 'paypal'];
        }
        
        return Arr::item($items);
    }
}

$seed = new Seed(new Resources());
$seed->addSeeder('custom', new CustomSeeder($seed));

var_dump($seed->paymentMethod());
// string(6) "paypal"
```

## Resources

### Create Resources

```php
use Tobento\Service\Seeder\Resources;
use Tobento\Service\Seeder\ResourcesInterface;
use Tobento\Service\Seeder\Resource;

$resources = new Resources(
    new Resource(
        name: 'colors', 
        locale: 'en', 
        items: ['blue', 'red']
    ),
);

var_dump($resources instanceof ResourcesInterface);
// bool(true)
```

### Add Resources

You may add resources by using the **add** method:

**add resource**

```php
use Tobento\Service\Seeder\Resources;
use Tobento\Service\Seeder\Resource;

$resources = new Resources();

$resources->add(new Resource('colors', 'en', [
    'red', 'blue',
]));
```

**add resources**

```php
use Tobento\Service\Seeder\Resources;
use Tobento\Service\Seeder\Resource;

$resources = new Resources();

$resources->add(new Resources(
    new Resource('colors', 'en', [
        'red', 'blue',
    ]),
));
```

### Filter Resources

You may use the filter methods returning a new instance.

**filter**

```php
use Tobento\Service\Seeder\Resources;
use Tobento\Service\Seeder\Resource;
use Tobento\Service\Seeder\ResourceInterface;

$resources = new Resources(
    new Resource(
        name: 'colors', 
        locale: 'en', 
        items: ['blue', 'red']
    ),
    new Resource(
        name: 'colors', 
        locale: 'de', 
        items: ['blau', 'rot']
    ),
);

// filter by locale:
$resources = $resources->filter(
    fn(ResourceInterface $r): bool => $r->locale() === 'de'
);
```

**locale**

```php
use Tobento\Service\Seeder\Resources;
use Tobento\Service\Seeder\Resource;

$resources = new Resources(
    new Resource(
        name: 'colors', 
        locale: 'en', 
        items: ['blue', 'red']
    ),
    new Resource(
        name: 'colors', 
        locale: 'de', 
        items: ['blau', 'rot']
    ),
);

// filter by locale:
$resources = $resources->locale('en');
```

**locales**

```php
use Tobento\Service\Seeder\Resources;
use Tobento\Service\Seeder\Resource;

$resources = new Resources(
    new Resource(
        name: 'colors', 
        locale: 'en', 
        items: ['blue', 'red']
    ),
    new Resource(
        name: 'colors', 
        locale: 'de', 
        items: ['blau', 'rot']
    ),
);

// filter by locales:
$resources = $resources->locales(['en', 'de']);
```

**name**

```php
use Tobento\Service\Seeder\Resources;
use Tobento\Service\Seeder\Resource;

$resources = new Resources(
    new Resource(
        name: 'colors', 
        locale: 'en', 
        items: ['blue', 'red']
    ),
    new Resource(
        name: 'colors', 
        locale: 'de', 
        items: ['blau', 'rot']
    ),
);

// filter by name:
$resources = $resources->name('colors');
```

### File Resource

You may use the file resource to load data from json or php files.

```php
use Tobento\Service\Seeder\ResourceFile;
use Tobento\Service\Seeder\ResourceInterface;

$resource = new ResourceFile(
    file: __DIR__.'/seeder/countries.json', 
    locale: 'en', 
    resourceName: 'countries'
);

var_dump($resource instanceof ResourceInterface);
bool(true)
```

#### Supported files are json and php

**json**

```json
["Switzerland", "Germany"]
```

**php**

```php
return ['Switzerland', 'Germany'];
```

### Get Resources And Items

**all**

```php
use Tobento\Service\Seeder\Resources;
use Tobento\Service\Seeder\Resource;
use Tobento\Service\Seeder\ResourceInterface;

$resources = new Resources(
    new Resource(
        name: 'colors', 
        locale: 'en', 
        items: ['blue', 'red']
    ),
);

foreach($resources->all() as $resource) {
    var_dump($resource instanceof ResourceInterface);
    // bool(true)
    
    var_dump($resource->name());
    // string(6) "colors"
    
    var_dump($resource->locale());
    // string(2) "en"
    
    var_dump($resource->items());
    // array(2) { [0]=> string(4) "blue" [1]=> string(3) "red" }
}
```

**items**

```php
use Tobento\Service\Seeder\Resources;
use Tobento\Service\Seeder\Resource;

$resources = new Resources(
    new Resource(
        name: 'colors', 
        locale: 'en', 
        items: ['blue', 'red']
    ),
);

$items = $resources->locale('en')->items();

var_dump($items);
// array(2) { [0]=> string(4) "blue" [1]=> string(3) "red" }
```

> :warning: **You must call locale() or locales() before all() or items() method if you have added (sub or lazy) resources, otherwise they will not get loaded.**

```php
foreach($resources->locale('en')->all() as $resource) {
    var_dump($resource instanceof ResourceInterface);
    // bool(true)
}
```

## Files Resources

You may use the files resources to load resource data from a directory.

### Create Files Resources

```php
use Tobento\Service\Seeder\FilesResources;
use Tobento\Service\Dir\Dirs;
use Tobento\Service\Seeder\ResourcesInterface;

$resources = new FilesResources(
    (new Dirs())->dir(dir: 'private/seeder/')
);

var_dump($resources instanceof ResourcesInterface);
// bool(true)
```

### Directory Structure

```
private/
    seeder/
        en/
            countries.json
            firstnamesFemale.json
            firstnamesMale.php
        de-CH/
            countries.json
            firstnamesFemale.json
            firstnamesMale.php
```

### Supported Files

Currently supported files are json and php.

**json**

```json
["Switzerland", "Germany"]
```

**php**

```php
return ['Switzerland', 'Germany'];
```

### Supporting Other Files

You may support others files by providing your own resource factory:

```php
use Tobento\Service\Seeder\FilesResources;
use Tobento\Service\Dir\Dirs;
use Tobento\Service\Seeder\ResourceFactory;
use Tobento\Service\Seeder\ResourceInterface;
use Tobento\Service\Filesystem\File;

class CustomResourceFactory extends ResourceFactory
{
    /**
     * Create a new Resource from file.
     *
     * @param string|File $file
     * @param string $locale
     * @return ResourceInterface
     */    
    public function createResourceFromFile(
        string|File $file,
        string $locale,
    ): ResourceInterface {
        
        // Create your custom resource for the specific file extension
        
        // Otherwise use parent
        return parent::createResourceFromFile($file, $locale);
    }
}

$resources = new FilesResources(
    (new Dirs())->dir(dir: 'private/seeder/'),
    new CustomResourceFactory()
);
```

## Static Seeders

### Str Seeder

```php
use Tobento\Service\Seeder\Str;

$string = Str::string(length: 10);
```

**Available methods**

| Method | Parameters | Description |
| --- | --- | --- |
| **string** | length: 15, chars: 'abc123' | Generates a random string. If char parameter is specified it only uses those for generation. |
| **length** | min: 1, max: 8, chars: 'abc123' | Generates a random string between the min and max length with the chars specified. |
| **replace** | string: 'pattern', with: [] | Returns the string replaced with the parameters specified. |

**replace**

```php
use Tobento\Service\Seeder\Str;
use Tobento\Service\Seeder\Num;

$string = Str::replace(string: 'foo/bar', with: [
    'foo' => Num::int(1, 9),
    'bar' => Num::int(10, 20)
]);
```

### Lorem Seeder

```php
use Tobento\Service\Seeder\Lorem;

$string = Lorem::word(number: 10);
```

**Available methods**

| Method | Parameters | Description |
| --- | --- | --- |
| **word** | number: 10, separator: ' ' | Generates a random lorem word(s) in lowercase. |
| **words** | minWords: 1, maxWords: 10, separator: ' ' | Generates a random lorem words between the min and max words specified in lowercase. |
| **sentence** | number: 10 | Generates a random sentence(s). |
| **slug** | minWords: 1, maxWords: 10 | Generates a random slug between the min and max words specified. |

### Num Seeder

```php
use Tobento\Service\Seeder\Num;

$float = Num::float(min: 1.5, max: 55.5);
```

**Available methods**

| Method | Parameters | Description |
| --- | --- | --- |
| **bool** |  | Generates a random bool. |
| **int** | min: 1, max: 1000 | Generates a random int between the min and max specified. |
| **float** | min: 1.5, max: 55.5 | Generates a random float between the min and max specified. |
| **price** | min: 5, max: 80, precision: 0, step: 0.05 | Generates a random price between the min and max specified. If the precision parameter is not null, it rounds to the optional number of decimal digits. Use the step parameter for rounding in step. |

### Json Seeder

```php
use Tobento\Service\Seeder\Json;
use Tobento\Service\Seeder\Num;

$string = Json::encode([
    'tax_id' => Num::int(min: 1, max: 10),
    'price_net' => Num::price(min: 1, max: 10),
]);
```

**Available methods**

| Method | Parameters | Description |
| --- | --- | --- |
| **encode** | items: [] | Encodes the specified items to a json string. |
| **decode** | string: '' | Decodes the specified string to an array. |

### Arr Seeder

```php
use Tobento\Service\Seeder\Arr;

$value = Arr::item(['green', 'red', 'blue']);
```

**Available methods**

| Method | Parameters | Description |
| --- | --- | --- |
| **item** | items: [] | Randomly selects an item value from the items. |
| **items** | items: [], number: 3, unique: true | Randomly selects items value from the items. If unique is set to true, it might return fewer items number as specified. |

# Credits

- [Tobias Strub](https://www.tobento.ch)
- [All Contributors](../../contributors)