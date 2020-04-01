<?php

namespace app\models;

/**
 * This is the model class for table "provincias".
 *
 * @property int $idProvincia
 * @property string|null $Provincia
 * @property int|null $codRegion
 *
 * @property Comunas[] $comunas
 * @property Regiones $codRegion0
 */
class Provincias extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'provincias';
    }

    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idProvincia' => 'Id Provincia',
            'Provincia' => 'Provincia',
            'codRegion' => 'Cod Region',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComunas()
    {
        return $this->hasMany(Comunas::className(), ['idProvincia' => 'idProvincia']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCodRegion0()
    {
        return $this->hasOne(Regiones::className(), ['codRegion' => 'codRegion']);
    }
    
    public function getRegionNombre()
    {
        return $this->codRegion0->region;
    }
    
    public function getProvinciaList($codRegion)
    {
        $subProvincias = self::find()
                        ->select(['idProvincia','Provincia'])
                        ->where(['codRegion' => $codRegion])                        
                        ->all();
        
        return $subProvincias;
    }
    
    /**
     * 
     * Se encarga de poblar los combobox
     * 
     */
    public static function dropdown()
    {
        //get and cache data
        static $dropdown;
        if($dropdown===null)
        {
            //obtiene todos los datos desde la base de datos
            $models=static::find()->all();
            foreach($models as $model)
            {
                $dropdown[$model->idProvincia]=$model->Provincia;
            }
        }
        return $dropdown;
    }
}
