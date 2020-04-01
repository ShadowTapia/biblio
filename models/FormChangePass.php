<?php

/**
 * @author Marcelo
 * @copyright 2019
 */

namespace app\models;
use yii\base\model;

class FormChangePass extends model{
    public $password;
    public $password_new;
    public $password_repeat;
    
    public function rules()
    {
        return [
            [['password','password_new','password_repeat'],'required','message'=>'Campo requerido'],
            [['password','password_new','password_repeat'],'match','pattern'=>"/^.{8,16}$/",'message'=>utf8_encode('M�nimo 6 y m�ximo 16 caracteres')],
            ['password_repeat','compare','compareAttribute'=>'password_new','message'=>utf8_encode('Las contrase�as no coinciden')]
        ];
    }
}