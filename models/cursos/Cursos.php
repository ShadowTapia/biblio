<?php

namespace app\models\cursos;

use app\models\pivot\Pivot;
use yii\db\ActiveRecord;

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
class Cursos extends ActiveRecord
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

    /**
     * @return array
     */
    public static function getListCursos()
    {
        return self::find()->select(['Nombre','idCurso'])->where(['visible' => '1'])->indexBy('idCurso')->orderBy('Orden')->column();
    }
}
