<?php

namespace app\models\pivot;

/**
 * This is the model class for table "pivot".
 *
 * @property int|null $idApo
 * @property string|null $idalumno
 * @property int|null $idano
 * @property string|null $motivo
 * @property int|null $idCurso
 * @property string $idpivote
 *
 * @property Alumnos $idalumno0
 * @property Anos $idano0
 * @property Cursos $idCurso0
 * @property Apoderados $idApo0
 */
use app\models\alumnos\Alumnos;
use app\models\anos\Anos;
use app\models\apoderados\Apoderados;
use app\models\cursos\Cursos;

class Pivot extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pivot';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idApo' => 'Id Apo',
            'idalumno' => 'Idalumno',
            'idano' => 'Idano',
            'motivo' => 'Motivo',
            'idCurso' => 'Id Curso',
            'idpivote' => 'Idpivote',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdalumno0()
    {
        return $this->hasOne(Alumnos::className(), ['idalumno' => 'idalumno']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdano0()
    {
        return $this->hasOne(Anos::className(), ['idano' => 'idano']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCurso0()
    {
        return $this->hasOne(Cursos::className(), ['idCurso' => 'idCurso']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdApo0()
    {
        return $this->hasOne(Apoderados::className(), ['idApo' => 'idApo']);
    }
}
