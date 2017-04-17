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

use EXSyst\Component\Api\Normalizer\ExtendedExceptionNormalizer;
use EXSyst\Component\Api\Normalizer\NormalizedException;

/**
 * @author Ener-Getick <egetick@gmail.com>
 */
class ExtendedExceptionNormalizerTest extends AbstractExceptionNormalizerTest
{
    public function setUp()
    {
        $statusCodesMap = [
            'LogicException'   => 344,
            'RuntimeException' => 400,
        ];
        $messagesMap = [
            'InvalidArgumentException' => true,
            'LogicException'           => 'logic exception',
        ];
        $this->normalizer = new ExtendedExceptionNormalizer($statusCodesMap, $messagesMap);
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
                'code'    => 100,
                'message' => 'logic exception',
            ], 344)],
            [new \RuntimeException('my runtime exception', 134), false, new NormalizedException([
                'code' => 134,
            ], 400)],
            [new \InvalidArgumentException('my invalid arg exception', 1230), false, new NormalizedException([
                'code'    => 1230,
                'message' => 'my invalid arg exception',
            ], 344)],
        ];
    }
}
