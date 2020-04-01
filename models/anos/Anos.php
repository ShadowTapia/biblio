<?php

namespace app\models\anos;

/**
 * This is the model class for table "anos".
 *
 * @property int $idano
 * @property string|null $nombreano
 * @property string|null $activo
 */
class Anos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'anos';
    }    

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idano' => 'Idano',
            'nombreano' => 'Nombreano',
            'activo' => 'Activo',
        ];
    }
    
    public function getAnoActivo()
    {
        return $this->hasOne(Anos::className(),['activo'=>'1']);        
    }
       
}
