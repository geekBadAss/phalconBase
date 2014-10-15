<?php
/**
 * /public/index.php
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
require __DIR__ . '/../app/bootstrap.php';

try {
    $application = new \Phalcon\Mvc\Application($di);
    echo $application->handle()->getContent();

} catch (Exception $e) {
    echo 'Exception: ', $e->getMessage();
    xlog($e);
}
