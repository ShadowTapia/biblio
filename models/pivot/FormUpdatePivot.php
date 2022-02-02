<?php
/**
 * Created by PhpStorm.
 * User: chelo
 * Date: 28-06-2021
 * Time: 14:46
 */
namespace app\models\pivot;

use yii\base\Model;

/**
 * Class FormUpdatePivot
 * @package app\models\pivot
 */
class FormUpdatePivot extends Model
{
    public $retirado;

    public function rules()
    {
        return [
            [['retirado'],'string','max'=>1],
            ['retirado','safe'],
        ];
    }
}