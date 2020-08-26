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
            [['nombre','descripcion'],'string'],
        ];
    }
}

