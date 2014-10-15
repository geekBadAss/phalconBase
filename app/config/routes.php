<?php
/**
 * app/config/routes.php
 *
 * @package Config
 * @author  aidan lydon <aidanlydon@gmail.com>
 */
$router = new \Phalcon\Mvc\Router();

//router group
$auth = new \Phalcon\Mvc\Router\Group(array('controller' => 'auth'));
$auth->add('/create-user', array('action' => 'createUser'))->setName('createUser');
$auth->add('/login', array('action' => 'login'))->setName('login');
$auth->add('/logout', array('action' => 'logout'))->setName('logout');
$router->mount($auth);

$user = new \Phalcon\Mvc\Router\Group(array('controller' => 'user'));
$user->add('/user/create', array('action' => 'create'))->setName('userCreate');
$user->add('/user/find', array('action' => 'find'))->setName('userFind');
$user->add('/user/update', array('action' => 'update'))->setName('userUpdate');
$user->add('/user/delete', array('action' => 'delete'))->setName('userDelete');
$router->mount($user);

//add a single route with a url parameter
$router->add('/page/{name}', array(
    'controller' => 'page',
    'action' => 'index',
))->setName('page');

return $router;
