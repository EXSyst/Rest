<?php

/*
 * This file is part of the Api package.
 *
 * (c) EXSyst
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EXSyst\Component\Api\Tests\Version\Resolver;

use EXSyst\Component\Api\Version\Resolver\RequestAttributeVersionResolver;
use EXSyst\Component\Api\Version\VersionResolverInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Ener-Getick <egetick@gmail.com>
 */
class RequestAttributeVersionResolverTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $this->assertInstanceof(
            VersionResolverInterface::class,
            new RequestAttributeVersionResolver([])
        );
    }

    public function testResolve()
    {
        $request = new Request();

        $resolver = new RequestAttributeVersionResolver([
            'v1.2.3' => [],
            '2.3'    => [],
        ]);

        $this->assertFalse($resolver->resolve($request));

        $request->attributes->set('version', 'v1');
        $this->assertEquals('v1.2.3', $resolver->resolve($request));

        $resolver = new RequestAttributeVersionResolver([
            'v2'   => [],
            'v2.4' => [],
        ]);
        $this->assertFalse($resolver->resolve($request));
    }
}
