<?php

/*
 * This file is part of the Api package.
 *
 * (c) EXSyst
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EXSyst\Component\Api\Normalizer;

/**
 * Normalize an exception.
 *
 * @author Ener-Getick <egetick@gmail.com>
 */
interface ExceptionNormalizerInterface
{
    /**
     * Normalizes an exception.
     *
     * @param \Exception $exception
     * @param bool       $debug     if the application is in debug mode
     *
     * @return NormalizedException|null null if not supported.
     */
    public function normalize(\Exception $exception, $debug);

    /**
     * Checks if the exception is supported.
     *
     * @param \Exception $exception
     * @param bool       $debug     if the application is in debug mode
     *
     * @return bool True if the exception is supported, else false
     */
    public function supports(\Exception $exception, $debug);
}
