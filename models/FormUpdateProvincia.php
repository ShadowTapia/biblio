<?php

/**
 * @author Marcelo
 * @copyright 2019
 */

namespace app\models;
use Yii\base\model;


class FormUpdateProvincia extends model
{
    public $Provincia;
    public $codRegion;
    
    public function rules()
    {
        return [
            [['Provincia','codRegion'],'required','message'=>'Campo requerido'],
            [['Provincia'], 'string', 'max' => 45],
            [['Provincia'],'match','pattern'=>"/^([a-zA-Z�-�\u00f1\u00d1\u00E0-\u00FC])\w+/",'message'=>utf8_encode('S�lo se aceptan letras')],
        ];
    }   
}