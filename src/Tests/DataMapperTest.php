<?php

namespace Thruster\Component\DataMapper\Tests;

use Thruster\Component\DataMapper\DataMapper;
use Thruster\Component\DataMapper\Exception\DataMapperOutputNotValidException;
use Thruster\Component\DataMapper\Tests\Fixtures\ItemMapper;
use Thruster\Component\DataMapper\Tests\Fixtures\MainMapper;
use Thruster\Component\DataMapper\Tests\Fixtures\UnsupportedMapper;

class DataMapperTest extends \PHPUnit_Framework_TestCase
{
    public function testMap()
    {
        $input      = new \stdClass();
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

    public function testMapCollection()
    {
        $input  = new \stdClass();
        $inputs = [10 => $input, 20 => $input, 30 => $input];

        $mapperMock = $this->getMockForAbstractClass('\Thruster\Component\DataMapper\DataMapperInterface');

        $mapperMock->expects($this->exactly(6))
            ->method('supports')
            ->with($input)
            ->willReturn(true);

        $mapperMock->expects($this->exactly(6))
            ->method('map')
            ->with($input)
            ->willReturnArgument(0);

        $mapper = new DataMapper($mapperMock);

        $this->assertEquals($inputs, $mapper->mapCollection($inputs));
        $this->assertEquals(array_values($inputs), $mapper->mapCollection($inputs, false));
    }

    /**
     * @expectedException \Thruster\Component\DataMapper\Exception\NotSupportedInputForDataMapperException
     * @expectedExceptionMessage DataMapper "Thruster\Component\DataMapper\Tests\Fixtures\UnsupportedMapper" does not
     *                           support input type "stdClass"
     */
    public function testMapUnsupported()
    {
        $input  = new \stdClass();
        $mapper = new UnsupportedMapper();

        $mapper = new DataMapper($mapper);
        $mapper->map($input);
    }

    /**
     * @expectedException \Thruster\Component\DataMapper\Exception\DataMapperOutputNotValidException
     */
    public function testMapValidator()
    {
        $input      = new \stdClass();
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

    public function testNestedMapping()
    {

        $item  = new \stdClass();
        $items = [$item, $item];

        $itemMapper = new ItemMapper();
        $mainMapper = new MainMapper();

        $given        = new \stdClass();
        $given->items = $items;

        $dataMappersMock = $this->getMock('\Thruster\Component\DataMapper\DataMappers');
        $dataMappersMock->expects($this->once())
            ->method('getMapper')
            ->with(ItemMapper::class)
            ->willReturn(new DataMapper($itemMapper));

        $mainMapper->setDataMappers($dataMappersMock);

        $mapper = new DataMapper($mainMapper);
        $mapper->map($given);
    }

    public function testMapNull()
    {
        $mapperMock = $this->getMockForAbstractClass('\Thruster\Component\DataMapper\DataMapperInterface');

        $mapper = new DataMapper($mapperMock);

        $this->assertNull($mapper->map(null));
    }

    public function testMapCollectionNull()
    {
        $mapperMock = $this->getMockForAbstractClass('\Thruster\Component\DataMapper\DataMapperInterface');

        $mapper = new DataMapper($mapperMock);

        $this->assertEquals([], $mapper->mapCollection(null));
    }
}
