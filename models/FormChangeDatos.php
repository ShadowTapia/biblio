<?php

/**
 * @author Marcelo
 * @copyright 2019
 */

namespace app\models;
use yii\base\model;

class FormChangeDatos extends model{
    public $UserMail;
    
    public function rules()
    {
        return [
            ['UserMail','required','message'=>'Campo requerido'],
            ['UserMail','match','pattern'=>"/^.{5,80}$/",'message'=>utf8_encode('M�nimo 5 y m�ximo 80 caracteres')],
            ['UserMail','email','message'=>utf8_encode('Formato no v�lido')],
            ['UserMail','email_existe'],
        ];
    }
    
    public function email_existe($attribute,$params)
    {
        //Buscar e-mail en la tabla
        $table=Users::find()->where("UserMail=:UserMail",[":UserMail"=>$this->UserMail]);
        //Si el email existe mostrar el error
        if($table->count()==1)
        {
            $this->addError($attribute,"El email seleccionado existe");
        }
    }
}