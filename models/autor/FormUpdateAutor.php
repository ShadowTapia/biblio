<?php
/**
 * Created by PhpStorm.
 * User: chelo
 * Date: 21-07-2020
 * Time: 22:05
 */

namespace  app\models\autor;

use yii\base\model;

class FormUpdateAutor extends model
{
    public $idautor;
    public $nombre;
    public $nacionalidad;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'],'required','message'=> 'Campo requerido'],
            [['nombre','nacionalidad'],'match','pattern'=> '/^[a-zA-ZáéíóúÁÉÍÓÚ.,\s]+$/','message'=>'Solo se aceptan caracteres alfabéticos'],
            [['nombre'], 'string', 'max' => 60, 'message'=>'No se aceptan mas de 60 caracteres'],
            [['nacionalidad'], 'string', 'max' => 45,'message'=>'No se aceptan mas de 45 caracteres'],
        ];
    }
}