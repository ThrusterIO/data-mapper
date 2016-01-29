<?php

namespace Thruster\Component\DataMapper\Tests\Fixtures;

use Thruster\Component\DataMapper\DataMapperInterface;

/**
 * Class UnsupportedMapper
 *
 * @package Thruster\Component\DataMapper\Tests\Fixtures
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
class UnsupportedMapper implements DataMapperInterface
{
    /**
     * @inheritDoc
     */
    public function map($input)
    {
    }

    /**
     * @inheritDoc
     */
    public static function getName()
    {
        return 'demo';
    }

    /**
     * @inheritDoc
     */
    public function supports($input)
    {
        return false;
    }

}
