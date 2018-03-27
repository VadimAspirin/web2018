<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $firstName
 * @property string $secondName
 * @property string $lastName
 * @property string $login
 * @property string $password
 * @property int $role
 * @property string $tokenTerminal
 *
 * @property WorkspaceAndOperator[] $workspaceAndOperators
 */
class Users extends ActiveRecord implements IdentityInterface
{
    const ROLE_ADMIN = 0;
	const ROLE_OPERATOR = 1;
	const ROLE_TERMINAL = 2;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }
    
    public function validatePassword($password)
	{
		return $this->password === $password;
	}

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['firstName', 'secondName', 'lastName', 'login', 'password', 'role'], 'required'],
            [['role'], 'integer'],
            [['firstName', 'secondName', 'lastName', 'login'], 'string', 'max' => 50],
            [['password', 'tokenTerminal'], 'string', 'max' => 150],
            [['login'], 'unique'],
            ['role', 'in', 'range' => [self::ROLE_ADMIN, self::ROLE_OPERATOR, self::ROLE_TERMINAL]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'firstName' => 'First Name',
            'secondName' => 'Second Name',
            'lastName' => 'Last Name',
            'login' => 'Login',
            'password' => 'Password',
            'role' => 'Role',
            'tokenTerminal' => 'Token Terminal',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWorkspaceAndOperators()
    {
        return $this->hasMany(WorkspaceAndOperator::className(), ['operatorId' => 'id']);
    }
    
    
    //=======================IdentityInterface==========================
	
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
        return static::findOne(['tokenTerminal' => $token]);
    }

    public function getAuthKey()
    {
        
    }
    
    public function validateAuthKey($authKey)
    {
        
    }
}
