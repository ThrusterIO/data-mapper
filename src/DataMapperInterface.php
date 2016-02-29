<?php

namespace Thruster\Component\DataMapper;

/**
 * Interface DataMapperInterface
 *
 * @package Thruster\Component\DataMapper
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
interface DataMapperInterface
{
    /**
     * Dependency Injection for DataMappers
     *
     * @param DataMappers $dataMappers
     *
     * @return $this
     */
    public function setDataMappers(DataMappers $dataMappers);

    /**
     * Retrieves DataMapper from DataMappers
     *
     * @param string $class
     *
     * @return DataMapper
     */
    public function getMapper($class);

    /**
     * Maps data
     *
     * @param mixed $input
     *
     * @return mixed
     */
    public function map($input);

    /**
     * Checks if supports input
     *
     * @param mixed $input
     *
     * @return bool
     */
    public function supports($input);
}
