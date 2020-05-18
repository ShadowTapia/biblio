<?php

/**
 * @author Marcelo
 * @copyright 2019
 */
namespace app\models;
use yii\base\model;

class FormUpdateUser extends model
{
    public $UserName;
    public $UserLastName;
    public $UserMail;
    public $idroles;
    public $activate;
    
    public function rules()
    {
        return [
            [['UserName','UserLastName','idroles'],'required','message' => 'Campo requerido'],
            [['UserName','UserLastName'],'match','pattern'=>"/^.{3,45}$/",'message'=>'Mínimo 3 y máximo 50 caracteres'],
            [['UserName','UserLastName'],'match','pattern' => "/^([a-zA-Zñ-Ñ\u00f1\u00d1\u00E0-\u00FC])\w+/",'message'=>'Sólo se aceptan letras'],
            ['UserMail','match','pattern'=>"/^.{5,80}$/",'message'=>'Mínimo 5 y máximo 80 caracteres'],
            ['UserMail','email','message'=>'Formato no válido'],
            ['activate','safe'],      
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


