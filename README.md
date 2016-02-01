# DataMapper Component

[![Latest Version](https://img.shields.io/github/release/ThrusterIO/data-mapper.svg?style=flat-square)]
(https://github.com/ThrusterIO/data-mapper/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)]
(LICENSE)
[![Build Status](https://img.shields.io/travis/ThrusterIO/data-mapper/php5.svg?style=flat-square)]
(https://travis-ci.org/ThrusterIO/data-mapper)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/ThrusterIO/data-mapper/php5.svg?style=flat-square)]
(https://scrutinizer-ci.com/g/ThrusterIO/data-mapper)
[![Quality Score](https://img.shields.io/scrutinizer/g/ThrusterIO/data-mapper/php5.svg?style=flat-square)]
(https://scrutinizer-ci.com/g/ThrusterIO/data-mapper)
[![Total Downloads](https://img.shields.io/packagist/dt/thruster/data-mapper.svg?style=flat-square)]
(https://packagist.org/packages/thruster/data-mapper)

[![Email](https://img.shields.io/badge/email-team@thruster.io-blue.svg?style=flat-square)]
(mailto:team@thruster.io)

The Thruster DataMapper Component. Provides fast and efficient way to map data from one format to another.


## Install

Via Composer

``` bash
$ composer require thruster/data-mapper ">=1.0,<2.0"
```


## Usage

### Simple Data Mapping

```php
class SimpleMapper extends BaseDataMapper {
    /**
     * @param Request $input
     */
    public function map($input)
    {
        return [
            'id' => $input->getId(),
            'name' => $input->getName()
        ];
    }

    public static function getName()
    {
        return 'simple_mapper';
    }
}

$simpleMapper = new SimpleMapper();

$dataMappers = new DataMappers();
$dataMappers->addMapper($simpleMapper->getName(), $simpleMapper);
$dataMappers->getMapper('simple_mapper')->map($input);
```

### Nested Data Mapping

```php
class ItemMapper extends BaseDataMapper {
    /**
     * @param Request $input
     */
    public function map($input)
    {
        return [
            'id' => $input->getId(),
            'name' => $input->getName()
        ];
    }

    public static function getName()
    {
        return 'items';
    }
}

class MainMapper extends BaseDataMapper {
    /**
     * @param Request $input
     */
    public function map($input)
    {
        return [
            'id' => $input->getId(),
            'name' => $input->getName(),
            'items' => $this->getMapper('items')->mapCollection($input->getItems())
        ];
    }

    public static function getName()
    {
        return 'main';
    }
}

$mainMapper = new MainMapper();
$itemMapper = new ItemMapper();

$dataMappers = new DataMappers();
$dataMappers->addMapper($mainMapper->getName(), $mainMapper);
$dataMappers->addMapper($itemMapper->getName(), $itemMapper);
$dataMappers->getMapper('main')->map($input);
```

### Validateable Data Mapping

```php
class UserRegistrationMapper extends BaseDataMapper implements ValidateableDataMapperInterface {
    /**
     * @param Request $input
     */
    public function map($input)
    {
        $user = new User();
        
        $user->setUsername($input->get('username'));
        $user->setPassword($input->get('password'));
    }

    public static function getName()
    {
        return 'user_registration';
    }

    public function supports($input)
    {
        return ($input instanceof Request);
    }
    
    public function getValidationGroups($input)
    {
        return ['full'];
    }
}


$userRegistrationMapper = new UserRegistrationMapper();
$dataMappers = new DataMappers();
$dataMappers->setValidator(Validation::createValidator());

$dataMappers->addMapper($userRegistrationMapper->getName(), $userRegistrationMapper);
$dataMappers->getMapper('user_registration')->map($input);
```

### Standalone Data Mapping
```php
class SimpleMapper extends BaseDataMapper {
    /**
     * @param Request $input
     */
    public function map($input)
    {
        return [
            'id' => $input->getId(),
            'name' => $input->getName()
        ];
    }
    
    public static function getName() : string
    {
        return 'simple_mapper';
    }
}

$simpleMapper = new DataMapper(
    new SimpleMapper();
);

$simpleMapper->map($input);
```

## Testing

``` bash
$ composer test
```


## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.


## License

Please see [License File](LICENSE) for more information.
