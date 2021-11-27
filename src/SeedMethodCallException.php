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

use Exception;
use Throwable;

/**
 * SeedMethodCallException
 */
class SeedMethodCallException extends Exception
{
    /**
     * Create a new SeedMethodCallException
     *
     * @param string $name The method name.
     * @param string $message
     * @param int $code
     * @param null|Throwable $previous
     */
    public function __construct(
        protected string $name,
        string $message = '',
        int $code = 0,
        null|Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
    
    /**
     * Returns the method name.
     *
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }
}