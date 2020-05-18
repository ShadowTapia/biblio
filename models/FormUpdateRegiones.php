<?php

/**
 * @author Marcelo
 * @copyright 2019
 */

namespace app\models;
use yii\base\model;

class FormUpdateRegiones extends model
{
    public $region;
    public $orden;
    
    public function rules()
    {
        return [
            [['region'],'required','message' => 'Campo requerido'],
            [['orden'],'integer','message'=>'Sólo se aceptan valores númericos'],
            //validamos que los valores no sean mayores de a 127
            [['orden'],'compare','compareValue' => 128, 'operator' => '<','message'=>'No se aceptan valores mayores a 127'],
            //Validamos que los valores sean mayores de 0
            [['orden'],'compare','compareValue' => 0, 'operator' => '>','message' => 'No se aceptan valores menores que 0'],
            [['region'],'match','pattern' => "/^([a-zA-Zñ-Ñ\u00f1\u00d1\u00E0-\u00FC])\w+/", 'message' => 'Sólo se aceptan letras'],
        ];
    }
}
