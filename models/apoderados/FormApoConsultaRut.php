<?php
/**
 * Created by PhpStorm.
 * User: chelo
 * Date: 27-09-2020
 * Time: 11:20
 */
namespace app\models\Apoderados;
use yii\base\Model;

/**
 * Class FormApoConsultaRut
 * @package app\models\Apoderados
 */
class FormApoConsultaRut extends Model
{
    public $rutapo;

    public function rules()
    {
        return [
            [['rutapo'],'required','message'=>'Campo requerido'],
            ['rutapo','validarRut'],
        ];
    }

    /**
     * @param $attribute
     */
    public function validarRut($attribute)
    {
        $rut=$this->rutapo;//recibo el rut
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