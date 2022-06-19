<?php
/**
 * Created by PhpStorm.
 * User: chelo
 * Date: 29-07-2020
 * Time: 12:47
 */

namespace app\models\temas;

use yii\base\Model;

/**
 * Class FormUpdateTemas
 * @package app\models\temas
 */
class FormUpdateTemas extends Model
{
    public $idtemas;
    public $nombre;
    public $codtemas;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'codtemas'], 'required','message'=>'Campo requerido'],
            [['nombre'],'match','pattern'=> '/^[a-zA-ZáéíóúÁÉÍÓÚ.,\s]+$/','message'=>'Solo se aceptan caracteres alfabéticos'],
            [['nombre'], 'string', 'max' => 100],
            [['codtemas'],'match','pattern'=> '/^[0-9]+$/','message'=>'Solo se aceptan valores númericos'],
            [['codtemas'], 'string', 'max' => 3],
        ];
    }
}