<?php

namespace app\models\categorias;

use yii\db\ActiveRecord;
use app\models\libros\Libros;

/**
 * This is the model class for table "categorias".
 *
 * @property int $idcategoria
 * @property string|null $categoria
 *
 * @property Libros $libros
 */
class Categorias extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categorias';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['categoria'],'required','message'=> 'Campo requerido'],
            [['categoria'], 'string', 'max' => 30,'message' => 'No se aceptan más de 30 caracteres'],
            [['categoria'],'match','pattern'=> '/^[a-zA-ZáéíóúÁÉÍÓÚ.,\s]+$/','message'=>'Solo se aceptan caracteres alfabéticos'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idcategoria' => 'Id. Categoria',
            'categoria' => 'Categoria',
        ];
    }

    /**
     * Gets query for [[Libros]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLibros()
    {
        return $this->hasMany(Libros::class, ['idcategoria' => 'idcategoria']);
    }

    /**
     * @return array
     */
    public static function getListCategorias()
    {
        return self::find()->select(['categoria','idcategoria'])->orderBy('categoria')->column();
    }

    public static function comboBox()
    {
        static $dropdown;
        if($dropdown===null)
        {
            $models = static::find()->orderBy('categoria')->all();
            foreach ($models as $model)
            {
                $dropdown[$model->idcategoria] = $model->categoria;

            }
        }
        return $dropdown;
    }
}
