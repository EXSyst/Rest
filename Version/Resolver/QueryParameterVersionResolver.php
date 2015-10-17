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

class QueryParameterVersionResolver extends AbstractVersionResolver
{
    /**
     * @var string
     */
    private $parameterName;

    /**
     * {@inheritdoc}
     *
     * @param string $parameterName
     */
    public function __construct(array $versions, $parameterName = 'version')
    {
        parent::__construct($versions);
        $this->parameterName = $parameterName;
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(Request $request)
    {
        if (!$request->query->has($this->parameterName)) {
            return false;
        }

        $currentVersion = $request->query->get($this->parameterName);
        $constraint = '^'.$currentVersion;

        return $this->satisfiedBy($constraint);
    }
}
