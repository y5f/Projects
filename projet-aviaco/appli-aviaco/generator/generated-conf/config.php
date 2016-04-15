<?php
$serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
$serviceContainer->checkVersion('2.0.0-dev');
$serviceContainer->setAdapterClass('appliaviaco', 'mysql');
$manager = new \Propel\Runtime\Connection\ConnectionManagerSingle();
$manager->setConfiguration(array (
  'classname' => 'Propel\\Runtime\\Connection\\ConnectionWrapper',
  'dsn' => 'mysql:host=localhost;dbname=appliaviaco;charset=UTF8',
  'user' => 'appliadmin',
  'password' => 'NelsonMandela1',
));
$manager->setName('appliaviaco');
$serviceContainer->setConnectionManager('appliaviaco', $manager);
$serviceContainer->setDefaultDatasource('appliaviaco');