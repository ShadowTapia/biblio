<?php

namespace app\models\ejemplar;

use Yii;
use app\models\libros\Libros;

/**
 * This is the model class for table "ejemplar".
 *
 * @property string $idejemplar
 * @property string|null $norden
 * @property string|null $edicion
 * @property string|null $ubicacion
 * @property string $idLibros
 * @property string|null $fechain
 * @property string|null $fechaout
 * @property int|null $disponible
 *
 * @property Libros $idLibros0
 * @property Historico[] $historicos
 * @property Prestamos[] $prestamos
 */
class Ejemplar extends \yii\db\ActiveRecord
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
            [['fechain', 'fechaout'], 'safe'],
            [['disponible'], 'integer'],
            [['idejemplar', 'idLibros'], 'string', 'max' => 15],
            [['norden'], 'string', 'max' => 5],
            [['edicion', 'ubicacion'], 'string', 'max' => 20],
            //[['idLibros'], 'exist', 'skipOnError' => true, 'targetClass' => Libros::className(), 'targetAttribute' => ['idLibros' => 'idLibros']],
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
            'fechain' => 'F. Ingreso',
            'fechaout' => 'F. Salida',
            'disponible' => 'Disponible',
        ];
    }

    /**
     * Gets query for [[IdLibros0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdLibros0()
    {
        return $this->hasOne(Libros::className(), ['idLibros' => 'idLibros']);
    }

    /**
     * Gets query for [[Historicos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHistoricos()
    {
        return $this->hasMany(Historico::className(), ['idejemplar' => 'idejemplar']);
    }

    /**
     * Gets query for [[Prestamos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPrestamos()
    {
        return $this->hasMany(Prestamos::className(), ['idejemplar' => 'idejemplar']);
    }
}
