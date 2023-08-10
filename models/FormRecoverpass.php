<?php

namespace app\models;

use yii\base\Model;

class FormRecoverpass extends Model
{
    public $UserMail;

    public function rules()
    {
        return [
            ['UserMail', 'required', 'message' => 'Campo requerido'],
            ['UserMail', 'match', 'pattern' => '/^.{5,80}$/', 'message' => 'Mínimo 5 y máximo 80 caracteres'],
            ['UserMail', 'email', 'message' => 'Formato no válido'],
        ];
    }
}
