<?php

/**
 * @author Marcelo
 * @copyright 2020
 */

namespace app\models\pivot;

use yii\base\Model;

/**
 * Class FormSelectPivot
 * @package app\models\pivot
 */
class FormSelectPivot extends Model
{
    
    public $idApo;
    public $idano;
    public $idCurso;
    public $motivo;
    public $idpivote;
    public $activo;
	public $retirado;
    public $idalumno;
    
        
    public function rules()
    {
       return [
            ['idCurso','required','message'=>'Campo requerido'],
            [['idApo', 'idano', 'idCurso'], 'integer'],
            [['idalumno', 'idpivote'], 'string', 'max' => 15],
            [['activo'],'string','max' => 1],
            [['motivo'], 'string', 'max' => 50],
            ['retirado','safe'],
            //[['idpivote'], 'unique'],
            //[['idalumno'], 'exist', 'skipOnError' => true, 'targetClass' => Alumnos::className(), 'targetAttribute' => ['idalumno' => 'idalumno']],
//            [['idano'], 'exist', 'skipOnError' => true, 'targetClass' => Anos::className(), 'targetAttribute' => ['idano' => 'idano']],
//            [['idApo'], 'exist', 'skipOnError' => true, 'targetClass' => Apoderados::className(), 'targetAttribute' => ['idApo' => 'idApo']],
//            [['idCurso'], 'exist', 'skipOnError' => true, 'targetClass' => Cursos::className(), 'targetAttribute' => ['idCurso' => 'idCurso']],
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
            'idCurso' => 'Curso',
            'activo' => 'Activo',
			'retirado' => 'Retirado',
            'idpivote' => 'Idpivote',
        ];
    }

}

