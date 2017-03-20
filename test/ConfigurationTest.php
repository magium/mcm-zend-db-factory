<?php

namespace Magium\ZendDbFactory\Tests;

use Magium\Configuration\Config\ConfigurationRepository;
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
        <adapter>
            <driver>pdo_sqlite</driver>
            <hostname>:memory:</hostname>
        </adapter>
    </database>
</config>
XML
        );
        $adapter = ZendDbFactory::factory($configuration);
        self::assertInstanceOf(Adapter::class, $adapter);
    }

}
