<?php
/**
 * Created by PhpStorm.
 * User: chelo
 * Date: 10-08-2021
 * Time: 0:02
 */
namespace app\models\Prestamos;

use yii\base\Model;

/**
 * Class FormUpdatePrestamo
 * @package app\models\prestamos
 */
class FormUpdatePrestamos extends Model
{
    public $idejemplar;
    public $idUser;
    public $idPrestamo;
    public $fechapres;
    public $fechadev;
    public $notas;

    public function rules()
    {
        return [
            [['idPrestamo'],'string','max'=>15],
            [['fechapres', 'fechadev'], 'safe'],
            [['fechapres', 'fechadev'], 'required', 'message' => 'Campo requerido'],
            [['fechapres','fechadev'],'date','format'=>'dd-MM-yyyy'],
            ['fechadev','comparedates'],
            [['notas'], 'string', 'max' => 255],
        ];
    }

    /**
     * @param $attribute
     */
    public function comparedates($attribute)
    {
        $datestart = strtotime($this->fechapres);
        $dateend = strtotime($this->fechadev);
        $datediff = $dateend - $datestart;
        $date_dias = round($datediff / (60 * 60 * 24));
        if($date_dias<0)
        {
            $this->addError($attribute,"Error en la fecha devolución");
        }
    }
}