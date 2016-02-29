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
        $mapperName = get_class($mapperMock);
        
        $this->assertFalse($dataMappers->hasMapper($mapperName));

        $dataMappers->addMapper($mapperMock);

        $this->assertTrue($dataMappers->hasMapper($mapperName));

        $wrappedMapper = $dataMappers->getMapper($mapperName);

        $this->assertEquals($validatorMock, $wrappedMapper->getValidator());

        $this->assertInstanceOf('\Thruster\Component\DataMapper\DataMapper', $wrappedMapper);
        $this->assertEquals($mapperMock, $wrappedMapper->getDataMapper());

        $this->assertEquals($wrappedMapper, $dataMappers->getMapper($mapperName));

        $dataMappers->removeMapper($mapperName);

        $this->assertFalse($dataMappers->hasMapper($mapperName));
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
