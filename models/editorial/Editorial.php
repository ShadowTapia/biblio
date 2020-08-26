<?php

namespace app\models\editorial;

use Yii;

/**
 * This is the model class for table "editorial".
 *
 * @property int $ideditorial
 * @property string|null $nombre
 * @property string|null $direccion
 * @property string|null $telefono
 * @property string|null $mail
 *
 * @property Digitales[] $digitales
 * @property Libros[] $libros
 */
class Editorial extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'editorial';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'],'required','message'=>'Campo requerido'],
            [['nombre', 'direccion'], 'string', 'max' => 80],
            [['telefono'], 'string', 'max' => 45],
            [['mail'],'email','message'=>'Formato no valido'],
            [['mail'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ideditorial' => 'Id',
            'nombre' => 'Nombre',
            'direccion' => 'Dirección',
            'telefono' => 'Telefono',
            'mail' => 'E-Mail',
        ];
    }

    /**
     * Gets query for [[Digitales]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDigitales()
    {
        return $this->hasMany(Digitales::className(), ['ideditorial' => 'ideditorial']);
    }

    /**
     * Gets query for [[Libros]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLibros()
    {
        return $this->hasMany(Libros::className(), ['ideditorial' => 'ideditorial']);
    }

    /**
     * @return array
     */
    public static function getListEditorial()
    {
        return self::find()->select(['nombre','ideditorial'])->orderBy('nombre')->column();
    }

    public static function comboBox()
    {
        static $dropdown;
        if($dropdown===null)
        {
            $models = static::find()->orderBy('nombre')->all();
            foreach ($models as $model)
            {
                $dropdown[$model->ideditorial] = $model->nombre;
            }
        }
        return $dropdown;
    }
}
