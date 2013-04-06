<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 * @property Title $Title
 * @property Gender $Gender
 * @property Department $Department
 * @property Group $Group
 * @property CoursesTerm $CoursesTerm
 */
class User extends AppModel {

    var $actsAs = array('Containable');

    public $virtualFields = array(
        'name' => "CONCAT(User.firstname, ' ', User.lastname)"
    );

    public $displayField = 'name';

    public function search($name) {
        $this->recursive = -1;

        return $this->find('list',
            array(
                'fields'     => array('User.id', 'User.name'),
                'conditions' => array("User.name LIKE" => '%' . $name . '%')
            )
        );
    }

    public function findUserIdByEmail($email) {
        return $this->find('first', array(
            'recursive'  => -1,
            'fields'     => array('User.id'),
            'conditions' => array('User.email' => $email)
        ));
    }

    public function findUserIdByHash($hash) {
        return $this->find('first', array(
            'recursive'  => -1,
            'fields'     => array('User.id'),
            'conditions' => array('User.hash' => $hash)
        ));
    }

    public function activate($hash) {
        if (!isset($hash)) {
            throw new Exception(__('Ungültige Argumente.'));
        }

        $user = $this->find('first',
            array(
                'conditions' => array('hash' => $hash),
                'fields'     => array('id'),
                'recursive'  => -1
            )
        );
        if (isset($user['User']['id'])) {
            return $this->updateAll(
                array(
                    'hash'            => null,
                    'active'          => true,
                    'email_confirmed' => true
                ),
                array(
                    'User.id' => $user['User']['id']
                )
            );
        }
        else {
            throw new NotFoundException(__('Es wurde kein Aktivierungscode gefunden.'));
        }
    }

    public function passCompare() {
        return strcmp($this->data[$this->alias]['password'], $this->data[$this->alias]['password_confirm']) === 0;
    }

    public function beforeSave($options = array()) {
        if (isset($this->data['User']['password'])) {
            $this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
        }
        return true;
    }

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'email'            => array(
            'email' => array(
                'rule' => array('email'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'password'         => array(
            'notempty'     => array(
                'rule'    => array('notempty'),
                'message' => 'Bitte ein passwort angeben',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'min'          => array(
                'rule'    => array('minLength', '5'),
                'message' => 'Das Passwort muss mindestens 5 Zeichen lang sein'
            ),
            'pass_compare' => array(
                'rule'    => array('passCompare'),
                'message' => 'Die Passwörter stimmen nicht überein'
            )
        ),
        'password_confirm' => array(
            'notempty'     => array(
                'rule'    => array('notempty'),
                'message' => 'Bitte ein passwort angeben',
            ),
            'min'          => array(
                'rule'    => array('minLength', '5'),
                'message' => 'Das Passwort muss mindestens 5 Zeichen lang sein'
            ),
            'pass_compare' => array(
                'rule'    => array('passCompare'),
                'message' => 'Die Passwörter stimmen nicht überein'
            )
        ),
        'firstname'        => array(
            'notempty' => array(
                'rule' => array('notempty'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'lastname'         => array(
            'notempty' => array(
                'rule' => array('notempty'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'gender_id'        => array(
            'numeric' => array(
                'rule' => array('numeric'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'department_id'    => array(
            'numeric' => array(
                'rule' => array('numeric'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'occupation'       => array(
            'notempty' => array(
                'rule' => array('notempty'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'phone'            => array(
            'notempty' => array(
                'rule' => array('notempty'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'group_name'       => array(
            'numeric' => array(
                'rule' => array('notempty'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'email_confirmed'  => array(
            'notempty' => array(
                'rule' => array('notempty'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'active'           => array(
            'notempty' => array(
                'rule' => array('notempty'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        )
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Gender'     => array(
            'className'  => 'Gender',
            'foreignKey' => 'gender_id',
            'conditions' => '',
            'fields'     => '',
            'order'      => ''
        ),
        'Department' => array(
            'className'  => 'Department',
            'foreignKey' => 'department_id',
            'conditions' => '',
            'fields'     => '',
            'order'      => ''
        ),
        'Group'      => array(
            'className'  => 'Group',
            'foreignKey' => 'group_name',
            'conditions' => '',
            'fields'     => '',
            'order'      => ''
        )
    );

    /**
     * hasAndBelongsToMany associations
     *
     * @var array
     */
    public $hasAndBelongsToMany = array(
        'CoursesTerm' => array(
            'className'             => 'CoursesTerm',
            'joinTable'             => 'bookings',
            'foreignKey'            => 'user_id',
            'associationForeignKey' => 'courses_term_id',
            'unique'                => 'keepExisting',
            'conditions'            => '',
            'fields'                => '',
            'order'                 => '',
            'limit'                 => '',
            'offset'                => '',
            'finderQuery'           => '',
            'deleteQuery'           => '',
            'insertQuery'           => ''
        )
    );

    public $hasMany = array(
        'Invoice' => array(
            'className'    => 'Invoice',
            'foreignKey'   => 'invoice_id',
            'dependent'    => true,
            'conditions'   => '',
            'fields'       => '',
            'order'        => '',
            'limit'        => '',
            'offset'       => '',
            'exclusive'    => '',
            'finderQuery'  => '',
            'counterQuery' => ''
        ),
        'Booking' => array(
            'className'    => 'Booking',
            'foreignKey'   => 'booking_id',
            'dependent'    => true,
            'conditions'   => '',
            'fields'       => '',
            'order'        => '',
            'limit'        => '',
            'offset'       => '',
            'exclusive'    => '',
            'finderQuery'  => '',
            'counterQuery' => ''
        )
    );

}
