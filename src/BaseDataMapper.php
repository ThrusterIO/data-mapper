<?php

namespace Thruster\Component\DataMapper;

/**
 * Class BaseDataMapper
 *
 * @package Thruster\Component\DataMapper
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
abstract class BaseDataMapper implements DataMapperInterface
{
    /**
     * @var DataMappers
     */
    protected $dataMappers;

    /**
     * @inheritDoc
     */
    public function setDataMappers(DataMappers $dataMappers)
    {
        $this->dataMappers = $dataMappers;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getMapper($name)
    {
        return $this->dataMappers->getMapper($name);
    }

    /**
     * @inheritDoc
     */
    public function supports($input)
    {
        return true;
    }
}
