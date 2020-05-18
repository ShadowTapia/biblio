<?php

/**
 * @author Marcelo
 * @copyright 2020
 */

namespace app\models\pivot;

use yii\base\model;


class FormSelectPivot extends model
{
    
    public $idApo;
    public $idano;
    public $idCurso;
    public $motivo;
    public $idpivote;
    public $idalumno;
    
        
    public function rules()
    {
       return [
            [['idApo', 'idano', 'idCurso'], 'integer'],
            [['idalumno', 'idpivote'], 'string', 'max' => 15],
            [['motivo'], 'string', 'max' => 50],
            [['idpivote'], 'unique'],
            //[['idalumno'], 'exist', 'skipOnError' => true, 'targetClass' => Alumnos::className(), 'targetAttribute' => ['idalumno' => 'idalumno']],
//            [['idano'], 'exist', 'skipOnError' => true, 'targetClass' => Anos::className(), 'targetAttribute' => ['idano' => 'idano']],
//            [['idApo'], 'exist', 'skipOnError' => true, 'targetClass' => Apoderados::className(), 'targetAttribute' => ['idApo' => 'idApo']],
//            [['idCurso'], 'exist', 'skipOnError' => true, 'targetClass' => Cursos::className(), 'targetAttribute' => ['idCurso' => 'idCurso']],
       ];
    }
    
    
}

