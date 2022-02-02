<?php
/**
 * Created by PhpStorm.
 * User: chelo
 * Date: 15-06-2021
 * Time: 22:39
 */
namespace app\models\Alumnos;

use yii\base\Model;

/**
 * Class FormAluOnlyRut
 * @package app\models\Alumnos
 */
class FormAluOnlyRut extends Model
{
    public $rutalumno;

    public function rules()
    {
        return [
            [['rutalumno'],'required','message'=>'Campo requerido'],
        ];
    }
}