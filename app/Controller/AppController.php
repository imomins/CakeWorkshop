<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    public $components = array(
        'Session',
        'Auth' => array(
            'loginAction' => array(
                'controller' => 'users',
                'action' => 'login',
            ),
            'authenticate' => array(
                'Form' => array(
                    'fields' => array(
                        'username' => 'email'
                    ),
                    'scope' => array(
                        'User.email_confirmed' => 1,
                        'User.active' => 1
                    )
                )
            ),
            'authorize' => 'controller'
        ),
    );

    public function beforeFilter() {
        $this->Auth->fields = array('username' => 'email', 'password' => 'password');

        // Used in views
        $this->set('loggedIn', $this->Auth->loggedIn());
        $this->set('group', $this->Auth->user('Group.name'));
        $this->set('username', $this->Auth->user('name'));
    }

    public function isAuthorized($user) {
        // If a admin method is accessed the users group must also be admin
        if (!empty($this->request->params['prefix']) && $this->request->params['prefix'] === 'admin') {
            return $this->isAdmin();
        }
        return true;
    }

    protected function isAdmin() {
        return $this->Auth->user('Group.name') === 'admin';
    }

    protected function isAttendee() {
        return $this->Auth->user('Group.name') === 'attendee';
    }

    protected function isAssistant() {
        return $this->Auth->user('Group.name') === 'assistant';
    }

    protected function getUserId() {
        return $this->Auth->user('id');
    }

    protected function getRandomString() {
        return Security::hash(rand(100000, 100000000000000));
    }

}
