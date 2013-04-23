<?php
/**
 * Application level Controller
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 * PHP 5
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
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
            'loginAction'  => array(
                'controller' => 'users',
                'action'     => 'login',
            ),
            'authError'    => 'Bitte melden Sie sich an',
            'authenticate' => array(
                'Form' => array(
                    'fields' => array(
                        'username' => 'email'
                    ),
                    'scope'  => array(
                        'User.email_confirmed' => 1,
                        'User.active'          => 1
                    )
                )
            ),
            'authorize'    => 'controller'
        ),
    );

    public function beforeFilter() {
        $this->Auth->fields = array('username' => 'email', 'password' => 'password');

        // Used in views
        $this->set('loggedIn', $this->Auth->loggedIn());
        $this->set('group', $this->Auth->user('Group.name'));
        $this->set('isAdmin', $this->isAdmin());
        $this->set('username', $this->Auth->user('name'));
        $this->set('brandLink', $this->brandLink());
    }

    public function brandLink() {
        if ($this->isAdmin() || $this->isAssistant()) {
            return '/admin/users';
        }
        elseif ($this->isAttendee()) {
            return '/users';
        }
        else {
            return '/';
        }
    }

    public function gotoHomeScreen() {
        if ($this->Auth->loggedIn()) {
            if ($this->isAdmin() || $this->isAssistant()) {
                $this->redirect('/admin/bookings');
            }
            else {
                $this->redirect('/bookings');
            }
        }
    }

    public function isAuthorized($user) {
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

}
