<?php
$serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
$serviceContainer->checkVersion('2.0.0-dev');
$serviceContainer->setAdapterClass('aviaco', 'mysql');
$manager = new \Propel\Runtime\Connection\ConnectionManagerSingle();
$manager->setConfiguration(array (
  'classname' => 'Propel\\Runtime\\Connection\\ConnectionWrapper',
  'dsn' => 'mysql:host=localhost;dbname=aviaco;charset=UTF8',
  'user' => 'aviaco',
  'password' => 'aviaco',
));
$manager->setName('aviaco');
$serviceContainer->setConnectionManager('aviaco', $manager);
$serviceContainer->setDefaultDatasource('aviaco');