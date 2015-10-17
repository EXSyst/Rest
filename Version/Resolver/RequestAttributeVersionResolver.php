<?php

/*
 * This file is part of the Api package.
 *
 * (c) EXSyst
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EXSyst\Component\Api\Version\Resolver;

use Symfony\Component\HttpFoundation\Request;

class RequestAttributeVersionResolver extends AbstractVersionResolver
{
    /**
     * @var string
     */
    private $attributeName;

    /**
     * {@inheritdoc}
     *
     * @param string $attributeName
     */
    public function __construct(array $versions, $attributeName = 'version')
    {
        parent::__construct($versions);
        $this->attributeName = $attributeName;
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(Request $request)
    {
        if (!$request->attributes->has($this->attributeName)) {
            return false;
        }

        $currentVersion = $request->attributes->get($this->attributeName);
        $constraint = '^'.$currentVersion;

        return $this->satisfiedBy($constraint);
    }
}
