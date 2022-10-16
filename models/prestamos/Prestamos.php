<?php

namespace app\models\prestamos;

use Yii;
use app\models\Users;
use app\models\ejemplar\Ejemplar;
use app\models\anos\Anos;

/**
 * This is the model class for table "prestamos".
 *
 * @property string $idPrestamo
 * @property string|null $idUser
 * @property string|null $idejemplar
 * @property string|null $norden
 * @property string|null $fechapres Fecha en que realizado el prestamo
 * @property string|null $fechadev Fecha en que debe ser devuelto
 * @property string|null $notas
 * @property int $idano Corresponde al año de ingreso
 *
 * @property Users $idUser0
 * @property Ejemplar $idejemplar0
 * @property Anos $idano0
 */
class Prestamos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prestamos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fechapres', 'fechadev'], 'safe'],
            [['idano'], 'integer'],
            [['idPrestamo', 'idUser', 'idejemplar'], 'string', 'max' => 15],
            [['norden'], 'string', 'max' => 5],
            [['notas'], 'string', 'max' => 255],
            [['idPrestamo'], 'unique'],
            [['idUser'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['idUser' => 'idUser']],
            [['idejemplar'], 'exist', 'skipOnError' => true, 'targetClass' => Ejemplar::class, 'targetAttribute' => ['idejemplar' => 'idejemplar']],
            [['idano'], 'exist', 'skipOnError' => true, 'targetClass' => Anos::class, 'targetAttribute' => ['idano' => 'idano']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idPrestamo' => 'Id Prestamo',
            'idUser' => 'Id User',
            'idejemplar' => 'Id ejemplar',
            'norden' => 'N. Orden',
            'fechapres' => 'F. prestamo',
            'fechadev' => 'F. devolución',
            'notas' => 'Notas',
            'idano' => 'Id Ano',
        ];
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
     * Gets query for [[Idano0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdano0()
    {
        return $this->hasOne(Anos::class, ['idano' => 'idano']);
    }
}
