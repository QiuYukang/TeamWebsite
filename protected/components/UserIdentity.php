<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */

Yii::import('application.vendor.*');
require_once('password_compat/password_compat.php');


class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	private $_id;
	public function authenticate()
	{
		
		$record=User::model()->findByAttributes(array('username'=>$this->username));
		if($record===null)
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        else if(!password_verify($this->password,$record->password))
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
        else
        {
            $this->_id=$record->id;
            $this->setState('email',$record->email);
            $this->setState('is_admin', $record->is_admin);
            $this->setState('is_manager', $record->is_manager);
            $this->setState('is_user', $record->is_user);
            $this->errorCode=self::ERROR_NONE;
        }
        return !$this->errorCode;


		/*
		$users=array(
			// username => password
			'demo'=>'demo',
			'admin'=>'admin',
		);
		if(!isset($users[$this->username]))
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		elseif($users[$this->username]!==$this->password)
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
			$this->errorCode=self::ERROR_NONE;
		return !$this->errorCode;
		*/
	}



	public function getId() {
		return $this->_id;
	}
}