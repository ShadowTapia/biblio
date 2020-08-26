<?php

namespace app\models\temas;

use Yii;

/**
 * This is the model class for table "temas".
 *
 * @property int $idtemas
 * @property string $nombre
 * @property string $codtemas
 *
 * @property Libros[] $libros
 */
class Temas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'temas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'codtemas'], 'required','message'=>'Campo requerido'],
            [['nombre'],'match','pattern'=> '/^[a-zA-ZáéíóúÁÉÍÓÚ.,\s]+$/','message'=>'Solo se aceptan caracteres alfabéticos'],
            [['nombre'], 'string', 'max' => 100],
            [['codtemas'],'match','pattern'=> '/^[0-9]+$/','message'=>'Solo se aceptan valores númericos'],
            [['codtemas'], 'string', 'max' => 3],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idtemas' => 'Id',
            'nombre' => 'Nombre',
            'codtemas' => 'Cod. Temas',
        ];
    }

    /**
     * Gets query for [[Libros]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLibros()
    {
        return $this->hasMany(Libros::className(), ['idtemas' => 'idtemas']);
    }

    public static function getListTemas()
    {
        return self::find()->select(['nombre','idtemas'])->orderBy('nombre')->column();
    }

    public static function combobox()
    {
        static $dropdown;
        if($dropdown===null)
        {
            $models = static::find()->orderBy('nombre')->all();
            foreach ($models as $model)
            {
                $dropdown[$model->idtemas] = $model->nombre;
            }
        }
        return $dropdown;
    }
}
