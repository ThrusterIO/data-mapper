<?php

namespace Thruster\Component\DataMapper\Exception;

use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class DataMapperOutputNotValidException
 *
 * @package Thruster\Component\DataMapper\Exception
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
class DataMapperOutputNotValidException extends \Exception
{
    /**
     * @var ConstraintViolationList
     */
    protected $violations;

    public function __construct(ConstraintViolationListInterface $violations)
    {
        $this->violations = $violations;
    }

    /**
     * @return ConstraintViolationList
     */
    public function getViolations()
    {
        return $this->violations;
    }
}
