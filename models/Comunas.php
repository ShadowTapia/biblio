<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "comunas".
 *
 * @property int $codComuna
 * @property string $comuna
 * @property int|null $idProvincia
 *
 * @property Provincias $provincia
 * @property Regiones $codRegion0
 */
class Comunas extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comunas';
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'codComuna' => 'Cod Comuna',
            'comuna' => 'Comuna',
            'idProvincia' => 'Id Provincia',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getProvincia()
    {        
        return $this->hasOne(Provincias::class, ['idProvincia' => 'idProvincia']);
    }
    
    public function getNombreProvincia()
    {
        return $this->provincia->Provincia;
    }
    
    public function getCodRegion0()
    {
        return $this->hasOne(Regiones::class, ['codRegion' => 'codRegion'])->via('provincia');
    }
    
    public function getNombreRegion()
    {
        return $this->codRegion0->region;
    }

    /**
     * @param $idProvincia
     * @return array|ActiveRecord[]
     */
    public static function getComunalist($idProvincia)
    {
        $subComunas = self::find()
                        ->select(['codComuna as id','Comuna as name'])
                        ->where(['idProvincia' => $idProvincia])
                        ->asArray()
                        ->all();
        return $subComunas;
    }
    
    /**
     * 
     * Se encarga de cargar los datos en los dropdown
     * 
     */
    public static function combobx()
    {
        static $dropdown;
        if($dropdown===null)
        {
            $models=static::find()->all();
            foreach($models as $model)
            {
                $dropdown[$model->codComuna]=$model->comuna;         
            }
        }
        return $dropdown;
    }
}
