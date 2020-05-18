<?php
/**
 * Created by PhpStorm.
 * User: chelo
 * Date: 17-05-2020
 * Time: 15:08
 */

namespace app\models\Alumnos;

use yii\base\model;

class FormAluRegister extends model
{
    public $rutalumno;
    public $digrut;
    public $sexo;
    public $nombrealu;
    public $paternoalu;
    public $maternoalu;
    public $calle;
    public $nro;
    public $depto;
    public $block;
    public $villa;
    public $codRegion;
    public $idProvincia;
    public $codComuna;
    public $email;
    public $fono;
    public $fechanac;
    public $nacionalidad;
    public $fechaing;

    public function rules()
    {
        return [
            [['rutalumno','sexo','nombrealu','paternoalu','maternoalu','fechanac'],'required','message'=>'Campo requerido'],
            ['rutalumno','validarRut'],
            [['digrut'],'string','max'=>1],
            ['nombrealu','match','pattern'=>"/^.{3,50}$/",'message'=>'Mínimo 3 y máximo 50 caracteres'],
            [['paternoalu','maternoalu'],'match','pattern'=>"/^.{3,20}$/",'message'=>'Mínimo 3 y máximo 20 caracteres'],
            [['nombrealu','paternoalu','maternoalu'],'match','pattern' => "/^([a-zA-Zñ-Ñ\u00f1\u00d1\u00E0-\u00FC])\w+/",'message'=>'Sólo se aceptan letras'],
            ['email','match','pattern'=>"/^.{5,150}$/",'message'=>'Mínimo 5 y máximo 150 caracteres'],
            ['email','email','message'=>'Formato no válido'],
            ['email','email_existe'],
        ];
    }

    /**
     * @param $attribute
     * @param $params
     * Se encarga de validar que el email exista
     */
    public function email_existe($attribute,$params)
    {
        $table = Alumnos::find()->where("email=:email",[":email"=>$this->email]);
        //Si el email existe mostrar el error
        if($table->count()==1)
        {
            $this->addError($attribute,"El email ingresado existe.-");
        }
    }

    /**
     * @param $attribute
     * @param $params
     * Se encarga de validar el rut del alumno
     */
    public function validarRut($attribute,$params)
    {
        $rut=$this->rutalumno;//recibo el rut
        $rut_sin_puntos=str_replace('.',"",$rut);//le quito los puntos
        $data = explode('-',$rut_sin_puntos);//separo rut de dv
        $verificador=strtolower($data[1]);//asigno valor de dv
        $numeros=strrev($data[0]);//separo rut de dv
        $count=strlen($numeros);//asigno la longitud del string en este caso 8
        $count=$count-1;//resto 1 al contador para comenzar el ciclo ya que las posiciones empiezan en 0
        $suma=0;
        $recorreString=0;
        $multiplo=2;
        for($i=0;$i<=$count;$i++)//inicio mi ciclo hasta la posición 7
        {
             $resultadoM=$numeros[$recorreString]*$multiplo;//recorro String y multiplico
             $suma=$suma+$resultadoM;//se suma resultado de multiplicación por ciclo
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
        else
        {
            //Esta parte del código valida si existe en run en la BBDD
            $tabla = Alumnos::find()->where("rutalumno=:rutalumno",[":rutalumno"=>$data[0]]);
            if($tabla->count()==1)
            {
                $this->addError($attribute,"El Run ingresado ya existe.-");
            }
        }

    }

}