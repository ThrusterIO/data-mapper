<?php

namespace Thruster\Component\DataMapper\Exception;

/**
 * Class DataMapperNotFoundException
 *
 * @package Thruster\Component\DataMapper\Exception
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
class DataMapperNotFoundException extends \Exception
{
    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $message = sprintf(
            'DataMapper "%s" not found',
            $name
        );

        parent::__construct($message);
    }
}
