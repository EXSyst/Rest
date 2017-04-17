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

use EXSyst\Component\Api\Normalizer\ChainExceptionNormalizer;
use EXSyst\Component\Api\Normalizer\ExceptionNormalizerInterface;

/**
 * @author Ener-Getick <egetick@gmail.com>
 */
class ChainExceptionNormalizerTest extends AbstractExceptionNormalizerTest
{
    public function setUp()
    {
        $this->normalizer = new ChainExceptionNormalizer([]);
    }

    public function testNormalization()
    {
        $exception = new \Exception('bar');
        $normalizer1 = $this->createNormalizer(false, null, $exception, true);
        $normalizer2 = $this->createNormalizer(false, null, $exception, true);

        $this->normalizer->addNormalizer($normalizer1);
        $this->normalizer->addNormalizer($normalizer2);

        $this->assertNull($this->normalizer->normalize($exception, true));

        $normalizer3 = $this->createNormalizer(true, 'foobar', $exception, true);
        $this->normalizer->addNormalizer($normalizer3);

        $this->assertEquals('foobar', $this->normalizer->normalize($exception, true));
    }

    public function testNormalizationFromConstructorNormalizers()
    {
        $exception = new \Exception('bar');
        $normalizer1 = $this->createNormalizer(true, 'foobar', $exception, true);
        $normalizer = new ChainExceptionNormalizer([$normalizer1]);

        $this->assertEquals('foobar', $normalizer->normalize($exception, true));
    }

    public function testSupports()
    {
        $exception = new \Exception('foo');
        $normalizer1 = $this->createNormalizer(false, null, $exception, false);
        $normalizer2 = $this->createNormalizer(false, null, $exception, false);

        $this->normalizer->addNormalizer($normalizer1);
        $this->normalizer->addNormalizer($normalizer2);

        $this->assertFalse($this->normalizer->supports($exception, false));

        $normalizer3 = $this->createNormalizer(true, null, $exception, false);
        $this->normalizer->addNormalizer($normalizer3);

        $this->assertTrue($this->normalizer->supports($exception, false));
    }

    private function createNormalizer($supports, $return, \Exception $exception, $debug)
    {
        $normalizer = $this->getMock(ExceptionNormalizerInterface::class);

        $normalizer->expects($this->any())
            ->method('supports')
            ->with($exception, $debug)
            ->willReturn($supports);

        $normalizer->expects($this->any())
            ->method('normalize')
            ->with($exception, $debug)
            ->willReturn($return);

        return $normalizer;
    }
}
