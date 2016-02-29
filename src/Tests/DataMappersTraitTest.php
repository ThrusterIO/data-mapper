<?php

namespace Thruster\Component\DataMapper\Tests;

use Thruster\Component\DataMapper\Tests\Fixtures\TraitConsumer;

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
        $mappersMock = $this->getMock('\Thruster\Component\DataMapper\DataMappers');
        $mapperMock = $this->getMockBuilder('\Thruster\Component\DataMapper\DataMapper')->disableOriginalConstructor();
        $mapperMockName = get_class($mapperMock);

        $mappersMock->expects($this->once())
            ->method('getMapper')
            ->with($mapperMockName)
            ->willReturn($mapperMock);

        $object = new TraitConsumer();
        $object->setDataMappers($mappersMock);

        $this->assertEquals($mapperMock, $object->getDataMapper($mapperMockName));
    }
}
