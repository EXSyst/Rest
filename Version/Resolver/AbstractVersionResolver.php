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

use Composer\Semver\Semver;
use EXSyst\Component\Api\Version\VersionResolverInterface;

abstract class AbstractVersionResolver implements VersionResolverInterface
{
    /**
     * @var array
     */
    protected $versions;

    /**
     * @param array $versions ordered
     */
    public function __construct(array $versions)
    {
        $this->versions = $versions;
    }

    /**
     * @param string $constraint
     *
     * @return scalar|false
     */
    protected function satisfiedBy($constraint)
    {
        foreach ($this->versions as $version => $options) {
            if (Semver::satisfies($version, $constraint)) {
                return $version;
            }
        }

        return false;
    }
}
