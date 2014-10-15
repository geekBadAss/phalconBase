<?php
require __DIR__ . '/../../app/bootstrap.php';
/**
 * DataModelGenerator
 *
 * Cli
 * @author  aidan lydon <aidanlydon@gmail.com>
 */
$db = DB::getConnection();

$tables = $db->getAll('show tables');

pre($tables);
