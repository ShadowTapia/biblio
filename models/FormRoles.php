<?php

/**
 * @author Marcelo
 * @copyright 2019
 */

namespace app\models;
use yii\base\Model;

/**
 * Class FormRoles
 * @package app\models
 */
class FormRoles extends Model
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

