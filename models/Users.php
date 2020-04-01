<?php

namespace app\models;

/**
 * This is the model class for table "users".
 *
 * @property string $idUser
 * @property string|null $UserName
 * @property string|null $UserLastName
 * @property string|null $UserPass
 * @property int|null $Idroles
 * @property int $UserRut
 * @property string|null $UserMail
 * @property string|null $authkey
 * @property string|null $accessToken
 * @property string|null $activate
 * @property string|null $verification_code
 *
 * @property Roles $roles
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idUser' => 'Id User',
            'UserName' => 'User Name',
            'UserLastName' => 'User Last Name',
            'UserPass' => 'User Pass',
            'Idroles' => 'Idroles',
            'UserRut' => 'User Rut',
            'UserMail' => 'User Mail',
            'authkey' => 'Authkey',
            'accessToken' => 'Access Token',
            'activate' => 'Activate',
            'verification_code' => 'Verification Code',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoles()
    {
        return $this->hasOne(Roles::className(), ['idroles' => 'Idroles']);
    }
    
    /**
     * Obtiene el nombre de los roles asignados 
     * 
     */
    public function getNombreRol()
    {
        return $this->roles->nombre;
    }
}
