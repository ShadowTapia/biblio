<?php

/**
 * @author Marcelo
 * @copyright 2019
 */

namespace app\models;
use Yii\base\Model;

/**
 * Class FormUpdateProvincia
 * @package app\models
 */
class FormUpdateProvincia extends Model
{
    public $Provincia;
    public $codRegion;
    
    public function rules()
    {
        return [
            [['Provincia','codRegion'],'required','message'=>'Campo requerido'],
            [['Provincia'], 'string', 'max' => 45],
            [['Provincia'],'match','pattern'=>"/^([a-zA-Zñ-Ñ\u00f1\u00d1\u00E0-\u00FC])\w+/",'message'=>'Sólo se aceptan letras'],
        ];
    }   
}