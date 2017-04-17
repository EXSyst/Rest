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
 * Wraps multiple ExceptionNormalizerInterface.
 *
 * @author Ener-Getick <egetick@gmail.com>
 */
class ChainExceptionNormalizer implements ExceptionNormalizerInterface
{
    /**
     * @var ExceptionNormalizerInterface[]
     */
    private $normalizers = [];

    /**
     * @param ExceptionNormalizerInterface[]
     */
    public function __construct(array $normalizers)
    {
        foreach ($normalizers as $normalizer) {
            $this->addNormalizer($normalizer);
        }
    }

    /**
     * Adds an exception normalizer.
     *
     * @param ExceptionNormalizerInterface $normalizer
     */
    public function addNormalizer(ExceptionNormalizerInterface $normalizer)
    {
        $this->normalizers[] = $normalizer;
    }

    /**
     * {@inheritdoc}
     */
    public function normalize(\Exception $exception, $debug)
    {
        foreach ($this->normalizers as $normalizer) {
            if ($normalizer->supports($exception, $debug)) {
                return $normalizer->normalize($exception, $debug);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function supports(\Exception $exception, $debug)
    {
        foreach ($this->normalizers as $normalizer) {
            if ($normalizer->supports($exception, $debug)) {
                return true;
            }
        }

        return false;
    }
}
