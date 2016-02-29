<?php

namespace Thruster\Component\DataMapper\Tests\Fixtures;

use Thruster\Component\DataMapper\BaseDataMapper;
use Thruster\Component\DataMapper\DataMapperInterface;

/**
 * Class UnsupportedMapper
 *
 * @package Thruster\Component\DataMapper\Tests\Fixtures
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
class UnsupportedMapper extends BaseDataMapper
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
    public function supports($input)
    {
        return false;
    }
}
