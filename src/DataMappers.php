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
     * @param DataMapperInterface $dataMapper
     *
     * @return $this
     */
    public function addMapper(DataMapperInterface $dataMapper, string $name = null) : self
    {
        if (null === $name) {
            $name = get_class($dataMapper);
        }

        $this->dataMappers[$name] = $dataMapper;

        $dataMapper->setDataMappers($this);

        return $this;
    }

    /**
     * @param string $class
     *
     * @return bool
     */
    public function hasMapper(string $class) : bool
    {
        return array_key_exists($class, $this->dataMappers);
    }

    /**
     * @param string $class
     *
     * @return DataMapper
     * @throws DataMapperNotFoundException
     */
    public function getMapper(string $class) : DataMapper
    {
        if (array_key_exists($class, $this->wrappedDataMappers)) {
            return $this->wrappedDataMappers[$class];
        }

        if (false === $this->hasMapper($class)) {
            throw new DataMapperNotFoundException($class);
        }

        $dataMapper = new DataMapper($this->dataMappers[$class]);
        $dataMapper->setValidator($this->getValidator());

        $this->wrappedDataMappers[$class] = $dataMapper;

        return $dataMapper;
    }

    /**
     * @param string $class
     *
     * @return $this
     */
    public function removeMapper(string $class) : self
    {
        unset($this->dataMappers[$class]);
        unset($this->wrappedDataMappers[$class]);

        return $this;
    }
}
