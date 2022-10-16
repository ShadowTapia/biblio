<?php

namespace app\modules\apiv1\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\web\UnauthorizedHttpException;

/**
 * Class User
 * @package app\models
 */
class User extends ActiveRecord implements IdentityInterface
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
    public $expire_at;
    public $activate;
    public $verification_code;

    /**
     * Generate accessToken string
     * @return string
     * @throws \yii\base\Exception
     */
    public function generateAccessToken()
    {
        $this->accessToken = Yii::$app->security->generateRandomString();
        return $this->accessToken;
    }

    /**
     * 
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        //throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
        $user = static::find()->where(['accessToken' => $token, 'status' => self::STATUS_ACTIVE])->one();

        if (!$user) {
            return false;
        }
        if ($user->expire_at < time()) {
            throw new UnauthorizedHttpException('the access - token expired', -1);
        } else {
            return $user;
        }
    }

    /**
     * @param int|string $id
     * @return null|static
     */
    public static function findIdentity($id)
    {
        $user = User::find()
            ->where("activate=:activate", [":activate" => '1'])
            ->andWhere("idUser=:idUser", ["idUser" => $id])
            ->one();

        return isset($user) ? new static($user) : null;
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
}
