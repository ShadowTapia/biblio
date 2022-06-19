<?php

/**
 * @author Marcelo
 * @copyright 2019
 */

namespace app\models\docente;
use yii\base\Model;

/**
 * Class FormUpdateDocente
 * @package app\models\docente
 */
class FormUpdateDocente extends Model
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
            ['nombres','match','pattern'=>"/^.{3,25}$/",'message'=>'Mínimo 3 y máximo 25 caracteres'],
            [['paterno','materno'],'match','pattern'=>"/^.{3,20}$/",'message'=>'Mínimo 3 y máximo 20 caracteres'],
            [['nombres','paterno','materno'],'match','pattern' => "/^([a-zA-Zñ-Ñ\x{00f1}\x{00d1}\x{00E0}-\x{00FC}])\w+/",'message'=>'Sólo se aceptan letras'],
            [['calle','telefono','numero','depto','block','villa','codRegion','idProvincia','codComuna'],'safe'],
            ['email','match','pattern'=>"/^.{5,80}$/",'message'=>'Mínimo 5 y máximo 80 caracteres'],
            ['email','email','message'=>'Formato no válido'],
        ];
    }
}