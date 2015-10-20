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
 * {@inheritdoc}
 *
 * @author Ener-Getick <egetick@gmail.com>
 */
class ExceptionNormalizer implements ExceptionNormalizerInterface
{
    /**
     * {@inheritdoc}
     *
     * @return NormalizedException
     */
    public function normalize(\Exception $exception, $debug)
    {
        $normalizedException = new NormalizedException();
        $normalizedException->setParameter('code', $exception->getCode());

        if ($debug) {
            $normalizedException->setParameter('message', $exception->getMessage());
            $normalizedException->setParameter('file', $exception->getFile());
            $normalizedException->setParameter('line', $exception->getLine());
        }

        return $normalizedException;
    }

    /**
     * {@inheritdoc}
     */
    public function supports(\Exception $exception, $debug)
    {
        return true;
    }
}
