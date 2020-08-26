<?php

namespace app\models\alumnos;

/**
 * This is the model class for table "alumnos".
 *
 * @property int|null $rutalumno
 * @property string|null $digrut
 * @property string $nombrealu
 * @property string $paternoalu
 * @property string $maternoalu
 * @property string|null $calle
 * @property string|null $nro
 * @property string|null $depto
 * @property string|null $block
 * @property string|null $villa
 * @property int|null $codRegion
 * @property int|null $idProvincia
 * @property int|null $codComuna
 * @property string|null $fono
 * @property string|null $sexo
 * @property string|null $email
 * @property string|null $fechanac
 * @property string|null $nacionalidad
 * @property string|null $fecharet
 * @property string|null $fechaing
 * @property string $idalumno
 *
 * @property Comunas $codComuna0
 * @property Provincias $idProvincia0
 * @property Regiones $codRegion0
 * @property Apoderados $apoderados
 * @property Pivot[] $pivots
 */

use app\models\apoderados\Apoderados;
use app\models\Comunas;
use app\models\pivot\Pivot;
use app\models\Provincias;
use app\models\Regiones;

class Alumnos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'alumnos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rutalumno', 'codRegion', 'idProvincia', 'codComuna'], 'integer'],
            [['nombrealu', 'paternoalu', 'maternoalu', 'idalumno'], 'required'],
            [['sexo', 'nacionalidad'], 'string'],
            [['fechanac', 'fecharet', 'fechaing'], 'safe'],
            [['digrut'], 'string', 'max' => 1],
            [['nombrealu'], 'string', 'max' => 40],
            [['paternoalu', 'maternoalu'], 'string', 'max' => 20],
            [['calle', 'villa'], 'string', 'max' => 50],
            [['nro', 'depto'], 'string', 'max' => 8],
            [['block'], 'string', 'max' => 10],
            [['fono'], 'string', 'max' => 25],
            [['email'], 'string', 'max' => 150],
            [['idalumno'], 'string', 'max' => 15],
            [['idalumno'], 'unique'],
            [['codComuna'], 'exist', 'skipOnError' => true, 'targetClass' => Comunas::className(), 'targetAttribute' => ['codComuna' => 'codComuna']],
            [['idProvincia'], 'exist', 'skipOnError' => true, 'targetClass' => Provincias::className(), 'targetAttribute' => ['idProvincia' => 'idProvincia']],
            [['codRegion'], 'exist', 'skipOnError' => true, 'targetClass' => Regiones::className(), 'targetAttribute' => ['codRegion' => 'codRegion']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'rutalumno' => 'Rutalumno',
            'digrut' => 'Digrut',
            'nombrealu' => 'Nombrealu',
            'paternoalu' => 'Paternoalu',
            'maternoalu' => 'Maternoalu',
            'calle' => 'Calle',
            'nro' => 'Nro',
            'depto' => 'Depto',
            'block' => 'Block',
            'villa' => 'Villa',
            'codRegion' => 'Cod Region',
            'idProvincia' => 'Id Provincia',
            'codComuna' => 'Cod Comuna',
            'fono' => 'Fono',
            'sexo' => 'Sexo',
            'email' => 'Email',
            'fechanac' => 'Fechanac',
            'nacionalidad' => 'Nacionalidad',
            'fecharet' => 'Fecharet',
            'fechaing' => 'Fechaing',
            'idalumno' => 'Idalumno',
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCodComuna0()
    {
        return $this->hasOne(Comunas::className(), ['codComuna' => 'codComuna']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProvincia0()
    {
        return $this->hasOne(Provincias::className(), ['idProvincia' => 'idProvincia']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCodRegion0()
    {
        return $this->hasOne(Regiones::className(), ['codRegion' => 'codRegion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApoderados()
    {
        return $this->hasMany(Apoderados::className(), ['rutalumno' => 'rutalumno']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPivots()
    {
        return $this->hasMany(Pivot::className(), ['idalumno' => 'idalumno']);
    }

    /**
     * @param $idCurso
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getAlumnosporcurso($idCurso)
    {
        $comboAlumnos = self::find()
                        ->select(['alumnos.rutalumno as id','alumnos.nombrealu as name'])
                        ->joinWith(['pivots pi'])
                        ->where(['pi.idCurso'=>$idCurso])
                        ->andWhere(['pi.idano'=>\Yii::$app->session->get('anoActivo')])
                        ->asArray()
                        ->all();
        return $comboAlumnos;
    }

    /**
     * @return null
     */
    public static function dropdownalus()
    {
        static $dropdown;
        if($dropdown===null)
        {
            $models=static::find()->all();
            foreach ($models as $model)
            {
                $dropdown[$model->idalumno]=$model->paternoalu . ' ' . $model->maternoalu .','. $model->nombrealu;
            }
        }
        return $dropdown;
    }

}
