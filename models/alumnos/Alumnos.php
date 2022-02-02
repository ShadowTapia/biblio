<?php

namespace app\models\alumnos;

use app\models\apoderados\Apoderados;
use app\models\Comunas;
use app\models\Provincias;
use app\models\Regiones;
use app\models\Users;
use app\models\pivot\Pivot;
use yii\db\ActiveRecord;


/**
 * This is the model class for table "alumnos".
 *
 * @property int|null $rutalumno
 * @property string|null $digrut
 * @property string|null $sexo
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
 * @property string|null $email
 * @property string|null $fono
 * @property string|null $fechanac
 * @property string|null $nacionalidad
 * @property string|null $fechaing
 * @property string|null $fecharet
 * @property string|null $sangre
 * @property string|null $enfermedades
 * @property string|null $alergias
 * @property string|null $medicamentos
 * @property string $idalumno
 *
 * @property Comunas $codComuna0
 * @property Provincias $idProvincia0
 * @property Regiones $codRegion0
 * @property Users $rutalumno0
 * @property Apoderados $apoderados
 * @property Pivot[] $pivots
 */
class Alumnos extends ActiveRecord
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
            [['sexo', 'nacionalidad'], 'string'],
            [['nombrealu', 'paternoalu', 'maternoalu', 'idalumno'], 'required'],
            [['fechanac', 'fechaing', 'fecharet'], 'safe'],
            [['digrut'], 'string', 'max' => 1],
            [['nombrealu', 'alergias'], 'string', 'max' => 50],
            [['paternoalu', 'maternoalu', 'sangre'], 'string', 'max' => 20],
            [['calle', 'medicamentos'], 'string', 'max' => 80],
            [['nro', 'depto'], 'string', 'max' => 8],
            [['block'], 'string', 'max' => 5],
            [['villa', 'fono'], 'string', 'max' => 25],
            [['email', 'enfermedades'], 'string', 'max' => 150],
            [['idalumno'], 'string', 'max' => 15],
            [['idalumno'], 'unique'],
            [['codComuna'], 'exist', 'skipOnError' => true, 'targetClass' => Comunas::class, 'targetAttribute' => ['codComuna' => 'codComuna']],
            [['idProvincia'], 'exist', 'skipOnError' => true, 'targetClass' => Provincias::class, 'targetAttribute' => ['idProvincia' => 'idProvincia']],
            [['codRegion'], 'exist', 'skipOnError' => true, 'targetClass' => Regiones::class, 'targetAttribute' => ['codRegion' => 'codRegion']],
            [['rutalumno'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['rutalumno' => 'UserRut']],
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
            'sexo' => 'Sexo',
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
            'email' => 'Email',
            'fono' => 'Fono',
            'fechanac' => 'Fechanac',
            'nacionalidad' => 'Nacionalidad',
            'fechaing' => 'Fechaing',
            'fecharet' => 'Fecharet',
            'sangre' => 'Sangre',
            'enfermedades' => 'Enfermedades',
            'alergias' => 'Alergias',
            'medicamentos' => 'Medicamentos',
            'idalumno' => 'Idalumno',
        ];
    }

    /**
     * Gets query for [[CodComuna0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCodComuna0()
    {
        return $this->hasOne(Comunas::class, ['codComuna' => 'codComuna']);
    }

    /**
     * Gets query for [[IdProvincia0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdProvincia0()
    {
        return $this->hasOne(Provincias::class, ['idProvincia' => 'idProvincia']);
    }

    /**
     * Gets query for [[CodRegion0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCodRegion0()
    {
        return $this->hasOne(Regiones::class, ['codRegion' => 'codRegion']);
    }

    /**
     * Gets query for [[Rutalumno0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRutalumno0()
    {
        return $this->hasOne(Users::class, ['UserRut' => 'rutalumno']);
    }

    /**
     * Gets query for [[Apoderados]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getApoderados()
    {
        return $this->hasMany(Apoderados::class, ['rutalumno' => 'rutalumno']);
    }

    /**
     * Gets query for [[Pivots]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPivots()
    {
        return $this->hasMany(Pivot::class, ['idalumno' => 'idalumno']);
    }

    /**
     * @param $idCurso
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getAlumnosporcurso($idCurso)
    {
        $comboAlumnos = self::find()
            ->select(['rutalumno as id','nombrealu as name'])
            ->joinWith(['pivots pi'])
            ->where(['pi.idCurso'=> $idCurso])
            ->andWhere(['pi.retirado' => '0'])
            ->andWhere(['pi.idano'=>\Yii::$app->session->get('anoActivo')])
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
