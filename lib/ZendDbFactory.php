<?php

namespace Magium\ZendDbFactory;

use Magium\Configuration\Config\Repository\ConfigInterface;
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

    private $config;

    private static $me;

    public function __construct(ConfigInterface $config)
    {
        self::$me = $this;
        $this->config = $config;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function factory()
    {
        if (!$this->getConfig()->hasValue(self::PATH_DRIVER)) {
            throw new InvalidConfigurationException('Missing the configuration value for ' . self::PATH_DRIVER);
        }

        $options = [
            'driver'    => $this->getConfig()->getValue(self::PATH_DRIVER)
        ];

        $this->updateOptions($options, 'database', self::PATH_DATABASE);
        $this->updateOptions($options, 'username', self::PATH_USERNAME);
        $this->updateOptions($options, 'password', self::PATH_PASSWORD);
        $this->updateOptions($options, 'hostname', self::PATH_HOSTNAME);
        $this->updateOptions($options, 'port', self::PATH_PORT);
        $this->updateOptions($options, 'charset', self::PATH_CHARSET);

        $adapter = new Adapter($options);
        return $adapter;

    }

    public static function staticFactory(ConfigInterface $config)
    {
        if (!self::$me instanceof self) {
            new self($config);
        }
        return self::$me->factory();
    }

    protected function updateOptions(&$options, $name, $path)
    {
        if ($this->getConfig()->hasValue($path)) {
            $options[$name] = $this->getConfig()->getValue($path);
        }
    }

}
