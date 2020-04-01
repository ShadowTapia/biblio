<?php

namespace app\models;


class User extends \yii\base\BaseObject implements \yii\web\IdentityInterface
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
     * {@inheritdoc}
     */
     
    /** Busca la identidad del usuario a tráves de su $id **/
     
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
        
    }

}
