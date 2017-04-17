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

use EXSyst\Component\Api\Exception;

/**
 * @author Ener-Getick <egetick@gmail.com>
 */
class NormalizedException
{
    /**
     * @var array
     */
    private $parameters = [];
    /**
     * @var int
     */
    private $statusCode;
    /**
     * @var array
     */
    private $headers = [];

    /**
     * @param array $parameters must only contains scalar values
     * @param int   $statusCode
     * @param array $headers
     */
    public function __construct(array $parameters = [], $statusCode = 500, array $headers = [])
    {
        foreach ($parameters as $key => $value) {
            $this->setParameter($key, $value);
        }
        $this->setStatusCode($statusCode);
        $this->setHeaders($headers);
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param scalar       $key
     * @param array|scalar $value
     */
    public function setParameter($key, $value)
    {
        $this->checkParameterValue($value);
        $this->parameters[$key] = $value;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     */
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
    }

    /**
     * @param array|scalar $parameter
     *
     * @throws Exception\InvalidArgumentException
     */
    private function checkParameterValue($parameter)
    {
        if (is_array($parameter)) {
            foreach ($parameter as $row) {
                $this->checkParameterValue($row);
            }
        } elseif (!is_scalar($parameter)) {
            throw new Exception\InvalidArgumentException('A NormalizedException parameter must only contains array and scalar values.');
        }
    }
}
