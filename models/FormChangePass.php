<?php

/**
 * @author Marcelo
 * @copyright 2019
 */

namespace app\models;
use yii\base\Model;

/**
 * Class FormChangePass
 * @package app\models
 */
class FormChangePass extends Model
{
    public $password;
    public $password_new;
    public $password_repeat;
    
    public function rules()
    {
        return [
            [['password','password_new','password_repeat'],'required','message'=>'Campo requerido'],
            [['password','password_new','password_repeat'],'match','pattern'=>"/^.{8,16}$/",'message'=>'Mínimo 6 y máximo 16 caracteres'],
            ['password_repeat','compare','compareAttribute'=>'password_new','message'=>'Las contraseñas no coinciden'],
        ];
    }
}