<?php
/**
 * Created by PhpStorm.
 * User: chelo
 * Date: 15-04-2022
 * Time: 23:22
 */
namespace app\models\Alumnos;
use yii\base\Model;

/**
 * Class FormAluConsultaRut
 * @package app\models\Alumnos
 */
class FormAluConsultaRut extends Model
{
    public $rutalumno;

    public function rules()
    {
        return [
            [['rutalumno'],'required','message'=>'Campo requerido'],
            ['rutalumno','validarRut'],
        ];
    }

    /**
     * @param $attribute
     */
    public function validarRut($attribute)
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
    }
}