<?php

/**
 * Created by PhpStorm.
 * User: chelo
 * Date: 17-05-2020
 * Time: 15:08
 */

namespace app\models\Alumnos;

use yii\base\Model;

/**
 * Class FormAluRegister
 * @package app\models\Alumnos
 */
class FormAluRegister extends Model
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
    public $sangre;
    public $enfermedades;
    public $alergias;
    public $medicamentos;


    public function rules()
    {
        return [
            [['codRegion', 'idProvincia', 'codComuna'], 'integer'],
            [['rutalumno', 'nombrealu', 'paternoalu', 'maternoalu', 'fechanac'], 'required', 'message' => 'Campo requerido'],
            ['rutalumno', 'validarRut'],
            [['digrut', 'nacionalidad'], 'string', 'max' => 1],
            ['nombrealu', 'string', 'length' => [3, 50], 'message' => 'Mínimo 3 y máximo 50 caracteres'],
            [['fechanac', 'fechaing'], 'date', 'format' => 'dd-MM-yyyy'],
            [['fechanac', 'fechaing', 'sexo'], 'safe'],
            [['fechanac', 'fechaing'], 'default', 'value' => null],
            [['paternoalu', 'maternoalu'], 'string', 'length' => [3, 20], 'message' => 'Mínimo 3 y máximo 20 caracteres'],
            ['calle', 'string', 'max' => 80],
            [['nro', 'depto'], 'string', 'max' => 8],
            ['block', 'string', 'max' => 5],
            ['villa', 'string', 'max' => 25],
            [['fono'], 'string', 'max' => 25],
            [['sangre'], 'string', 'max' => 20],
            [['enfermedades'], 'string', 'max' => 150],
            [['alergias'], 'string', 'max' => 50],
            [['medicamentos'], 'string', 'max' => 80],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'email', 'message' => 'Formato no válido'],
            ['email', 'email_existe'],
        ];
    }

    /**
     * @param $attribute
     */
    public function email_existe($attribute)
    {
        $table = Alumnos::find()->where("email=:email", [":email" => $this->email]);
        //Si el email existe mostrar el error
        if ($table->count() == 1) {
            $this->addError($attribute, "El email ingresado ya existe.-");
        }
    }

    /**
     * @param $attribute
     */
    public function validarRut($attribute)
    {
        $rut = $this->rutalumno; //recibo el rut
        $rut_sin_puntos = str_replace('.', "", $rut); //le quito los puntos
        $data = explode('-', $rut_sin_puntos); //separo rut de dv
        $verificador = strtolower($data[1]); //asigno valor de dv
        $numeros = strrev($data[0]); //separo rut de dv
        $count = strlen($numeros); //asigno la longitud del string en este caso 8
        $count = $count - 1; //resto 1 al contador para comenzar el ciclo ya que las posiciones empiezan en 0
        $suma = 0;
        $recorreString = 0;
        $multiplo = 2;
        for ($i = 0; $i <= $count; $i++) //inicio mi ciclo hasta la posición 7
        {
            $resultadoM = $numeros[$recorreString] * $multiplo; //recorro String y multiplico
            $suma = $suma + $resultadoM; //se suma resultado de multiplicación por ciclo
            if ($multiplo == 7) {
                $multiplo = 1;
            }
            $multiplo++;
            $recorreString++;
        }
        $resto = $suma % 11;
        $dv = 11 - $resto;
        if ($dv == 11) {
            $dv = 0;
        }
        if ($dv == 10) {
            $dv = 'k';
        }
        if ($verificador != $dv) {
            $this->addError($attribute, "Rut Inválido");
        } else {
            //Esta parte del código valida si existe en run en la BBDD
            $tabla = Alumnos::find()->where("rutalumno=:rutalumno", [":rutalumno" => $data[0]]);
            if ($tabla->count() == 1) {
                $this->addError($attribute, "El Run ingresado ya existe.-");
            }
        }
    }
}
