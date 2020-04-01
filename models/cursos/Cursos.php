<?php

namespace app\models\cursos;

/**
 * This is the model class for table "cursos".
 *
 * @property int $idCurso
 * @property string $Nombre
 * @property int|null $Orden
 * @property string|null $visible
 *
 * @property Pivot[] $pivots
 */
class Cursos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cursos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Nombre'], 'required'],
            [['Orden'], 'integer'],
            [['visible'], 'string'],
            [['Nombre'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idCurso' => 'Id Curso',
            'Nombre' => 'Nombre',
            'Orden' => 'Orden',
            'visible' => 'Visible',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPivots()
    {
        return $this->hasMany(Pivot::className(), ['idCurso' => 'idCurso']);
    }
}
