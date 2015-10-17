<?php

/*
 * This file is part of the Api package.
 *
 * (c) EXSyst
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EXSyst\Component\Api\Version;

use Symfony\Component\HttpFoundation\Request;

class ChainVersionResolver implements VersionResolverInterface
{
    /**
     * @var VersionResolverInterface[]
     */
    private $resolvers;

    /**
     * @var VersionResolverInterface[]
     */
    public function __construct(array $resolvers)
    {
        foreach ($resolvers as $resolver) {
            $this->addResolver($resolver);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(Request $request)
    {
        foreach ($this->resolvers as $resolver) {
            $version = $resolver->resolve($request);
            if ($version !== false) {
                return $version;
            }
        }

        return false;
    }

    /**
     * Adds a resolver.
     *
     * @param VersionResolverInterface $resolver
     */
    public function addResolver(VersionResolverInterface $resolver)
    {
        $this->resolvers[] = $resolver;
    }
}
