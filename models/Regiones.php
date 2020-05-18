<?php

namespace app\models;

/**
 * This is the model class for table "regiones".
 *
 * @property int $codRegion
 * @property string $region
 * @property int|null $orden
 *
 * @property Provincias[] $provincias
 */
class Regiones extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'regiones';
    }

    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'codRegion' => 'Cod Region',
            'region' => 'Region',
            'orden' => 'Orden',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvincias()
    {
        return $this->hasMany(Provincias::className(), ['codRegion' => 'codRegion']);
    }  
        
    public static function getListRegiones()
    {
        return self::find()->select(['region','codRegion'])->indexBy('codRegion')->orderBy('orden')->column();
    }
}
