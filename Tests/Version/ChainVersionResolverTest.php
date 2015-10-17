<?php

/*
 * This file is part of the Api package.
 *
 * (c) EXSyst
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EXSyst\Component\Api\Tests\Version;

use EXSyst\Component\Api\Version\ChainVersionResolver;
use EXSyst\Component\Api\Version\VersionResolverInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Ener-Getick <egetick@gmail.com>
 */
class ChainVersionResolverTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $this->assertInstanceof(
            VersionResolverInterface::class,
            new ChainVersionResolver([])
        );
    }

    public function testResolve()
    {
        $request = new Request();

        $resolver1 = $this->getMock(VersionResolverInterface::class);
        $resolver1->expects($this->any())
            ->method('resolve')
            ->with($request)
            ->willReturn(false);

        $resolver2 = $this->getMock(VersionResolverInterface::class);
        $resolver2->expects($this->at(0))
            ->method('resolve')
            ->with($request)
            ->willReturn(true);
        $resolver2->expects($this->at(1))
            ->method('resolve')
            ->with($request)
            ->willReturn(false);

        $resolver3 = $this->getMock(VersionResolverInterface::class);
        $resolver3->expects($this->any())
            ->method('resolve')
            ->with($request)
            ->willReturn(false);

        $resolver = new ChainVersionResolver([$resolver1]);
        $resolver->addResolver($resolver2);
        $resolver->addResolver($resolver3);

        $this->assertTrue($resolver->resolve($request));
        $this->assertFalse($resolver->resolve($request));
    }
}
