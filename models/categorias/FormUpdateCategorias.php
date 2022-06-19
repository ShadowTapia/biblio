<?php
/**
 * Created by PhpStorm.
 * User: chelo
 * Date: 03-08-2020
 * Time: 23:20
 */
namespace app\models\categorias;

use yii\base\Model;

/**
 * Class FormUpdateCategorias
 * @package app\models\categorias
 */
class FormUpdateCategorias extends Model
{
    public $idcategoria;
    public $categoria;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['categoria'],'required','message'=> 'Campo requerido'],
            [['categoria'], 'string', 'max' => 30,'message' => 'No se aceptan más de 30 caracteres'],
            [['categoria'],'match','pattern'=> '/^[a-zA-ZáéíóúÁÉÍÓÚ.,\s]+$/','message'=>'Solo se aceptan caracteres alfabéticos'],
        ];
    }
}