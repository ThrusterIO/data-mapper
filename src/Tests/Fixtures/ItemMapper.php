<?php

namespace Thruster\Component\DataMapper\Tests\Fixtures;

use Thruster\Component\DataMapper\BaseDataMapper;

/**
 * Class ItemMapper
 *
 * @package Thruster\Component\DataMapper\Tests\Fixtures
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
class ItemMapper extends BaseDataMapper
{
    /**
     * @inheritDoc
     */
    public function map($input)
    {
        return $input;
    }
}
