<?php

namespace Thruster\Component\DataMapper\Exception;

use Thruster\Component\DataMapper\DataMapperInterface;

/**
 * Class NotSupportedInputForDataMapperException
 *
 * @package Thruster\Component\DataMapper\Exception
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
class NotSupportedInputForDataMapperException extends \Exception
{
    /**
     * @inheritDoc
     */
    public function __construct($input, DataMapperInterface $dataMapper)
    {
        $message = sprintf(
            'DataMapper "%s" does not support input type "%s"',
            get_class($dataMapper),
            is_object($input) ? get_class($input) : gettype($input)
        );

        parent::__construct($message);
    }
}
