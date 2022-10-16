<?php

namespace app\models\historico;

use Yii;
use app\models\anos\Anos;
use app\models\ejemplar\Ejemplar;
use app\models\Users;

/**
 * This is the model class for table "historico".
 *
 * @property string $idhistorico
 * @property string|null $idUser
 * @property string|null $idejemplar
 * @property string|null $fechapres
 * @property string|null $fechadev
 * @property string|null $fechadevReal
 * @property string|null $observacion
 * @property string|null $User
 * @property string|null $UserMail
 * @property int|null $idAno
 *
 * @property Ejemplar $idejemplar0
 * @property Anos $idAno0
 * @property Users $idUser0
 */
class Historico extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'historico';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idhistorico'], 'required'],
            [['fechapres', 'fechadev', 'fechadevReal'], 'safe'],
            [['idAno'], 'integer'],
            [['idhistorico', 'idUser', 'idejemplar'], 'string', 'max' => 15],
            [['observacion'], 'string', 'max' => 255],
            [['User', 'UserMail'], 'string', 'max' => 150],
            [['idhistorico'], 'unique'],
            [['idejemplar'], 'exist', 'skipOnError' => true, 'targetClass' => Ejemplar::class, 'targetAttribute' => ['idejemplar' => 'idejemplar']],
            [['idAno'], 'exist', 'skipOnError' => true, 'targetClass' => Anos::class, 'targetAttribute' => ['idAno' => 'idano']],
            [['idUser'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['idUser' => 'idUser']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idhistorico' => 'Idhistorico',
            'idUser' => 'Id User',
            'idejemplar' => 'Idejemplar',
            'fechapres' => 'Fechapres',
            'fechadev' => 'Fechadev',
            'fechadevReal' => 'Fechadev Real',
            'observacion' => 'Observacion',
            'User' => 'User',
            'UserMail' => 'User Mail',
            'idAno' => 'Id Ano',
        ];
    }

    /**
     * Gets query for [[Idejemplar0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdejemplar0()
    {
        return $this->hasOne(Ejemplar::class, ['idejemplar' => 'idejemplar']);
    }

    /**
     * Gets query for [[IdAno0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdAno0()
    {
        return $this->hasOne(Anos::class, ['idano' => 'idAno']);
    }

    /**
     * Gets query for [[IdUser0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdUser0()
    {
        return $this->hasOne(Users::class, ['idUser' => 'idUser']);
    }
}
