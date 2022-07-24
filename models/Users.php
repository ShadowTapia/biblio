<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use app\models\alumnos\Alumnos;
use app\models\prestamos\Prestamos;

/**
 * This is the model class for table "users".
 *
 * @property string $idUser
 * @property string|null $UserName
 * @property string|null $UserLastName
 * @property string|null $UserPass
 * @property int|null $Idroles
 * @property int|null $UserRut
 * @property string|null $UserMail
 * @property string|null $authkey
 * @property string|null $accessToken
 * @property string|null $activate
 * @property string|null $verification_code
 *
 * @property Alumnos[] $alumnos
 * @property Historico[] $historico
 * @property Prestamos[] $prestamos
 * @property Reserva[] $reservas
 * @property Roles $idroles
 */
class Users extends ActiveRecord
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
    public function rules()
    {
        return [
            [['Idroles', 'UserRut'], 'integer'],
            [['activate'], 'string'],
            [['idUser'], 'string', 'max' => 15],
            [['UserName', 'UserLastName'], 'string', 'max' => 45],
            [['UserPass'], 'string', 'max' => 700],
            [['UserMail'], 'string', 'max' => 150],
            [['authkey', 'accessToken', 'verification_code'], 'string', 'max' => 255],
            [['UserRut'], 'unique'],
            [['idUser'], 'unique'],
            [['Idroles'], 'exist', 'skipOnError' => true, 'targetClass' => Roles::class, 'targetAttribute' => ['Idroles' => 'idroles']],
        ];
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
     * Gets query for [[Alumnos]].
     *
     * @return ActiveQuery
     */
    public function getAlumnos()
    {
        return $this->hasMany(Alumnos::class, ['rutalumno' => 'UserRut']);
    }

    /**
     * Gets query for [[Historicos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHistoricos()
    {
        return $this->hasMany(Historico::class, ['idUser' => 'idUser']);
    }

    /**
     * Gets query for [[Prestamos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPrestamos()
    {
        return $this->hasMany(Prestamos::class, ['idUser' => 'idUser']);
    }

    /**
     * Gets query for [[Reservas]].
     *
     * @return ActiveQuery
     */
    public function getReservas()
    {
        return $this->hasMany(Reserva::class, ['idUser' => 'idUser']);
    }

    /**
     * Gets query for [[Idroles]].
     *
     * @return ActiveQuery
     */
    public function getIdroles()
    {
        return $this->hasOne(Roles::class, ['idroles' => 'Idroles']);
    }

    /**
     * @return array
     */
    public static function getListafuncionarios()
    {
        return self::find()->select(['concat(UserLastName,SPACE(1),UserName) as name','UserRut as UserRut'])
                ->where(['Idroles'=> '12'])
                ->orWhere(['Idroles'=> '11'])
                ->orderBy('UserLastName')->addOrderBy('UserName')->column();
    }
}
