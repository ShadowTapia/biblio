<?php
/**
 * Created by PhpStorm.
 * User: chelo
 * Date: 21-07-2020
 * Time: 22:05
 */

namespace  app\models\autor;

use yii\base\Model;

/**
 * Class FormUpdateAutor
 * @package app\models\autor
 */
class FormUpdateAutor extends Model
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
            [['nombre','nacionalidad'],'match','pattern'=> '/^[a-zA-ZÀ-ÖØ-öø-ÿ]+\.?(( |\-)[a-zA-ZÀ-ÖØ-öø-ÿ]+\.?)*$/','message'=>'Solo se aceptan caracteres alfabéticos'],
            [['nombre'], 'string', 'max' => 60, 'message'=>'No se aceptan mas de 60 caracteres'],
            [['nacionalidad'], 'string', 'max' => 45,'message'=>'No se aceptan mas de 45 caracteres'],
        ];
    }
}