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
class ExtendedExceptionNormalizer extends ExceptionNormalizer
{
    /**
     * @var array
     */
    private $statusCodesMap;
    /**
     * @var array
     */
    private $messagesMap;

    /**
     * @param array $statusCodesMap
     * @param array $messagesMap
     */
    public function __construct(array $statusCodesMap, array $messagesMap)
    {
        $this->statusCodesMap = $statusCodesMap;
        $this->messagesMap = $messagesMap;
    }

    /**
     * {@inheritdoc}
     */
    public function normalize(\Exception $exception, $debug)
    {
        $normalizedException = parent::normalize($exception, $debug);

        foreach ($this->statusCodesMap as $class => $statusCode) {
            if ($exception instanceof $class) {
                $normalizedException->setStatusCode($statusCode);
                break;
            }
        }

        foreach ($this->messagesMap as $class => $message) {
            if ($exception instanceof $class) {
                if ($message === true) {
                    $normalizedException->setParameter('message', $exception->getMessage());
                } else {
                    $normalizedException->setParameter('message', $message);
                }
                break;
            }
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
