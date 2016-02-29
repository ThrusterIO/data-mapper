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
        $mapperMockName = get_class($mapperMock);

        $this->assertFalse($dataMappers->hasMapper($mapperMockName));

        $dataMappers->addMapper($mapperMock);

        $this->assertTrue($dataMappers->hasMapper($mapperMockName));

        $wrappedMapper = $dataMappers->getMapper($mapperMockName);

        $this->assertEquals($validatorMock, $wrappedMapper->getValidator());

        $this->assertInstanceOf('\Thruster\Component\DataMapper\DataMapper', $wrappedMapper);
        $this->assertEquals($mapperMock, $wrappedMapper->getDataMapper());

        $this->assertEquals($wrappedMapper, $dataMappers->getMapper($mapperMockName));

        $dataMappers->removeMapper($mapperMockName);

        $this->assertFalse($dataMappers->hasMapper($mapperMockName));
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
