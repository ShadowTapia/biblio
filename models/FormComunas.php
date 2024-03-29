<?php

/**
 * @author Marcelo
 * @copyright 2019
 */

namespace app\models;
use Yii\base\Model;

/**
 * Class FormComunas
 * @package app\models
 */
class FormComunas extends Model
{
    public $codComuna;
    public $comuna;
    public $idProvincia;
    public $codRegion;
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codComuna','comuna'], 'required','message' => 'Campo requerido'],
            [['codComuna'],'compare','compareValue' => 32767, 'operator' => '<','message'=>'No se aceptan valores mayores a 32767'],
            [['codComuna'],'compare','compareValue' => 0,'operator' => '>','message' => 'No se aceptan valores menores de 0'],
            [['idProvincia'], 'integer'],
            [['codComuna'],'comunas_existe'],
            [['comuna'], 'string', 'max' => 25],
            [['comuna'],'match','pattern'=>"/^([a-zA-Zñ-Ñ\u00f1\u00d1\u00E0-\u00FC])\w+/",'message'=>'Sólo se aceptan letras'],
            [['idProvincia'], 'exist', 'skipOnError' => true, 'targetClass' => Provincias::class, 'targetAttribute' => ['idProvincia' => 'idProvincia']],
        ];
    }

    /**
     * @param $attribute
     */
    public function comunas_existe($attribute)
    {
        //Buscar el c�digo de la comuna
        $table = Comunas::find()->where("codComuna=:codComuna",[":codComuna" => $this->codComuna]);
        //Si existe el c�digo mostrar el error
        if ($table->count()==1){
            $this->addError($attribute,"El código ya esta en uso.-");
        }
    }
}