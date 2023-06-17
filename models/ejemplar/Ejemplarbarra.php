<?php

namespace app\models\ejemplar;

use yii\db\ActiveRecord;
use app\models\libros\Libros;
use app\models\prestamos\Prestamos;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "ejemplar".
 *
 * @property string $idejemplar
 * @property string|null $norden
 * @property string|null $edicion
 * @property string|null $ubicacion
 * @property string $idLibros 
 * @property int|null $disponible
 *
 *
 * @property Libros[] $idLibros0 
 * @property Prestamos $prestamos
 */
class Ejemplarbarra extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ejemplar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['disponible'], 'integer'],
            [['idejemplar', 'idLibros'], 'string', 'max' => 15],
            [['norden'], 'string', 'max' => 5],
            [['edicion', 'ubicacion'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idejemplar' => 'Idejemplar',
            'norden' => 'Cod. Libro',
            'edicion' => 'Edicion',
            'ubicacion' => 'Ubicacion',
            'idLibros' => 'Id Libros',
            'disponible' => 'Disponible',
        ];
    }

    /**
     * Gets query for [[IdLibros0]].
     *
     * @return ActiveQuery
     */
    public function getIdLibros0()
    {
        return $this->hasOne(Libros::class, ['idLibros' => 'idLibros']);
    }


    /**
     * Gets query for [[Prestamos]].
     *
     * @return ActiveQuery
     */
    public function getPrestamos()
    {
        return $this->hasMany(Prestamos::class, ['idejemplar' => 'idejemplar']);
    }
}
