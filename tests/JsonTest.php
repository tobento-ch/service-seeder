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

namespace Tobento\Service\Seeder\Test;

use PHPUnit\Framework\TestCase;
use Tobento\Service\Seeder\Json;

/**
 * JsonTest
 */
class JsonTest extends TestCase
{    
    public function testEncodeMethod()
    {
        $this->assertSame(
            '{"foo":"foo","bar":"bar"}',
            Json::encode([
                'foo' => 'foo',
                'bar' => 'bar',
            ])
        );
    }
    
    public function testDecodeMethod()
    {
        $this->assertSame(
            [
                'foo' => 'foo',
                'bar' => 'bar',
            ],
            Json::decode('{"foo":"foo","bar":"bar"}')
        );
    }    
}