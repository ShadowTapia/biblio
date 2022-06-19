<?php

/**
 * @author Marcelo
 * @copyright 2020
 */

namespace app\models\cursos;
use yii\base\Model;

/**
 * Class FormCreaCursos
 * @package app\models\cursos
 */
class FormCreaCursos extends Model
{
    public $Nombre;
    public $Orden;
    public $visible;
    
    
    public function rules()
    {
        return [
            [['Nombre'],'required','message'=>'Campo requerido'],
            [['Orden'], 'integer','message' => 'Sólo se aceptan valores númericos'],
            [['Orden'],'compare','compareValue' => '255','operator' => '<', 'message' => 'No se aceptan valores mayores a 255'],
            [['Orden'],'compare','compareValue' => '1','operator' => '>','message' => 'No se aceptan valores menores a 1'],
            [['visible'],'safe'],
        ];
    }
    
    
    
}
