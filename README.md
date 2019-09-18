# mdarc/DI
A simple yet powerful [PSR-11](https://www.php-fig.org/psr/psr-11/) autowiring dependency injection container.

**mdarc/DI** was conceived to be simple to configure and use. It was built
for performance. (check [benchmarks](tests/Benchmarks/README.md))

mdarc/DI has an very small but robust code base. It is **production ready** and can be used for small micro-services or large monolithic projects.

##### Features: #####
- Autowiring: Automatically instantiate and inject dependencies
- Manual configuration: When classes cannot be autowired, you can create them by yourself
- Circular reference detection: It throws a `CircularReferenceException` with enough details to fix the problem

##### What mdarc/DI is not good for: #####
- Autowiring via setter methods is not supported (and it will never be)
- Autowiring using phpDoc annotations is not supported (and it will never be)
- Automatically injecting dependencies on constructor parameters without type hints is not supported. You must manually configure those cases

Installation
------------

### Composer ###

Before anything else, use this to add it to your composer.json

```shell script
$ composer require mdarc/di "^1.0.0"
```

Usage
-----
Creating a container ready to use with autowiring enabled is a matter of creating a `Container` instance:

```php
use Mdarc\DI\Container;

$container = new Container();
```

If your classes contain **constructor parameters** that are other objects, then simply:
```php
$myClass = $container->get(\Path\To\MyClass::class);
```
As any other DI container, `$myClass` will always get the same instance on the requested class.

If you want to create a new object every time (instead of getting the same object instance) then use the **factory** helper:
```php
use Mdarc\DI\Container;
use Mdarc\DI\DI;

$container = new Container([
    \Path\To\MyClass::class => DI::factory(function () {
        return new \Path\To\MyClass(); 
    }),
]);

$myClass = $container->get(\Path\To\MyClass::class);
```

For those classes that cannot be created using autowiring, then you can add their **definitions**:
```php
use Mdarc\DI\Container;

$container = new Container([
    \Monolog\Logger::class => function (Container $c) {
        $config = $c->get(\Path\To\Config::class);
        $logger = new \Monolog\Logger($config->get('name'));
        $logger->pushHandler(new \Monolog\Handler\StreamHandler('php://stdout', \Monolog\Logger::DEBUG));

        return $logger; 
    }),
]);

$logger = $container->get(\Monolog\Logger::class);
```

Defining **aliases** for binding interfaces to implementations is simple:
```php
use Mdarc\DI\Container;

$container = new Container([
    // Binding Interface to implementation
    \Psr\Log\LoggerInterface::class => \Monolog\Logger::class,
    // Concrete implementation
    \Monolog\Logger::class => function (Container $c) {
        // build Monolog here
    }),
]);

$logger = $container->get(\Psr\Log\LoggerInterface::class);
```

Specifying **arguments** for classes with constructor parameters that are scalar, array or undefined type:
```php
use Mdarc\DI\Container;

class MyClass {
    public function __construct(array $config, \Psr\LoggerInterface $logger) { /*...*/ }
}

$definitions = [
    // Binding Interface to implementation
    \Psr\Log\LoggerInterface::class => \Monolog\Logger::class,
    // Concrete implementation
    \Monolog\Logger::class => function (Container $c) {
        // build Monolog here
    },
];

$constructorParameters = [
    MyClass::class => [
        'config' => ['an array', 'of relevant', 'things']
    ],
];
$container = new Container($definitions, $constructorParameters);

$myClass = $container->get(MyClass::class);
```

### License ###
mdarc/DI is licensed under the MIT License.
