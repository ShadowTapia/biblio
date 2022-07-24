<?php

namespace app\models;

use yii\web\IdentityInterface;
use yii\base\BaseObject;
/**
 * Class User
 * @package app\models
 */
class User extends BaseObject implements IdentityInterface
{
    
    public $idUser;
    public $UserRut;
    public $UserMail;
    public $UserName;
    public $UserLastName;
    public $UserPass;
    public $Idroles;
    public $authkey;
    public $accessToken;
    public $activate;
    public $verification_code;


    /**
     * @param int|string $id
     * @return null|static
     */
    public static function findIdentity($id)
    {
        $user = Users::find()
                ->where("activate=:activate", [":activate" => '1'])
                ->andWhere("idUser=:idUser",["idUser" => $id])
                ->one();
                
        return isset($user) ? new static($user) : null;
    }

    /**
     * {@inheritdoc}
     */
     
    /** Busca la identidad del usuario a tráves de su token de acceso */
    /**
     * @param mixed $token
     * @param null $type
     * @return null|static
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $users = Users::find()
                ->where("activate=:activate", [":activate" => '1'])
                ->andWhere("accessToken=:accessToken", [":accessToken" => $token])
                ->all();
                
        foreach ($users as $user) {
            if ($user->accessToken === $token) {
                return new static($user);
            }
        }

        return null;
    }
    
    /**
     * Finds user by userRun
     * 
     * @param int $userRun
     * @return static|null
     **/
    public static function findByUserrut($userRun)
    {
        $users = Users::find()
                ->where("activate=:activate", [":activate" => '1'])
                ->andWhere("UserRut=:UserRut", [":UserRut" => $userRun])
                ->all();
                
        foreach ($users as $user){
            if($user->UserRut == $userRun){
                return new static($user);
            }
        }
        
        return null;
    }

    /**
     * @param $id
     * @return bool
     * Retorna verdadero si el usuario es Administrador
     */
    public static function isUserAdmin($id)
    {
        if(Users::findOne(['idUser'=>$id,'activate'=>'1','Idroles'=>1]))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * @param $id
     * @return bool
     * Valida si el usuario que loguea tiene permisos relacionados a Bilbiotecario
     */
    public static function isUserBiblio($id)
    {
        if(Users::findOne(['idUser'=>$id,'activate'=>'1','Idroles'=>2]))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * @param $id
     * @return bool
     * Valida si el usuario que loguea es un Inspector
     */
    public static function isUserInspec($id)
    {
        if(Users::findOne(['idUser' => $id, 'activate' => '1', 'Idroles' => 11]))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * @param $id
     * @return bool
     * Valida si el usuario que loguea es un profesor
     */
    public static function isUserProfe($id)
    {
        if(Users::findOne(['idUser' => $id, 'activate' => '1', 'Idroles' => 3]))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * @param $id
     * @return bool
     */
    public static function isUserAlumno($id)
    {
        if(Users::findOne(['idUser' => $id, 'activate' => '1', 'Idroles' => 5]))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * @param $id
     * @return bool
     */
    public static function isUserFuncionario($id)
    {
        if(Users::findOne(['idUser' => $id, 'activate' => '1', 'Idroles' => 12]))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->idUser;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthkey()
    {
        return $this->authkey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        /* Valida el password */
        if(crypt($password, $this->UserPass) == $this->UserPass)
        {
            return $password === $password;    
        }
        return null;
    }

}
