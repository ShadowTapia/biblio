<?php

namespace app\models;

use yii\base\Model;

class FormResetPass extends Model
{
    public $UserMail;
    public $UserPass;
    public $password_repeat;
    public $verification_code;
    public $recover;

    public function rules()
    {
        return [
            [['UserMail', 'UserPass', 'password_repeat', 'verification_code', 'recover'], 'required', 'message' => 'Campo requerido'],
            ['UserMail', 'match', 'pattern' => "/^.{5,80}$/", 'message' => 'Mínimo 5 y máximo 80 caracteres'],
            ['UserMail', 'email', 'message' => 'Formato no válido'],
            ['UserPass', 'match', 'pattern' => "/^.{8,16}$/", 'message' => 'Mínimo 6 y máximo 16 caracteres'],
            ['password_repeat', 'compare', 'compareAttribute' => 'UserPass', 'message' => 'Las contraseñas no coinciden'],
        ];
    }
}
