<?php
/**
 * Created by PhpStorm.
 * User: chelo
 * Date: 31-05-2020
 * Time: 21:37
 */

namespace app\models\Apoderados;
use yii\base\Model;

/**
 * Class FormApoRegister
 * @package app\models\Apoderados
 */
class FormApoRegister extends Model
{
    public $rutapo;
    public $digrut;
    public $nombreapo;
    public $apepat;
    public $apemat;
    public $calle;
    public $nro;
    public $depto;
    public $block;
    public $villa;
    public $codRegion;
    public $idProvincia;
    public $codComuna;
    public $fono;
    public $email;
    public $celular;
    public $estudios;
    public $niveledu;
    public $profesion;
    public $trabajoplace;
    public $apoderado;
    public $relacion;
    public $rutalumno;

    public function rules()
    {
        return [
            [[ 'codRegion', 'idProvincia', 'codComuna'], 'integer','message'=>'Debe ser un entero'],
            ['rutapo','validarRut'],
            [['rutapo','nombreapo', 'apepat', 'apemat'], 'required','message'=>'Campo requerido'],
            [['relacion'], 'string'],
            [['digrut','apoderado'], 'string', 'max' => 1],
            [['nombreapo', 'villa', 'fono'], 'string', 'max' => 25],
            [['apepat', 'apemat'], 'string', 'max' => 20],
            [['calle'], 'string', 'max' => 30],
            [['nro', 'depto'], 'string', 'max' => 8],
            [['block'], 'string', 'max' => 5],
            [['email'], 'string', 'max' => 150],
            [['celular'], 'string', 'max' => 12],
            [['estudios', 'niveledu', 'profesion'], 'string', 'max' => 60],
            [['trabajoplace'], 'string', 'max' => 70],
            ['email','filter','filter'=>'trim'],
            ['email','email','message'=>'Formato no válido'],
        ];
    }

    /**
     * @param $attribute
     * @param $params
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
