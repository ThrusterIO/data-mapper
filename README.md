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
}

$dataMappers = new DataMappers();
$dataMappers->addMapper(new SimpleMapper());
$dataMappers->getMapper(SimpleMapper::class)->map($input);
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
            'items' => $this->getMapper(ItemMapper::class)->mapCollection($input->getItems())
        ];
    }
}

$dataMappers = new DataMappers();
$dataMappers->addMapper(new MainMapper());
$dataMappers->addMapper(new ItemMapper());
$dataMappers->getMapper(MainMapper::class)->map($input);
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

    public function supports($input)
    {
        return ($input instanceof Request);
    }
    
    public function getValidationGroups($input)
    {
        return ['full'];
    }
}


$dataMappers = new DataMappers();
$dataMappers->setValidator(Validation::createValidator());

$dataMappers->addMapper(new UserRegistrationMapper());
$dataMappers->getMapper(UserRegistrationMapper::class)->map($input);
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
