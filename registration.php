<?php

$instance = \Magium\Configuration\File\Configuration\ConfigurationFileRepository::getInstance();
$instance->addSecureBase(realpath('etc'));
$instance->registerConfigurationFile(new \Magium\Configuration\File\Configuration\XmlFile(realpath('etc/settings.xml')));
