<?php

namespace app\models\autor;

use yii\db\ActiveRecord;
use app\models\libros\Libros;

/**
 * This is the model class for table "autor".
 *
 * @property string $idautor
 * @property string|null $nombre
 * @property string|null $nacionalidad
 *
 * @property Digitales[] $digitales
 * @property Libros $libros
 */
class Autor extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'autor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'],'required','message'=> 'Campo requerido'],
            [['nombre'],'match','pattern'=> '/^[a-zA-ZÀ-ÖØ-öø-ÿ]+\.?(( |\-)[a-zA-ZÀ-ÖØ-öø-ÿ]+\.?)*$/','message'=>'Solo se aceptan caracteres alfabéticos'],
            [['nombre'], 'string', 'max' => 60, 'message'=>'No se aceptan mas de 60 caracteres'],
            [['nacionalidad'],'match','pattern'=> '/^[a-zA-ZÀ-ÖØ-öø-ÿ]+\.?(( |\-)[a-zA-ZÀ-ÖØ-öø-ÿ]+\.?)*$/','message'=>'Solo se aceptan caracteres alfabéticos'],
            [['nacionalidad'], 'string', 'max' => 45,'message'=>'No se aceptan mas de 45 caracteres'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idautor' => 'Idautor',
            'nombre' => 'Nombre',
            'nacionalidad' => 'Nacionalidad',
        ];
    }

    /**
     * Gets query for [[Digitales]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDigitales()
    {
        return $this->hasMany(Digitales::className(), ['idautor' => 'idautor']);
    }

    /**
     * Gets query for [[Libros]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLibros()
    {
        return $this->hasMany(Libros::class, ['idautor' => 'idautor']);
    }

    /**
     * @return array
     */
    public static function getLibrosAutor()
    {
        return self::find()->select(['nombre','idautor'])->orderBy('nombre')->column();
    }

    public static function comboBox()
    {
        static $dropdown;
        if($dropdown===null)
        {
            $models = static::find()->orderBy('nombre')->all();
            foreach ($models as $model)
            {
                $dropdown[$model->idautor] = $model->nombre;
            }
        }
        return $dropdown;
    }
}
