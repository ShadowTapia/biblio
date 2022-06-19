<?php

/**
 * @author Marcelo
 * @copyright 2019
 */

namespace app\models;
use yii\base\Model;

/**
 * Class FormRegiones
 * @package app\models
 */
class FormRegiones extends Model
{
    public $codRegion;
    public $region;
    public $orden;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codRegion', 'region'], 'required', 'message' => 'Campo requerido'], 
            [['codRegion','orden'], 'integer', 'message' => 'Sólo se aceptan valores númericos'],
            //validamos que los valores no sean mayores a 127
            [['codRegion','orden'],'compare','compareValue' => 128,'operator'=>'<','message'=>'No se aceptan valores mayores a 127'],
            //validamos que los valores sean mayores que 0
            [['codRegion','orden'],'compare','compareValue' => 0, 'operator' => '>','message' => 'No se aceptan valores menores que 0'],
            [['codRegion'],'region_existe'],
            ///^[a-zA-Z�-�\u00f1\u00d1\u00E0-\u00FC]+(\s*[a-zA-Z�-�\u00f1\u00d1\u00E0-\u00FC]*)*[a-zA-Z�-�\u00f1\u00d1\u00E0-\u00FC]+$/im
            [['region'],'match','pattern' => "/^([a-zA-Zñ-Ñ\u00f1\u00d1\u00E0-\u00FC])\w+/", 'message' => 'Sólo se aceptan letras'],
          ];
    }

    /**
     * @param $attribute
     */
    public function region_existe($attribute)
    {
        //Buscar el código de la región
        $table = Regiones::find()->where("codRegion=:codRegion", [":codRegion" => $this->codRegion]);
        //Si existe el código mostrar el error
        if ($table->count() == 1) {
            $this->addError($attribute, "El código ya esta en uso.-");
        }
    }


}
