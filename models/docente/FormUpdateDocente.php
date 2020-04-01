<?php

/**
 * @author Marcelo
 * @copyright 2019
 */

namespace app\models\docente;
use yii\base\model;

class FormUpdateDocente extends model
{
    public $nombres;
    public $paterno;
    public $materno;
    public $calle;
    public $numero;
    public $depto;
    public $block;
    public $villa;
    public $codRegion;
    public $idProvincia;
    public $codComuna;
    public $telefono;
    public $email;
    
    public function rules()
    {
        return [
            [['nombres','paterno','materno',],'required','message'=>'Campo requerido'],
            ['nombres','match','pattern'=>"/^.{3,25}$/",'message'=>utf8_encode('M�nimo 3 y m�ximo 25 caracteres')],
            [['paterno','materno'],'match','pattern'=>"/^.{3,20}$/",'message'=>utf8_encode('M�nimo 3 y m�ximo 20 caracteres')],
            [['nombres','paterno','materno'],'match','pattern' => "/^([a-zA-Z�-�\u00f1\u00d1\u00E0-\u00FC])\w+/",'message'=>utf8_encode('S�lo se aceptan letras')],
            [['calle','telefono','numero','depto','block','villa','codRegion','idProvincia','codComuna'],'safe'],
            ['email','match','pattern'=>"/^.{5,80}$/",'message'=>utf8_encode('M�nimo 5 y m�ximo 80 caracteres')],
            ['email','email','message'=>utf8_encode('Formato no v�lido')],
        ];
    }
}