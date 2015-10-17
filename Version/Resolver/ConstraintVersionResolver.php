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

class ConstraintVersionResolver extends AbstractVersionResolver
{
    /**
     * @var string
     */
    private $headerName;

    /**
     * {@inheritdoc}
     *
     * @param string $headerName
     */
    public function __construct(array $versions, $headerName = 'X-Accept-Version')
    {
        parent::__construct($versions);
        $this->headerName = $headerName;
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(Request $request)
    {
        if (!$request->headers->has($this->headerName)) {
            return false;
        }

        $constraint = $request->headers->get($this->headerName);

        return $this->satisfiedBy($constraint);
    }
}
