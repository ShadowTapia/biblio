<?php
/**
 * Created by PhpStorm.
 * User: chelo
 * Date: 22-06-2021
 * Time: 10:27
 */
namespace app\models\Apoderados;

use yii\base\Model;

/**
 * Class FormApoOnlyRut
 * @package app\models\Apoderados
 */
class FormApoOnlyRut extends Model
{
    public $rutapo;

    public function rules()
    {
        return [
            [['rutapo'],'required','message'=>'Campo requerido'],
        ];
    }
}