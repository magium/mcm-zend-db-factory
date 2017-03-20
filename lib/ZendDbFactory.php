<?php

namespace Magium\ZendDbFactory;

use Magium\Configuration\Config\ConfigurationRepository;
use Zend\Db\Adapter\Adapter;

class ZendDbFactory
{

    const PATH_DRIVER   = 'database/adapter/driver';
    const PATH_DATABASE = 'database/adapter/database';
    const PATH_USERNAME = 'database/adapter/username';
    const PATH_PASSWORD = 'database/adapter/password';
    const PATH_HOSTNAME = 'database/adapter/hostname';
    const PATH_PORT     = 'database/adapter/port';
    const PATH_CHARSET  = 'database/adapter/charset';

    public static function factory(ConfigurationRepository $repository)
    {
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
