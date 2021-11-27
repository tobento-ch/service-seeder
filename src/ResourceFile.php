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
use Tobento\Service\Filesystem\JsonFile;

/**
 * Resource
 */
class ResourceFile extends Resource
{
    /**
     * @var array
     */
    protected array $items = [];
    
    /**
     * @var bool
     */
    protected bool $loaded = false;
    
    /**
     * Create a new ResourceFile.
     *
     * @param string|File $file
     * @param string $locale
     * @param null|string $resourceName
     */    
    public function __construct(
        protected string|File $file,
        protected string $locale,
        protected null|string $resourceName = null,
    ) {}
    
    /**
     * Returns the resource name.
     *
     * @return string
     */    
    public function name(): string
    {
        return $this->resourceName ?: $this->file()->getFilename();
    }

    /**
     * Returns the file.
     *
     * @return File
     */    
    public function file(): File
    {
        if (is_string($this->file)) {
            $this->file = new File($this->file);
        }
        
        return $this->file;
    }
    
    /**
     * Returns the resource items.
     *
     * @return array
     */    
    public function items(): array
    {
        if ($this->loaded) {
            return $this->items;
        }

        if ($this->file()->isExtension(['php', 'x-php'])) {
            $this->items = $this->loadPhpFile($this->file());
            $this->loaded = true;
        }

        if ($this->file()->isExtension(['json'])) {
            $this->items = (new JsonFile($this->file()->getFile()))->toArray();
            $this->loaded = true;
        }
        
        return $this->items ?: [];
    }
    
    /**
     * Load the translations from the php file
     *
     * @param File $file
     * @return array
     */
    protected function loadPhpFile(File $file): array
    {
        if (! $file->isFile()) {
            return [];
        }
            
        $items = require $file->getFile();
        
        return is_array($items) ? $items : [];
    }    
}