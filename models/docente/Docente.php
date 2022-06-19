<?php

namespace app\models\docente;

use yii\db\ActiveRecord;
use app\models\Comunas;
use app\models\Provincias;
use app\models\Regiones;
/**
 * This is the model class for table "docente".
 *
 * @property int $rutdocente
 * @property string|null $digito
 * @property string $nombres
 * @property string $paterno
 * @property string $materno
 * @property string|null $calle
 * @property string|null $numero
 * @property string|null $depto
 * @property string|null $block
 * @property string|null $villa
 * @property int|null $codRegion
 * @property int|null $idProvincia
 * @property int|null $codComuna
 * @property string|null $telefono
 * @property string|null $email
 *
 * @property Comunas $comunas
 * @property Provincias $provincias
 * @property Regiones $regiones
 */
class Docente extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'docente';
    }

    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'rutdocente' => 'Rutdocente',
            'digito' => 'Digito',
            'nombres' => 'Nombres',
            'paterno' => 'Paterno',
            'materno' => 'Materno',
            'calle' => 'Calle',
            'numero' => 'Numero',
            'depto' => 'Depto',
            'block' => 'Block',
            'villa' => 'Villa',
            'codRegion' => 'Cod Region',
            'idProvincia' => 'Id Provincia',
            'codComuna' => 'Cod Comuna',
            'telefono' => 'Telefono',
            'email' => 'Email',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComunas()
    {
        return $this->hasOne(Comunas::class, ['codComuna' => 'codComuna']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvincias()
    {
        return $this->hasOne(Provincias::class, ['idProvincia' => 'idProvincia']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegiones()
    {
        return $this->hasOne(Regiones::class, ['codRegion' => 'codRegion']);
    }

    /**
     * @return array
     */
    public static function getListdocentes()
    {
        return self::find()->select(['concat(paterno,SPACE(1),materno,SPACE(1),nombres) as name','rutdocente as rutdocente'])->indexBy('rutdocente')->orderBy('paterno')->addOrderBy('materno')->column();
    }
}
