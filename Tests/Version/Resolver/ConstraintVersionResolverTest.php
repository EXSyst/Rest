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

use EXSyst\Component\Api\Version\Resolver\ConstraintVersionResolver;
use EXSyst\Component\Api\Version\VersionResolverInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Ener-Getick <egetick@gmail.com>
 */
class ConstraintVersionResolverTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $this->assertInstanceof(
            VersionResolverInterface::class,
            new ConstraintVersionResolver([])
        );
    }

    public function testResolve()
    {
        $request = new Request();

        $resolver = new ConstraintVersionResolver([
            'v2.2.2' => [],
            '1.34'   => [],
            'v1.1.2' => [],
        ]);

        $request->headers->set('X-Accept-Version', '~v1|^3.0');

        $request->headers->set('X-Accept-Version', '~v1|^3.0');
        $this->assertEquals('1.34', $resolver->resolve($request));

        $resolver = new ConstraintVersionResolver([
            '3.3'  => [],
            'v2.4' => [],
        ]);
        $this->assertEquals('3.3', $resolver->resolve($request));

        $resolver = new ConstraintVersionResolver([
            '5.3'  => [],
            'v2.4' => [],
        ]);
        $this->assertFalse($resolver->resolve($request));
    }
}
