<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class Users extends ActiveRecord implements IdentityInterface
{
	
	public static function tableName()
	{
		return '{{users}}';
	}
	
	public function validatePassword($password)
	{
		return $this->password === $password;
	}
	
	//==================================================================
	
	public static function findIdentity($id)
    {
        return self::findOne($id);
    }

	public function getId()
    {
        return $this->getPrimaryKey();
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        
    }

    public function getAuthKey()
    {
        
    }
    
    public function validateAuthKey($authKey)
    {
        
    }
}
