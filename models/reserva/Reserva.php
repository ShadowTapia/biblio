<?php

namespace app\models\reserva;

use yii\db\ActiveRecord;
use app\models\libros\Libros;
use app\models\Users;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "reserva".
 *
 * @property string $idreserva
 * @property string|null $idUser
 * @property string|null $idLibros
 * @property string|null $fechaR
 * @property string|null $estado
 *
 * @property Libros $idLibros0
 * @property Users $idUser0
 */

/**
 * Class Reserva
 * @package app\models\reserva
 */
class Reserva extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reserva';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idreserva'], 'required'],
            [['fechaR'], 'safe'],
            [['estado'], 'string'],
            [['idreserva', 'idUser', 'idLibros'], 'string', 'max' => 15],
            [['idreserva'], 'unique'],
            [['idLibros'], 'exist', 'skipOnError' => true, 'targetClass' => Libros::class, 'targetAttribute' => ['idLibros' => 'idLibros']],
            [['idUser'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['idUser' => 'idUser']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idreserva' => 'Idreserva',
            'idUser' => 'Id User',
            'idLibros' => 'Id Libros',
            'fechaR' => 'Fecha R',
            'estado' => 'Estado',
        ];
    }

    /**
     * Gets query for [[IdLibros0]].
     *
     * @return ActiveQuery
     */
    public function getIdLibros0()
    {
        return $this->hasOne(Libros::class, ['idLibros' => 'idLibros']);
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
