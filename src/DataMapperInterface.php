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
     * @param string $name
     *
     * @return DataMapper
     */
    public function getMapper($name);

    /**
     * Maps data
     *
     * @param mixed $input
     *
     * @return mixed
     */
    public function map($input);

    /**
     * Returns a name of Data Mapper
     *
     * @return string
     */
    public static function getName();

    /**
     * Checks if supports input
     *
     * @param mixed $input
     *
     * @return bool
     */
    public function supports($input);
}
