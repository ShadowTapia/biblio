<?php

namespace app\models\prestamos;
/**
 * This is the model class for table "prestamos".
 *
 * @property string $idPrestamo
 * @property string|null $idUser
 * @property string|null $idejemplar
 * @property string|null $norden
 * @property string|null $fechapres
 * @property string|null $fechadev
 * @property string|null $notas
 *
 * @property Ejemplar $idejemplar0
 * @property Users $idUser0
 */

use app\models\ejemplar\Ejemplar;
use app\models\Users;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
/**
 * Class Prestamos
 * @package app\models\prestamos
 */
class Prestamos extends ActiveRecord
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
            [['fechapres', 'fechadev'], 'required', 'message' => 'Campo requerido'],
            [['idPrestamo', 'idUser', 'idejemplar'], 'string', 'max' => 15],
            [['norden'], 'string', 'max' => 5],
            [['notas'], 'string', 'max' => 255],
            [['idPrestamo'], 'unique'],
            [['idejemplar'], 'exist', 'skipOnError' => true, 'targetClass' => Ejemplar::class, 'targetAttribute' => ['idejemplar' => 'idejemplar']],
            [['idUser'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['idUser' => 'idUser']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idPrestamo' => 'Id Prestamo',
            'idUser' => 'Id Usuario',
            'idejemplar' => 'Id Ejemplar',
            'norden' => 'N° orden',
            'fechapres' => 'Fecha prestamo',
            'fechadev' => 'Fecha devolución',
            'notas' => 'Notas',
        ];
    }

    /**
     * Gets query for [[Idejemplar0]].
     *
     * @return ActiveQuery
     */
    public function getIdejemplar0()
    {
        return $this->hasOne(Ejemplar::class, ['idejemplar' => 'idejemplar']);
    }

    /**
     * Gets query for [[IdUser0]].
     *
     * @return ActiveQuery
     */
    public function getIdUser0()
    {
        return $this->hasOne(Users::class, ['idUser' => 'idUser']);
    }
}
