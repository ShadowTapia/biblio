<?php

/**
 * @author Marcelo
 * @copyright 2019
 */

namespace app\models;
use yii\base\Model;

/**
 * Class FormChangeDatos
 * @package app\models
 */
class FormChangeDatos extends Model
{
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
     */
    public function email_existe($attribute)
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