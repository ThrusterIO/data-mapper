<?php

namespace Thruster\Component\DataMapper\Tests;

use Thruster\Component\DataMapper\DataMapper;
use Thruster\Component\DataMapper\DataMapperInterface;
use Thruster\Component\DataMapper\Exception\DataMapperOutputNotValidException;

class DataMapperTest extends \PHPUnit_Framework_TestCase
{
    public function testMap()
    {
        $input = new \stdClass();
        $mapperMock = $this->getMockForAbstractClass('\Thruster\Component\DataMapper\DataMapperInterface');

        $mapperMock->expects($this->once())
            ->method('supports')
            ->with($input)
            ->willReturn(true);

        $mapperMock->expects($this->once())
            ->method('map')
            ->with($input)
            ->willReturn($input);

        $mapper = new DataMapper($mapperMock);

        $this->assertEquals($input, $mapper->map($input));
    }

    /**
     * @expectedException \Thruster\Component\DataMapper\Exception\NotSupportedInputForDataMapperException
     * @expectedExceptionMessage DataMapper "demo" does not support input type "stdClass"
     */
    public function testMapUnsupported()
    {
        $input = new \stdClass();
        $mapperMock = new class implements DataMapperInterface {
            public function map($input)
            {
            }

            public static function getName() : string
            {
                return 'demo';
            }

            public function supports($input) : bool
            {
                return false;
            }
        };

        $mapper = new DataMapper($mapperMock);
        $mapper->map($input);
    }

    /**
     * @expectedException \Thruster\Component\DataMapper\Exception\DataMapperOutputNotValidException
     */
    public function testMapValidator()
    {
        $input = new \stdClass();
        $mapperMock = $this->getMockForAbstractClass('\Thruster\Component\DataMapper\ValidateableDataMapperInterface');

        $mapperMock->expects($this->once())
            ->method('supports')
            ->with($input)
            ->willReturn(true);

        $mapperMock->expects($this->once())
            ->method('getValidationGroups')
            ->with($input)
            ->willReturn(['demo']);

        $mapperMock->expects($this->once())
            ->method('map')
            ->with($input)
            ->willReturn($input);

        $validator = $this->getMockForAbstractClass('\Symfony\Component\Validator\Validator\ValidatorInterface');

        $violations = $this->getMockForAbstractClass('\Symfony\Component\Validator\ConstraintViolationListInterface');

        $violations->expects($this->once())
            ->method('count')
            ->willReturn(3);

        $validator->expects($this->once())
            ->method('validate')
            ->with($input, null, ['demo'])
            ->willReturn($violations);

        $mapper = new DataMapper($mapperMock);
        $mapper->setValidator($validator);

        $mapper->map($input);
    }

    public function testValidateException()
    {
        $violations = $this->getMockForAbstractClass('\Symfony\Component\Validator\ConstraintViolationListInterface');

        $exception = new DataMapperOutputNotValidException($violations);

        $this->assertEquals($violations, $exception->getViolations());
    }
}
