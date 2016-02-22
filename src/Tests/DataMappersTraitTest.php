<?php

namespace Thruster\Component\DataMapper\Tests;

use Thruster\Component\DataMapper\DataMapper;
use Thruster\Component\DataMapper\DataMappersTrait;

/**
 * Class DataMappersTraitTest
 *
 * @package Thruster\Component\DataMapper\Tests
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
class DataMappersTraitTest extends \PHPUnit_Framework_TestCase
{
    public function testTrait()
    {
        $mappersMock = $this->getMock('Thruster\Component\DataMapper\DataMappers');
        $mapperMock = $this->getMockForAbstractClass('Thruster\Component\DataMapper\DataMapperInterface');

        $mapper = new DataMapper($mapperMock);

        $mappersMock->expects($this->once())
            ->method('getMapper')
            ->with('foo')
            ->willReturn($mapper);

        $object = new class {
            use DataMappersTrait;
        };


        $object->setDataMappers($mappersMock);

        $this->assertEquals($mapper, $object->getDataMapper('foo'));
    }
}
