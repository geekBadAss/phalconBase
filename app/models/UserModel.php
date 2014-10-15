<?php
/**
 * UserModel
 *
 * PHP Version 5.3
 *
 * @package   BusinessModels
 * @author    aidan lydon <alyo@loc.gov>
 * @copyright 2014 The Library of Congress
 * @license   Copyright 2014 The Library of Congress
 * @version   $Id:$
 * @link      TBD
 * @since     Sept 24, 2014
 */
class UserModel extends BusinessModel
{
    /**
     * createUser
     *
     * @param array $params
     *
     * @return boolean
     */
    public function createUser($params)
    {
        $ret = false;

        try {
            if (!isset($params['username']) || empty($params['username'])) {
                $this->addError('You must provide a username.');
            } elseif (User::findByUsername($params['username'])) {
                $this->addError('That Username is already in use.');
            } elseif (!isset($params['password']) || empty($params['password'])) {
                $this->addError('You must provide a password.');
            } elseif (!isset($params['confirm']) || empty($params['confirm'])) {
                $this->addError('You must confirm your password.');
            } elseif ($params['password'] != $params['confirm']) {
                $this->addError('Password and confirmation must match.');
            } else {
                if (!isset($params['firstName'])) {
                    $this->addError('You must provide a firstName.');
                }
                if (!isset($params['lastName'])) {
                    $this->addError('You must provide a lastName.');
                }
                if (!isset($params['email'])) {
                    $this->addError('You must provide an email.');
                }
                if (!isset($params['phone'])) {
                    $this->addError('You must provide a phone.');
                }
                if (!isset($params['address'])) {
                    $this->addError('You must provide an address.');
                }
                if (!isset($params['city'])) {
                    $this->addError('You must provide a city.');
                }
                if (!isset($params['state'])) {
                    $this->addError('You must provide a state.');
                }
                if (!isset($params['zip'])) {
                    $this->addError('You must provide a zip.');
                }
            }

            if (empty($this->errors)) {
                //valid params
                $user = new User(
                    array(
                        'username'  => $params['username'],
                        'firstName' => $params['firstName'],
                        'lastName'  => $params['lastName'],
                        'email'     => $params['email'],
                        'phone'     => $params['phone'],
                        'address'   => $params['address'],
                        'city'      => $params['city'],
                        'state'     => $params['state'],
                        'zip'       => $params['zip'],
                        'active'    => 1,
                    )
                );

                $user->createHash($params['password']);

                if (!$user->insert()) {
                    $this->addError('Unable to create an account.');
                } else {
                    $ret = $this->login($params);
                }
            }

        } catch (Exception $e) {
            //@codeCoverageIgnoreStart
            xlog($e);
            //@codeCoverageIgnoreEnd
        }

        return $ret;
    }

