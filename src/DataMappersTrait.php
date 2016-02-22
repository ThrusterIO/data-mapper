<?php

namespace Thruster\Component\DataMapper;

/**
 * Trait DataMappersTrait
 *
 * @package Thruster\Component\DataMapper
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
trait DataMappersTrait
{
    /**
     * @var DataMappers
     */
    protected $dataMappers;

    /**
     * @param DataMappers $dataMappers
     *
     * @return $this
     */
    public function setDataMappers(DataMappers $dataMappers)
    {
        $this->dataMappers = $dataMappers;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return DataMapper
     */
    public function getDataMapper(string $name) : DataMapper
    {
        return $this->dataMappers->getMapper($name);
    }
}
