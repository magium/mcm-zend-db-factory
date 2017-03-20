# Magium Configuration Manager - Zend DB Adapter

This is a simple library that allows to configure a Zend DB adapter using the [Magium Configuration Manager](https://github.com/magium/configuration-manager).

## Setup

Using it is really easy.

First install via composer

```
composer require magium/zend-db-factory
```

Then wire your application to use MCM.

```
$factory = new \Magium\Configuration\MagiumConfigurationFactory();
$config = $factory->getManager()->getConfiguration(getenv('ENVIRONMENT'));

$redis = \Magium\ZendDbFactory\ZendDbFactory::factory($config);
```

You can also wire you Zend DI component to work with it:

```
$config = [
    'definition'  => [
        'class' => [
            \Zend\Db\Adapter\Adapter::class => [
                'instantiator' => [
                    \Magium\ZendDbFactory\ZendDbFactory::class,
                    'factory'
                ]
            ],
            Magium\ZendDbFactory\ZendDbFactory::class => [
                'methods'   => [
                    'factory'   => [
                        'config'    => [
                            'type'      => \Magium\Configuration\Config\ConfigurationRepository::class,
                            'required'  => true
                        ]
                    ]
                ]
            ]
        ]
    ]
];
$factory = new \Magium\Configuration\MagiumConfigurationFactory();
$di = new \Zend\Di\Di();
$configuration = new \Zend\Di\Config($config);
$configuration->configure($di);
$di->instanceManager()->addSharedInstance(
    $factory->getManager()->getConfiguration(),
    \Magium\Configuration\Config\ConfigurationRepository::class
);

$adapter = $di->get(\Zend\Db\Adapter\Adapter::class);
```

## To Change Settings

Use the MCM configuration manager to change settings.  For example, if you are going to use the CLI to make changes you have the following options:

```
[kschroeder@dev ~]$ vendor/configuration-manager magium:configuration:list-keys
Valid configuration keys
database/zenddb/driver

database/zenddb/hostname
        (A string containing a hostname or IP address of the database server. If the database is running on the same host as the PHP application, you may use 'localhost' or '127.0.0.1'.)

database/zenddb/username
        (Account identifier for authenticating a connection to the RDBMS server.)

database/zenddb/password
        (Account password credential for authenticating a connection to the RDBMS server.)

database/zenddb/dbname
        (Database instance name on the RDBMS server.)

database/zenddb/port
        (Some RDBMS servers can accept network connections on a administrator-specified port number.  The port parameter allow you to specify the port to which your PHP application connects, to match the port configured on the RDBMS server.)

database/adapter/charset
        (Specify the charset used for the connection.)

```

If you need to change the configuration to something else:

```
[kschroeder@dev ~]$ vendor/bin/magium-configuration magium:configuration:set database/zenddb/hostname hostname
```

Voila!  You're done.  No deployment necessary.

