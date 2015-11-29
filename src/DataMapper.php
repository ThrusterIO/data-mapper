<?php

namespace Thruster\Component\DataMapper;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use Thruster\Component\DataMapper\Exception\DataMapperOutputNotValidException;
use Thruster\Component\DataMapper\Exception\NotSupportedInputForDataMapperException;

/**
 * Class DataMapper
 *
 * @package Thruster\Component\DataMapper
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
class DataMapper
{
    /**
     * @var DataMapperInterface
     */
    protected $dataMapper;

    /**
     * @var ValidatorInterface
     */
    protected $validator;

    public function __construct(DataMapperInterface $dataMapper)
    {
        $this->dataMapper = $dataMapper;
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
     * @return DataMapperInterface
     */
    public function getDataMapper()
    {
        return $this->dataMapper;
    }

    /**
     * @param mixed $input
     *
     * @return mixed
     * @throws DataMapperOutputNotValidException
     * @throws NotSupportedInputForDataMapperException
     */
    public function map($input)
    {
        $dataMapper = $this->getDataMapper();

        if (false === $dataMapper->supports($input)) {
            throw new NotSupportedInputForDataMapperException($input, $dataMapper);
        }

        $output = $dataMapper->map($input);

        if ($dataMapper instanceof ValidateableDataMapperInterface) {
            $violations = $this->getValidator()->validate(
                $output,
                null,
                $dataMapper->getValidationGroups($input)
            );

            if (count($violations) > 0) {
                throw new DataMapperOutputNotValidException($violations);
            }
        }

        return $output;
    }
}
