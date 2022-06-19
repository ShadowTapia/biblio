<?php

/**
 * @author Marcelo
 * @copyright 2019
 */
namespace app\models;
use yii\base\Model;

/**
 * Class FormUpdateUser
 * @package app\models
 */
class FormUpdateUser extends Model
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
            [['UserName','UserLastName'],'match','pattern' => "/^([a-zA-Zñ-Ñ\x{00f1}\x{00d1}\x{00E0}-\x{00FC}])\w+/",'message'=>'Sólo se aceptan letras'],
            ['UserMail','match','pattern'=>"/^.{5,80}$/",'message'=>'Mínimo 5 y máximo 80 caracteres'],
            ['UserMail','email','message'=>'Formato no válido'],
            ['activate','safe'],      
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


