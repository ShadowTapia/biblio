<?php

namespace app\models;

use yii\db\ActiveRecord;
/**
 * This is the model class for table "roles".
 *
 * @property int $idroles
 * @property string|null $nombre
 * @property string|null $descripcion
 *
 * @property User[] $users
 * 
 */
class Roles extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'roles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'string', 'max' => 30],
            [['descripcion'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idroles' => 'Idroles',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::class, ['Idroles' => 'idroles']);
    }

    
}
