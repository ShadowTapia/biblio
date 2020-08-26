<?php

namespace app\models\numejem;

use Yii;

/**
 * This is the model class for table "numejem".
 *
 * @property string $idLibros
 * @property int|null $numlibros
 * @property int|null $numdispos
 *
 * @property Libros $idLibros0
 */
class Numejem extends \yii\db\ActiveRecord
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
            [['idLibros'], 'exist', 'skipOnError' => true, 'targetClass' => Libros::className(), 'targetAttribute' => ['idLibros' => 'idLibros']],
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
     * @return \yii\db\ActiveQuery
     */
    public function getIdLibros0()
    {
        return $this->hasOne(Libros::className(), ['idLibros' => 'idLibros']);
    }
}
