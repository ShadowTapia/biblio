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
        ];
    }
}
