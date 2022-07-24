<?php

namespace app\models\numejem;

use yii\db\ActiveRecord;
use app\models\libros\Libros;
use yii\db\ActiveQuery;
/**
 * This is the model class for table "numejem".
 *
 * @property string $idLibros
 * @property int|null $numlibros
 * @property int|null $numdispos
 *
 * @property Libros $idLibros0
 */
class Numejem extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'numejem';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idLibros'], 'required'],
            [['numlibros', 'numdispos'], 'integer'],
            [['idLibros'], 'string', 'max' => 15],
            [['idLibros'], 'unique'],
            [['idLibros'], 'exist', 'skipOnError' => true, 'targetClass' => Libros::class, 'targetAttribute' => ['idLibros' => 'idLibros']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idLibros' => 'Id Libros',
            'numlibros' => 'Numlibros',
            'numdispos' => 'Numdispos',
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
}
