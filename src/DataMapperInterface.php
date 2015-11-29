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
    public static function getName() : string;

    /**
     * Checks if supports input
     *
     * @param mixed $input
     *
     * @return bool
     */
    public function supports($input) : bool;
}
