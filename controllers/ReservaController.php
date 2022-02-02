<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\libros\Libros;

/**
 * Class ReservaController
 * @package app\controllers
 */
class ReservaController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionReservar($id)
    {
        if (($model = Libros::findOne($id)) !== null) {
            if ($model->numejem->numdispos > 0) {

                $db = Yii::$app->db;

                $transaction = $db->beginTransaction();
                try
                {
                    $db->createCommand()->insert('reserva',[
                        'idUser' => Yii::$app->user->identity->getId(),
                        'idLibros' => $id,
                        'fechaR' => Yii::$app->formatter->asDate(time(),'yyyy-MM-dd'),
                    ])->execute();
                    $transaction->commit();
                    Yii::$app->session->setFlash('success','Se ha completado la reserva de este libro.-');

                }
                catch (\Exception $e) {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error','No se pudo realizar la reserva de este Libro.-');
                    throw $e;
                }
                catch (\Throwable $e)
                {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error','No se pudo realizar la reserva de este Libro.-');
                    throw $e;
                }
            } else {
                Yii::$app->session->setFlash('error', 'Libro no tiene ejemplares disponibles para Reservar.-');
            }
        }
        return $this->redirect(['libros/consulta']);
    }

}
