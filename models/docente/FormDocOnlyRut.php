<?php
/**
 * Created by PhpStorm.
 * User: chelo
 * Date: 18-07-2021
 * Time: 11:40
 */
namespace app\models\docente;

use yii\base\Model;

/**
 * Class FormDocOnlyRut
 * @package app\models\docente
 */
class FormDocOnlyRut extends Model
{
    public $rutdocente;

    public function rules()
    {
        return [
            [['rutdocente'],'required','message'=>'Campo requerido'],
        ];
    }
}