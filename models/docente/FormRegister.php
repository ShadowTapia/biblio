<?php

/**
 * @author Marcelo
 * @copyright 2019
 */

namespace app\models\docente;

use yii\base\model;

class FormRegister extends model{
    public $rutdocente;
    public $digito;
    public $nombres;
    public $paterno;
    public $materno;
    public $calle;
    public $numero;
    public $depto;
    public $block;
    public $villa;
    public $codRegion;
    public $idProvincia;
    public $codComuna;
    public $telefono;
    public $email;
    
    public function rules()
    {
        return [
            [['rutdocente','nombres','paterno','materno','email','codRegion','idProvincia','codComuna'],'required','message'=>'Campo requerido'],
            ['rutdocente','validarRut'],
            [['digito'], 'string', 'max' => 1],
            ['nombres','match','pattern'=>"/^.{3,25}$/",'message'=>utf8_encode('M�nimo 3 y m�ximo 25 caracteres')],
            [['paterno','materno'],'match','pattern'=>"/^.{3,20}$/",'message'=>utf8_encode('M�nimo 3 y m�ximo 20 caracteres')],
            [['nombres','paterno','materno'],'match','pattern' => "/^([a-z�A-Z�-�\u00f1\u00d1\u00E0-\u00FC])\w+/",'message'=>utf8_encode('S�lo se aceptan letras')],
            [['calle','telefono','numero','depto','block','villa','region','provincia','comuna'],'safe'],
            [['calle'], 'string', 'max' => 30],
            [['numero', 'depto'], 'string', 'max' => 8],
            [['block'], 'string', 'max' => 5],
            ['email','match','pattern'=>"/^.{5,150}$/",'message'=>utf8_encode('M�nimo 5 y m�ximo 150 caracteres')],
            ['email','email','message'=>utf8_encode('Formato no v�lido')],
            ['email','email_existe'],            
        ];
    }
    
    public function email_existe($attribute,$params)
    {
        //Buscar e-mail en la tabla
        $table=Docente::find()->where("email=:email",[":email"=>$this->email]);
        //Si el email existe mostrar el error
        if($table->count()==1)
        {
            $this->addError($attribute,"El email ingresado existe");
        }
    }
    
    public function validarRut($attribute,$params)
    {
        $rut=$this->rutdocente;//recibo el rut
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
            $this->addError($attribute,utf8_encode("Rut Inv�lido"));
        }
    }
}
