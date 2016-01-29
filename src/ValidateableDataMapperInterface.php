<?php

namespace Thruster\Component\DataMapper;

/**
 * Interface ValidateableDataMapperInterface
 *
 * @package Thruster\Component\DataMapper
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
interface ValidateableDataMapperInterface extends DataMapperInterface
{
    /**
     * @param mixed $input
     *
     * @return array
     */
    public function getValidationGroups($input);
}
