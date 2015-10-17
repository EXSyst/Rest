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

interface VersionResolverInterface
{
    /**
     * Resolves the version of a request.
     *
     * @param Request $request
     *
     * @return scalar|false Current version or false if not found.
     */
    public function resolve(Request $request);
}
