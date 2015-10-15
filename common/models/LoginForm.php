<?php

namespace common\models;

use Yii;
use yii\base\Model;
use kartik\builder\Form;

/**
 * LoginForm is the model behind the login form.
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = false;

    private $_user = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     */
    public function validatePassword()
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError('password', 'Usuario o Contraseña incorrecto.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
        	$log = Yii::$app->user->login($this->getUser(),3600*24*30);
        	if($log){
        		$user = $this->getUser();
        		$user->usu_ulting = date('Y-m-d H:i:s');
                //$user->generaToken();
				//$user->update(array('usu_ulting','usu_token'));
                $user->update(array('usu_ulting'));
                if($this->rememberMe){
                    Yii::$app->session->setFlash('SelEmpresa',true);
                }
        	}
            return $log;
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = Osusuarios::findByUsername($this->username);
        }

        return $this->_user;
    }
    
    /**
     * Form atributes
     * @return Array Attributes
     */
    public function getFormAttributes()
    {
    	return [
			'username' => [
				'type'=>Form::INPUT_TEXT,
				'label' => '',
				'options'=>[
					'placeholder'=> Yii::t('app','Username...')
				]
			],
			'password' => [
				'type'=>Form::INPUT_PASSWORD,
				'label' => '',
				'options'=>[
					'placeholder'=> Yii::t('app','Password...')
				]
			],
			'rememberMe' => [
				'type'=>Form::INPUT_CHECKBOX,
				'options'=>[
					'label'=> Yii::t('app','Select Company')
				]
			],
    	];
    }
}
