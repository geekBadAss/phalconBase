<?php
require __DIR__ . '/../../app/bootstrap.php';
/**
 * DataModelGenerator
 *
 * PHP Version 5.3
 *
 * @package   Cli
 * @author    aidan lydon <alyo@loc.gov>
 * @copyright 2014 The Library of Congress
 * @license   Copyright 2014 The Library of Congress
 * @version   $Id:$
 * @link      TBD
 * @since     Sept 24, 2014
 */
$db = DB::getConnection();

$tables = $db->getAll('show tables');

pre($tables);
