<?php

/**
 * @author Marcelo
 * @copyright 2019
 */

namespace app\models;

use yii\base\model;

class FormRegister extends model{
    public $UserRut;
    public $UserName;
    public $UserLastName;
    public $UserMail;
    public $idroles;
    public $activate;
    public $UserPass;
    public $UserPass_repeat;
    
    public function rules()
    {
        return [
            [['UserRut','UserName','UserMail','idroles','UserPass','UserPass_repeat'],'required','message'=>'Campo requerido'],
            ['UserRut','validateRut'], 
            ['UserName','match','pattern'=>"/^.{3,45}$/",'message'=>'Mínimo 3 y máximo 50 caracteres'],
            ['UserName','match','pattern' => "/^([a-zA-Zñ-Ñ\u00f1\u00d1\u00E0-\u00FC])\w+/",'message'=>'Sólo se aceptan letras'],
            ['UserLastName','match','pattern' => "/^([a-zA-Zñ-Ñ\u00f1\u00d1\u00E0-\u00FC])\w+/",'message'=>'Sólo se aceptan letras'],
            ['UserMail','match','pattern'=>"/^.{5,80}$/",'message'=>'Mínimo 5 y máximo 80 caracteres'],
            ['UserMail','email','message'=>'Formato no válido'],
            ['activate','safe'],
            ['UserMail','email_existe'],
            ['UserPass','match','pattern'=>"/^.{7,16}$/",'message'=>'Mínimo 7 y máximo 16 caracteres'],
            ['UserPass_repeat','compare','compareAttribute'=>'UserPass','message'=>'Las contraseñas no coinciden'],
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
    
    public function validateRut($attribute,$params)
    {
        $rut=$this->UserRut;//recibo el rut
        $rut_sin_puntos=str_replace('.',"",$rut);//le quito los puntos
        $data = explode('-',$rut_sin_puntos);//separo rut de dv
        $verificador=strtolower($data[1]);//asigno valor de dv
        $numeros=strrev($data[0]);//separo rut de dv
        $count=strlen($numeros);//asigno la longitud del string en este caso 8
        $count=$count-1;//resto 1 al contador para comenzar el ciclo ya que las posiciones empiezan en 0
        $suma=0;
        $recorreString=0;
        $multiplo=2;
        for($i=0;$i<=$count;$i++)//inicio mi ciclo hasta la posici�n 7
        {
            $resultadoM=$numeros[$recorreString]*$multiplo;//recorro String y multiplico
            $suma=$suma+$resultadoM;//se suma resultado de multiplicaci�n por ciclo
            if($multiplo==7)
            {
                $multiplo=1;
            }
            $multiplo++;
            $recorreString++;
        }
        $resto=$suma%11;
        $dv=11-$resto;
        if($dv==11)
        {
            $dv=0;
        }
        if($dv==10)
        {
            $dv='k';
        }
        if($verificador!=$dv)
        {
            $this->addError($attribute,"Rut Inválido");
        }
    }   
    
}