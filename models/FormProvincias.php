<?php

/**
 * @author Marcelo
 * @copyright 2019
 */

namespace app\models;
use Yii\base\model;

class FormProvincias extends model
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
            [['idProvincia','codRegion'], 'integer','message'=>utf8_encode('S�lo se aceptan valores n�mericos')],
            [['idProvincia'],'compare','compareValue'=> 32767, 'operator' => '<','message'=>'No se aceptan valores mayores a 32767'],
            [['idProvincia'],'compare','compareValue'=>0,'operator' => '>','message' => 'No se aceptan valores menores de 0'],
            [['idProvincia'],'provincia_existe'],
            [['Provincia'], 'string', 'max' => 45],
            [['Provincia'],'match','pattern'=>"/^([a-zA-Z�-�\u00f1\u00d1\u00E0-\u00FC])\w+/",'message'=>utf8_encode('S�lo se aceptan letras')],            
            [['codRegion'], 'exist', 'skipOnError' => true, 'targetClass' => Regiones::className(), 'targetAttribute' => ['codRegion' => 'codRegion']],
        ];
    }
    
    public function provincia_existe($attribute,$params)
    {
        //Buscar el c�digo de la provincia
        $table = Provincias::find()->where("idProvincia=:idProvincia", [":idProvincia" => $this->idProvincia]);
        //Si existe el c�digo mostrar el error
        if($table->count()==1){
            $this->addError($attribute,utf8_encode("El c�digo ya esta en uso.-"));
        }
    }
}