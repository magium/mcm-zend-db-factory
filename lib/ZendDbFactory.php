<?php

namespace Magium\ZendDbFactory;

use Magium\Configuration\Config\ConfigurationRepository;
use Zend\Db\Adapter\Adapter;

class ZendDbFactory
{

    const PATH_DRIVER   = 'database/zenddb/driver';
    const PATH_DATABASE = 'database/zenddb/database';
    const PATH_USERNAME = 'database/zenddb/username';
    const PATH_PASSWORD = 'database/zenddb/password';
    const PATH_HOSTNAME = 'database/zenddb/hostname';
    const PATH_PORT     = 'database/zenddb/port';
    const PATH_CHARSET  = 'database/zenddb/charset';

    public static function factory(ConfigurationRepository $repository)
    {
        if (!$repository->hasValue(self::PATH_DRIVER)) {
            throw new InvalidConfigurationException('Missing the configuration value for ' . self::PATH_DRIVER);
        }

        $options = [
            'driver'    => $repository->getValue(self::PATH_DRIVER)
        ];

        self::updateOptions($options, 'database', self::PATH_DATABASE, $repository);
        self::updateOptions($options, 'username', self::PATH_USERNAME, $repository);
        self::updateOptions($options, 'password', self::PATH_PASSWORD, $repository);
        self::updateOptions($options, 'hostname', self::PATH_HOSTNAME, $repository);
        self::updateOptions($options, 'port', self::PATH_PORT, $repository);
        self::updateOptions($options, 'charset', self::PATH_CHARSET, $repository);

        $adapter = new Adapter($options);
        return $adapter;

    }

    protected static function updateOptions(&$options, $name, $path, ConfigurationRepository $repository)
    {
        if ($repository->hasValue($path)) {
            $options[$name] = $repository->getValue($path);
        }
    }

}
