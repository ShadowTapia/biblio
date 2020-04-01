<?php

/**
 * @author Marcelo
 * @copyright 2020
 */

namespace app\models\cursos;
use yii\base\model;

class FormCreaCursos extends model
{
    public $Nombre;
    public $Orden;
    public $visible;
    
    
    public function rules()
    {
        return [
            [['Nombre'],'required','message'=>'Campo requerido'],
            [['Orden'], 'integer','message' => utf8_encode('S�lo se aceptan valores n�mericos')],
            [['Orden'],'compare','compareValue' => '255','operator' => '<', 'message' => 'No se aceptan valores mayores a 255'],
            [['Orden'],'compare','compareValue' => '1','operator' => '>','message' => 'No se aceptan valores menores a 1'],
            [['visible'],'safe'],
        ];
    }
    
    
    
}
