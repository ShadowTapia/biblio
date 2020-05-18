<?php

/**
 * @author Marcelo
 * @copyright 2019
 */

namespace app\models;
use yii\base\model;

class FormRoles extends model
{
    public $nombre;
    public $descripcion;
    
    public function rules()
    {
        return [
            [['nombre'],'required','message' => 'Campo requerido'],
            [['nombre','descripcion'],'match','pattern' => "/^([a-zA-Zñ-Ñ\u00f1\u00d1\u00E0-\u00FC])\w+/", 'message' => 'Sólo se aceptan letras'],
        ];
    }
}

