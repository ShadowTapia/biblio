<?php

/**
 * Created by PhpStorm.
 * User: chelo
 * Date: 07-04-2021
 * Time: 0:05
 */

namespace app\models\prestamos;

use yii\base\Model;

/**
 * Class FormIngPrestamos
 * @package app\models\prestamos
 */
class FormIngPrestamos extends Model
{
    public $idPrestamo;
    public $fechapres;
    public $fechadev;
    public $idUser;
    public $idejemplar;
    public $norden;
    public $notas;
    public $idano;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idPrestamo'], 'required'],
            [['fechapres', 'fechadev'], 'safe'],
            [['idPrestamo', 'idUser', 'idejemplar'], 'string', 'max' => 15],
            [['norden'], 'string', 'max' => 5],
            [['notas'], 'string', 'max' => 255],
            [['idano'], 'integer'],
            [['idPrestamo'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idPrestamo' => 'Id Prestamo',
            'idUser' => 'Id Usuario',
            'idejemplar' => 'Id Ejemplar',
            'norden' => 'N° orden',
            'fechapres' => 'Fecha prestamo',
            'fechadev' => 'Fecha devolución',
            'notas' => 'Notas',
            'idano' => 'Id Ano',
        ];
    }
}
