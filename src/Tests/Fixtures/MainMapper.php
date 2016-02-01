<?php

namespace Thruster\Component\DataMapper\Tests\Fixtures;

use Thruster\Component\DataMapper\BaseDataMapper;

/**
 * Class MainMapper
 *
 * @package Thruster\Component\DataMapper\Tests\Fixtures
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
class MainMapper extends BaseDataMapper
{

    public function map($input)
    {
        return [
            'items' => $this->getMapper('items')->mapCollection($input->items)
        ];
    }

    public static function getName()
    {
        return 'demo';
    }
}
