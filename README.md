# DataMapper Component

[![Latest Version](https://img.shields.io/github/release/ThrusterIO/data-mapper.svg?style=flat-square)]
(https://github.com/ThrusterIO/data-mapper/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)]
(LICENSE)
[![Build Status](https://img.shields.io/travis/ThrusterIO/data-mapper.svg?style=flat-square)]
(https://travis-ci.org/ThrusterIO/data-mapper)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/ThrusterIO/data-mapper.svg?style=flat-square)]
(https://scrutinizer-ci.com/g/ThrusterIO/data-mapper)
[![Quality Score](https://img.shields.io/scrutinizer/g/ThrusterIO/data-mapper.svg?style=flat-square)]
(https://scrutinizer-ci.com/g/ThrusterIO/data-mapper)
[![Total Downloads](https://img.shields.io/packagist/dt/thruster/data-mapper.svg?style=flat-square)]
(https://packagist.org/packages/thruster/data-mapper)

[![Email](https://img.shields.io/badge/email-team@thruster.io-blue.svg?style=flat-square)]
(mailto:team@thruster.io)

The Thruster DataMapper Component. Provides fast and efficient way to map data from one format to another.


## Install

Via Composer

``` bash
$ composer require thruster/data-mapper
```


## Usage

### Simple Data Mapping

```php
$simpleMapper = new class implements DataMapperInterface {
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

    public function supports($input) : bool
    {
        return true;
    }
}

$dataMappers = new DataMappers();
$dataMappers->addMapper($simpleMapper->getName(), $simpleMapper);
$dataMappers->getMapper('simple_mapper')->map($input);
```

### Validateable Data Mapping

```php
$userRegistrationMapper = new class implements ValidateableDataMapperInterface {
    /**
     * @param Request $input
     */
    public function map($input)
    {
        $user = new User();
        
        $user->setUsername($input->get('username'));
        $user->setPassword($input->get('password'));
    }

    public static function getName() : string
    {
        return 'user_registration';
    }

    public function supports($input) : bool
    {
        return ($input instanceof Request);
    }
    
    public function getValidationGroups($input) : array
    {
        return ['full'];
    }
}

$dataMappers = new DataMappers();
$dataMappers->setValidator(Validation::createValidator());

$dataMappers->addMapper($userRegistrationMapper->getName(), $userRegistrationMapper);
$dataMappers->getMapper('user_registration')->map($input);
```

### Standalone Data Mapping
```php
$simpleMapper = new DataMapper(
    new class implements DataMapperInterface {
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
    
        public function supports($input) : bool
        {
            return true;
        }
    }
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
