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
            [['UserName','UserLastName'],'match','pattern'=>"/^.{3,45}$/",'message'=>utf8_encode('M�nimo 3 y m�ximo 50 caracteres')],
            [['UserName','UserLastName'],'match','pattern' => "/^([a-zA-Z�-�\u00f1\u00d1\u00E0-\u00FC])\w+/",'message'=>utf8_encode('S�lo se aceptan letras')],
            ['UserMail','match','pattern'=>"/^.{5,80}$/",'message'=>utf8_encode('M�nimo 5 y m�ximo 80 caracteres')],
            ['UserMail','email','message'=>utf8_encode('Formato no v�lido')],
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


