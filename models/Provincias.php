<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
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
class Provincias extends ActiveRecord
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
     * @return ActiveQuery
     */
    public function getComunas()
    {
        return $this->hasMany(Comunas::class, ['idProvincia' => 'idProvincia']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCodRegion0()
    {
        return $this->hasOne(Regiones::class, ['codRegion' => 'codRegion']);
    }
    
    public function getRegionNombre()
    {
        return $this->codRegion0->region;
    }

    /**
     * @param $codRegion
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getProvinciaList($codRegion)
    {
        $subProvincias = self::find()
                        ->select(['idProvincia as id','Provincia as name'])
                        ->where(['codRegion' => $codRegion])
                        ->asArray()
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
