<?php

/**
 * @author Marcelo
 * @copyright 2019
 */

namespace app\models;
use Yii\base\Model;

/**
 * Class FormProvincias
 * @package app\models
 */
class FormProvincias extends Model
{
    public $idProvincia;
    public $Provincia;
    public $codRegion;
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idProvincia','Provincia','codRegion'],'required','message'=>'Campo requerido'],            
            [['idProvincia','codRegion'], 'integer','message'=>'Sólo se aceptan valores númericos'],
            [['idProvincia'],'compare','compareValue'=> 32767, 'operator' => '<','message'=>'No se aceptan valores mayores a 32767'],
            [['idProvincia'],'compare','compareValue'=>0,'operator' => '>','message' => 'No se aceptan valores menores de 0'],
            [['idProvincia'],'provincia_existe'],
            [['Provincia'], 'string', 'max' => 45],
            [['Provincia'],'match','pattern'=>"/^([a-zA-Zñ-Ñ\u00f1\u00d1\u00E0-\u00FC])\w+/",'message'=>'Sólo se aceptan letras'],
            [['codRegion'], 'exist', 'skipOnError' => true, 'targetClass' => Regiones::class, 'targetAttribute' => ['codRegion' => 'codRegion']],
        ];
    }

    /**
     * @param $attribute
     */
    public function provincia_existe($attribute)
    {
        //Buscar el c�digo de la provincia
        $table = Provincias::find()->where("idProvincia=:idProvincia", [":idProvincia" => $this->idProvincia]);
        //Si existe el c�digo mostrar el error
        if($table->count()==1){
            $this->addError($attribute,"El código ya esta en uso.-");
        }
    }
}