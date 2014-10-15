<?php
/**
 * /app/bootstrap.php
 *
 * PHP Version 5.3
 *
 * @package   Bootstrap
 * @author    aidan lydon <alyo@loc.gov>
 * @copyright 2014 The Library of Congress
 * @license   Copyright 2014 The Library of Congress
 * @version   $Id:$
 * @link      TBD
 * @since     Sept 24, 2014
 */
try {
    //include a few convenience functions
    include __DIR__ . '/../app/lib/Custom/functions.php';

    //register the autoloader
    $loader = new \Phalcon\Loader();
    $loader->registerDirs(array(
        '../app/controllers/',
        '../app/models/',
        '../app/models/data/',
        '../app/lib/Custom/',
    ))->register();

    //create a dependency injector
    $di = new \Phalcon\DI\FactoryDefault();

    //set up the view component
    $di->set('view', function() {
        $view = new \Phalcon\Mvc\View();
        $view->setViewsDir('../app/views/');
        return $view;
    });

    //get the config
    $productionConfig = realpath(__DIR__ . '/../app/config/config.php');

    if (!is_readable($productionConfig)) {
        throw new Exception('unable to find the production config file');
    }

    $settings = include $productionConfig;
    $config = new \Phalcon\Config($settings);

    $localConfig = realpath(__DIR__ . '/../app/config/local.php');

    if (!empty($localConfig) && is_readable($localConfig)) {
        //merge in local settings
        $localSettings = include $localConfig;
        $config->merge($localSettings);
    }

    //timezone
    ini_set('date.timezone', $config['timezone']);

    //error reporting
    error_reporting($config['errors']['level']);
    ini_set('display_errors', $config['errors']['display']);

    //configure the router
    $di->set(
        'router',
        function() {
            include __DIR__.'/../app/config/routes.php';
            return $router;
        }
    );

    //configure the database connection
    $di->set(
        'db',
        function() use ($config) {
            $connection = new \Phalcon\Db\Adapter\Pdo\Mysql(
                array(
                    'host'       => $config['database']->host,
                    'username'   => $config['database']->username,
                    'password'   => $config['database']->password,
                    'dbname'     => $config['database']->dbname,
                    'persistent' => $config['database']->persistent,
                )
            );
            return $connection;
        }
    );

} catch (Exception $e) {
    echo 'Exception: ', $e->getMessage();
    xlog($e);
}
