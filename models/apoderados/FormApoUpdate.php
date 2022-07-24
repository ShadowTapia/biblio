<?php
/**
 * Created by PhpStorm.
 * User: chelo
 * Date: 15-02-2022
 * Time: 19:27
 */

namespace app\models\Apoderados;
use yii\base\Model;

/**
 * Class FormApoUpdate
 * @package app\models\Apoderados
 */
class FormApoUpdate extends Model
{
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

    public function rules()
    {
        return [
            [['codRegion', 'idProvincia', 'codComuna'], 'integer','message'=>'Debe ser un entero'],
            [['nombreapo', 'apepat', 'apemat'], 'required','message'=>'Campo requerido'],
            [['relacion'], 'string'],
            [['apoderado'], 'string', 'max' => 1],
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

}