<?php

namespace app\models;

use Yii;
use yii\base\Model;

class LoginForm extends Model
{

	public $login;
	public $password;
	
	public function rules()
    {
        return [
            [['login', 'password'], 'required'],
            ['password', 'validatePassword']
        ];
    }
    
    public function validatePassword($attribute, $params)
    {
		if(!$this->hasErrors())
		{
			$user = $this->getUser();
		
			if(!$user || !$user->validatePassword($this->password))
			{
				$this->addError($attribute, 'Пароль или пользователь введены неверно');
			}
		}
    }
    
    public function getUser()
    {
		return Users::findOne(['login' => $this->login]);
    }
    
}
