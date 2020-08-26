<?php
/**
 * Created by PhpStorm.
 * User: chelo
 * Date: 28-07-2020
 * Time: 11:17
 */
namespace app\models\editorial;

use yii\base\model;

class FormUpdateEditorial extends model
{
    public $ideditorial;
    public $nombre;
    public $direccion;
    public $telefono;
    public $mail;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'],'required','message'=>'Campo requerido'],
            [['nombre', 'direccion'], 'string', 'max' => 80],
            [['telefono'], 'string', 'max' => 45],
            [['mail'],'email','message'=>'Formato no valido'],
            [['mail'], 'string', 'max' => 150],
        ];
    }
}