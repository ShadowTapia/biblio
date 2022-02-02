<?php
/**
 * Created by PhpStorm.
 * User: chelo
 * Date: 19-07-2021
 * Time: 12:18
 */
namespace app\models;

use yii\base\Model;

/**
 * Class FormUserOnlyRut
 * @package app\models
 */
class FormUserOnlyRut extends Model
{
    public $UserRut;

    public function rules()
    {
        return [
            [['UserRut'],'required','message'=>'Campo requerido'],
        ];
    }
}