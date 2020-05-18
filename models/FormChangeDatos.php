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
            ['UserMail','match','pattern'=>"/^.{5,80}$/",'message'=>'Mínimo 5 y máximo 80 caracteres'],
            ['UserMail','email','message'=>'Formato no válido'],
            ['UserMail','email_existe'],
        ];
    }

    /**
     * @param $attribute
     * @param $params
     * Verifica que no exista el mail
     */
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