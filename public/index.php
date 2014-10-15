<?php
/**
 * /public/index.php
 *
 * Bootstrap
 * @author  aidan lydon <aidanlydon@gmail.com>
 */
require __DIR__ . '/../app/bootstrap.php';

try {
    $application = new \Phalcon\Mvc\Application($di);
    echo $application->handle()->getContent();

} catch (Exception $e) {
    echo 'Exception: ', $e->getMessage();
    xlog($e);
}
