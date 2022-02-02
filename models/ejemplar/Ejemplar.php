<?php

namespace app\models\ejemplar;

use yii\db\ActiveRecord;
use app\models\libros\Libros;
use app\models\prestamos\Prestamos;
use app\models\historico\Historico;

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
 * @property Libros[] $idLibros0
 * @property Historico[] $historicos
 * @property Prestamos $prestamos
 */
class Ejemplar extends ActiveRecord
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
        return $this->hasOne(Libros::class, ['idLibros' => 'idLibros']);
    }

    /**
     * Gets query for [[Historicos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHistoricos()
    {
        return $this->hasMany(Historico::class, ['idejemplar' => 'idejemplar']);
    }

    /**
     * Gets query for [[Prestamos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPrestamos()
    {
        return $this->hasMany(Prestamos::class, ['idejemplar' => 'idejemplar']);
    }

    /**
     * Este metodo devuelve la lista de ejemplares asociados a un id de libro
     *
     * @param $idLibro
     * @return null
     */
    public static function getEjemplareslist($idLibro)
    {
        static $dropdown;
        if($dropdown===null)
        {
            $models = static::find()
                        ->select(['idejemplar as idejemplar','norden as norden'])
                        ->where(['idLibros' => $idLibro])
                        ->all();
            foreach ($models as $model)
            {
                $dropdown[$model->idejemplar]=$model->norden;
            }
        }
        return $dropdown;
    }
}
