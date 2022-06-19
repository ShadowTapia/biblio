<?php

/**
 * @author Marcelo
 * @copyright 2019
 */

namespace app\models\anos;
use yii\base\Model;

/**
 * Class FormUpdateAnos
 * @package app\models\anos
 */
class FormUpdateAnos extends Model
{
    public $nombreano;
    public $activo;
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombreano'], 'safe'],
            [['nombreano'],'required','message' => 'Campo requerido'],
            [['nombreano'],'integer','message' => 'Sólo se aceptan valores númericos'],
            [['nombreano'],'compare','compareValue' => '2100','operator' => '<', 'message' => 'No se aceptan valores mayores a 2.100'],
            [['nombreano'],'compare','compareValue' => '2000','operator' => '>', 'message' => 'No se aceptan valores menores de 2.000'],
            [['activo'], 'safe'],
        ];
    }
}