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

use EXSyst\Component\Api\Normalizer\NormalizedException;

/**
 * @author Ener-Getick <egetick@gmail.com>
 */
class NormalizedExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testDefaultValues()
    {
        $exception = new NormalizedException();
        $this->assertEquals([], $exception->getParameters());
        $this->assertEquals(500, $exception->getStatusCode());
        $this->assertEquals([], $exception->getHeaders());
    }

    public function testParameters()
    {
        $exception = new NormalizedException(['foo' => 'bar', 'foobar' => 'f']);
        $exception->setParameter('a', 'z');
        $exception->setParameter('foo', 'v');
        $exception->setParameter('body', ['head', 'foot', '...']);

        $this->assertEquals([
            'foo'    => 'v',
            'foobar' => 'f',
            'a'      => 'z',
            'body'   => ['head', 'foot', '...'],
        ], $exception->getParameters());
    }

    /**
     * @expectedException EXSyst\Component\Api\Exception\InvalidArgumentException
     * @expectedExceptionMessage array and scalar values
     */
    public function testInvalidParameters()
    {
        new NormalizedException(['foo', ['bar', new \stdClass()]]);
    }

    public function testStatusCode()
    {
        $exception = new NormalizedException([], 404);
        $this->assertEquals(404, $exception->getStatusCode());

        $exception->setStatusCode(300);
        $this->assertEquals(300, $exception->getStatusCode());
    }

    public function testHeaders()
    {
        $exception = new NormalizedException([], 500, ['Accept' => 'application/json']);
        $this->assertEquals(['Accept' => 'application/json'], $exception->getHeaders());

        $exception->setHeaders(['Content-Type' => 'text/xml']);
        $this->assertEquals(['Content-Type' => 'text/xml'], $exception->getHeaders());
    }
}
