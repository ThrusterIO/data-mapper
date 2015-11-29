<?php

namespace Thruster\Component\DataMapper\Tests;

use Thruster\Component\DataMapper\DataMappers;

class DataMappersTest extends \PHPUnit_Framework_TestCase
{
    public function testAddMapper()
    {
        $dataMappers = new DataMappers();

        $validatorMock = $this->getMockForAbstractClass('\Symfony\Component\Validator\Validator\ValidatorInterface');
        $dataMappers->setValidator($validatorMock);

        $mapperMock = $this->getMockForAbstractClass('\Thruster\Component\DataMapper\DataMapperInterface');

        $this->assertFalse($dataMappers->hasMapper('demo'));

        $dataMappers->addMapper('demo', $mapperMock);

        $this->assertTrue($dataMappers->hasMapper('demo'));

        $wrappedMapper = $dataMappers->getMapper('demo');

        $this->assertEquals($validatorMock, $wrappedMapper->getValidator());

        $this->assertInstanceOf('\Thruster\Component\DataMapper\DataMapper', $wrappedMapper);
        $this->assertEquals($mapperMock, $wrappedMapper->getDataMapper());

        $this->assertEquals($wrappedMapper, $dataMappers->getMapper('demo'));

        $dataMappers->removeMapper('demo');

        $this->assertFalse($dataMappers->hasMapper('demo'));
    }

    /**
     * @expectedException \Thruster\Component\DataMapper\Exception\DataMapperNotFoundException
     * @expectedExceptionMessage DataMapper "demo" not found
     */
    public function testNotExistingMapper()
    {
        $dataMappers = new DataMappers();

        $dataMappers->getMapper('demo');
    }
}
