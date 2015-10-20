<?php

/*
 * This file is part of the Api package.
 *
 * (c) EXSyst
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EXSyst\Component\Api\Tests\Normalizer;

use EXSyst\Component\Api\Normalizer\ExceptionNormalizerInterface;

/**
 * @author Ener-Getick <egetick@gmail.com>
 */
abstract class AbstractExceptionNormalizerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ExceptionNormalizerInterface
     */
    protected $normalizer;

    public function setUp()
    {
        throw new \LogicException('You must define setUp().');
    }

    public function testInterface()
    {
        $this->assertInstanceOf(ExceptionNormalizerInterface::class, $this->normalizer);
    }
}