    /**
     * login
     *
     * @param array $params
     *
     * @return boolean
     */
    public function login($params)
    {
        $ret = false;

        try {
            if (!isset($params['username']) || empty($params['username'])) {
                $this->addError('You must provide a username.');
            } else {
                $this->data['username'] = $params['username'];
            }

            if (!isset($params['password']) || empty($params['password'])) {
                $this->addError('You must provide a password.');
            }

            //             $loginAttempt = new LoginAttempt(
            //                 array(
            //                     'username'      => $this->data['username'],
            //                     'password'      => '',
            //                     'status'        => 'login failed',
            //                     'datetime'      => date('Y-m-d H:i:s'),
            //                     'userSessionId' => 0,
            //                 )
            //             );

            if (empty($this->errors)) {
                $user = User::findByUsername($params['username']);

                if (!empty($user)) {

                    $validPassword = $user->validatePassword($params['password']);
                    $userActive = $user->active == 1;

                    if ($validPassword && $userActive) {
                        //insert a UserSession
                        //                         $userSession = new UserSession(
                        //                             array(
                        //                                 'phpSessionId' => session_id(),
                        //                                 'loginDate'    => date('Y-m-d'),
                        //                                 'loginTime'    => date('H:i:s'),
                        //                                 'logoutDate'   => '0000-00-00',
                        //                                 'logoutTime'   => '00:00:00',
                        //                                 'userState'    => 'logged in',
                        //                                 'userId'       => 0//$user->userId,
                        //                             )
                        //                         );
                        //                         $userSession->insert();

                        Session::set(
                            array(
                                'userId'        => $user->userId,
                                'username'      => $user->username,
                                'firstName'     => $user->firstName,
                                'lastName'      => $user->lastName,
                                'email'         => $user->email,
                                'phone'         => $user->phone,
                                'address'       => $user->address,
                                'city'          => $user->city,
                                'state'         => $user->state,
                                'zip'           => $user->zip,
                                //'userSessionId' => $userSession->userSessionId,
                            )
                        );

                        //the login attempt was successful
                        //$loginAttempt->status = 'login successful';
                        //$loginAttempt->userSessionId = $userSession->userSessionId;

                        $ret = true;

                    } else {
                        $this->addError('Invalid Username or Password.');
                    }
                }
            }

            //$loginAttempt->insert();

        } catch (Exception $e) {
            //@codeCoverageIgnoreStart
            xlog($e);
            //@codeCoverageIgnoreEnd
        }

        return $ret;
    }

    /**
     * logout
     *
     * @return null
     */
    public function logout()
    {
        try {
            //             if ($userSession = UserSession::find(Session::get('userSessionId'))) {
            //                 $userSession->logoutDate = date('Y-m-d');
            //                 $userSession->logoutTime = date('H:i:s');
            //                 $userSession->userState = 'logged out';
            //                 $userSession->update();
            //             }

            Session::destroy();

        } catch (Exception $e) {
            //@codeCoverageIgnoreStart
            xlog($e);
            //@codeCoverageIgnoreEnd
        }
    }

    /**
     * findUser
     *
     * @param array $params
     *
     * @return null
     */
    public function findUser($params)
    {
        try {
            if (!isset($params['userId'])) {
                $this->data = array();
                $this->addError('You must provide a userId.');
            } else {
                $user = User::find($params['userId']);
                $this->data = $user->toArray();
            }

        } catch (Exception $e) {
            //@codeCoverageIgnoreStart
            xlog($e);
            //@codeCoverageIgnoreEnd
        }
    }

    /**
     * updateUser
     *
     * @param array $params
     *
     * @return null
     */
    public function updateUser($params)
    {
        try {
            if (!isset($params['userId'])) {
                $this->data = array();
                $this->addError('You must provide a userId.');
            }

            //TODO: add more error checking

            if (empty($this->errors)) {
                $user = User::find($params['userId']);
                $tmp = $user->toArray();
                $tmp['hash'] = $user->hash;
                $tmp['active'] = $user->active;

                $user = new User(array_merge($tmp, $params));
                $user->update();

                $this->data = $user->toArray();
            }

        } catch (Exception $e) {
            //@codeCoverageIgnoreStart
            xlog($e);
            //@codeCoverageIgnoreEnd
        }
    }

    /**
     * deleteUser
     *
     * @param array $params
     *
     * @return null
     */
    public function deleteUser($params)
    {
        //TODO: add acl check here
        try {
            if (!isset($params['userId'])) {
                $this->data = array();
                $this->addError('You must provide a userId.');
            }

            if (empty($this->errors)) {
                $user = User::find($params['userId']);
                $user->active = 0;
                $deactivated = $user->update();

                $this->data = array();
                if ($deactivated == 1) {
                    $this->addStatus($deactivated . ' User deleted.');
                } else {
                    //this will never run, this is to illustrate the potential granularity of status
                    //messages
                    $this->addStatus($deactivated . ' Users deleted.');
                }
            }

        } catch (Exception $e) {
            //@codeCoverageIgnoreStart
            xlog($e);
            //@codeCoverageIgnoreEnd
        }
    }
}
