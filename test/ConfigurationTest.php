<?php

namespace Magium\ZendDbFactory\Tests;

use Magium\Configuration\Config\ConfigurationRepository;
use Magium\ZendDbFactory\InvalidConfigurationException;
use Magium\ZendDbFactory\ZendDbFactory;
use PHPUnit\Framework\TestCase;
use Zend\Db\Adapter\Adapter;

class ConfigurationTest extends TestCase
{

    public function testGetSqliteMemory()
    {
        $configuration = new ConfigurationRepository(<<<XML
<config>
    <database>
        <zenddb>
            <driver>pdo_sqlite</driver>
            <hostname>:memory:</hostname>
        </zenddb>
    </database>
</config>
XML
        );
        $adapter = ZendDbFactory::factory($configuration);
        self::assertInstanceOf(Adapter::class, $adapter);
    }

    public function testMissingDriverThrowsException()
    {
        $this->expectException(InvalidConfigurationException::class);
        $configuration = new ConfigurationRepository(<<<XML
<config>
    <database>
        <zenddb>
            <hostname>:memory:</hostname>
        </zenddb>
    </database>
</config>
XML
        );
        ZendDbFactory::factory($configuration);
    }

}
