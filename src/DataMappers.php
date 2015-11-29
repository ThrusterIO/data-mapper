<?php

namespace Thruster\Component\DataMapper;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use Thruster\Component\DataMapper\Exception\DataMapperNotFoundException;

/**
 * Class DataMappers
 *
 * @package Thruster\Component\DataMapper
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
class DataMappers
{
    /**
     * @var DataMapperInterface[]
     */
    protected $dataMappers;

    /**
     * @var DataMapper[]
     */
    protected $wrappedDataMappers;

    /**
     * @var ValidatorInterface
     */
    protected $validator;

    public function __construct()
    {
        $this->dataMappers = [];
        $this->wrappedDataMappers = [];
    }

    /**
     * @return ValidatorInterface
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * @param ValidatorInterface $validator
     *
     * @return $this
     */
    public function setValidator($validator)
    {
        $this->validator = $validator;

        return $this;
    }

    /**
     * @param string              $name
     * @param DataMapperInterface $dataMapper
     *
     * @return $this
     */
    public function addMapper(string $name, DataMapperInterface $dataMapper) : self
    {
        $this->dataMappers[$name] = $dataMapper;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasMapper(string $name) : bool
    {
        return array_key_exists($name, $this->dataMappers);
    }

    /**
     * @param string $name
     *
     * @return DataMapper
     */
    public function getMapper(string $name) : DataMapper
    {
        if (array_key_exists($name, $this->wrappedDataMappers)) {
            return $this->wrappedDataMappers[$name];
        }

        if (false === $this->hasMapper($name)) {
            throw new DataMapperNotFoundException($name);
        }

        $dataMapper = new DataMapper($this->dataMappers[$name]);
        $dataMapper->setValidator($this->getValidator());

        $this->wrappedDataMappers[$name] = $dataMapper;

        return $dataMapper;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function removeMapper(string $name) : self
    {
        unset($this->dataMappers[$name]);
        unset($this->wrappedDataMappers[$name]);

        return $this;
    }
}
