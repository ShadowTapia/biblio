<?php

namespace app\models\vistas;

use Yii;

/**
 * This is the model class for table "viewcursos".
 *
 * @property string $idalumno
 * @property string $nombrealu
 * @property string $paternoalu
 * @property string $maternoalu
 * @property int|null $idano
 * @property int $idCurso
 */
class Viewcursos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'viewcursos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idalumno', 'nombrealu', 'paternoalu', 'maternoalu'], 'required'],
            [['idano', 'idCurso'], 'integer'],
            [['idalumno'], 'string', 'max' => 15],
            [['nombrealu'], 'string', 'max' => 50],
            [['paternoalu', 'maternoalu'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idalumno' => 'Idalumno',
            'nombrealu' => 'Nombrealu',
            'paternoalu' => 'Paternoalu',
            'maternoalu' => 'Maternoalu',
            'idano' => 'Idano',
            'idCurso' => 'Id Curso',
        ];
    }
}
