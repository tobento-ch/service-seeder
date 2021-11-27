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

use Tobento\Service\Filesystem\File;

/**
 * ResourceFactory
 */
class ResourceFactory implements ResourceFactoryInterface
{    
    /**
     * Create a new Resource.
     *
     * @param string $name
     * @param string $locale
     * @param array $items
     * @return ResourceInterface
     */    
    public function createResource(
        string $name,
        string $locale,
        array $items,
    ): ResourceInterface {
        return new Resource($name, $locale, $items);
    }
    
    /**
     * Create a new Resource from file.
     *
     * @param string|File $file
     * @param string $locale
     * @param null|string $resourceName
     * @return ResourceInterface
     */
    public function createResourceFromFile(
        string|File $file,
        string $locale,
        null|string $resourceName = null,
    ): ResourceInterface {
        
        if (is_string($file)) {
            $file = new File($file);
        }
        
        return new ResourceFile($file, $locale, $resourceName);
    }
}