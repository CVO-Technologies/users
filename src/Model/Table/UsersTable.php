<?php

namespace Croogo\Users\Model\Table;

use Cake\Validation\Validator;
use Croogo\Croogo\Model\Table\CroogoTable;

class UsersTable extends CroogoTable {

	protected $_displayFields = array(
		'id',
		'role.title' => 'Role',
		'username',
		'name',
		'status' => array('type' => 'boolean'),
		'email',
	);

	protected $_editFields = array(
		'role_id',
		'username',
		'name',
		'email',
		'website',
		'status',
	);

	public $filterArgs = array(
		'name' => array('type' => 'like', 'field' => array('Users.name', 'Users.username')),
		'role_id' => array('type' => 'value'),
	);

	public function initialize(array $config) {
		parent::initialize($config);

		$this->belongsTo('Croogo/Users.Roles');
		$this->addBehavior('Search.Searchable');
	}

	public function validationDefault(Validator $validator) {
		return $validator
			->add('username', [
				'notEmpty' => [
					'rule' => 'notEmpty',
					'message' => 'The username has already been taken.',
					'last' => true
				],
				'validateUnique' => [
					'rule' => 'validateUnique',
					'provider' => 'table',
					'message' => 'The username has already been taken.',
					'last' => true
				],
				'alphaNumeric' => [
					'rule' => 'alphaNumeric',
					'message' => 'This field must be alphanumeric',
					'last' => true
				]
			])
			->add('email', [
				'notEmpty' => [
					'rule' => 'notEmpty',
					'message' => 'The username has already been taken.',
					'last' => true
				],
				'email' => [
					'rule' => 'email',
					'message' => 'Please provide a valid email address.',
					'last' => true
				],
				'validateUnique' => [
					'rule' => 'validateUnique',
					'provider' => 'table',
					'message' => 'Email address already in use.',
					'last' => true
				]
			])
			->add('password', [
				'minLength' => [
					'rule' => ['minLength', 6],
					'message' => 'Passwords must be at least 6 characters long.',
					'last' => true
				],
				'compareWith' => [
					'rule' => ['compareWith', 'verify_password'],
					'message' => 'Passwords do not match. Please, try again',
					'last' => true
				]
			])
			->add('name', [
				'notEmpty' => [
					'rule' => 'notEmpty',
					'message' => 'This field cannot be left blank.',
					'last' => true
				],
//				'alphaNumeric' => [
//					'rule' => 'alphaNumeric',
//					'message' => 'This field must be alphanumeric',
//					'last' => true
//				]
			])
			->allowEmpty('website')
			->add('website', [
				'url' => [
					'rule' => 'url',
					'message' => 'This field must be a valid URL',
					'last' => true
				]
			]);
	}

}
