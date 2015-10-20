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

use EXSyst\Component\Api\Normalizer\ExceptionNormalizer;
use EXSyst\Component\Api\Normalizer\NormalizedException;

/**
 * @author Ener-Getick <egetick@gmail.com>
 */
class ExceptionNormalizerTest extends AbstractExceptionNormalizerTest
{
    public function setUp()
    {
        $this->normalizer = new ExceptionNormalizer();
    }

    /**
     * @dataProvider exceptionProvider
     */
    public function testNormalization($exception, $debug, $expectedOutput)
    {
        $this->assertEquals($expectedOutput, $this->normalizer->normalize($exception, $debug));
    }

    /**
     * @dataProvider exceptionProvider
     */
    public function testSupports($exception, $debug)
    {
        $this->assertTrue($this->normalizer->supports($exception, $debug));
    }

    public function exceptionProvider()
    {
        return [
            [new \Exception('foo', 3), true, new NormalizedException([
                'code'    => 3,
                'message' => 'foo',
                'file'    => __FILE__,
                'line'    => __LINE__ - 4,
            ])],
            [new \LogicException('bar', 100), false, new NormalizedException([
                'code' => 100,
            ])],
            [new \RuntimeException('runtime', 134), true, new NormalizedException([
                'code'    => 134,
                'message' => 'runtime',
                'file'    => __FILE__,
                'line'    => __LINE__ - 4,
            ])],
        ];
    }
}
