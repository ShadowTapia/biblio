<?php

namespace app\controllers;

use app\models\reserva\Reserva;
use Yii;
use yii\data\ActiveDataProvider;
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
        $dataProvider = new ActiveDataProvider([
            'query' => Reserva::find()->orderBy('fechaR  DESC'),'pagination' => ['pagesize' => 50,],
        ]);
        return $this->render('index',['dataProvider' => $dataProvider]);
    }

    /**
     * @return int|string
     */
    protected function verificarLibrosbyUser()
    {
        $bookResrv = Reserva::find()
            ->where(['idUser' => Yii::$app->user->identity->getId()])
            ->andWhere(['estado' => '0'])
            ->count();
        return $bookResrv;
    }

    /**
     * @param $book
     * @return bool
     */
    protected function verificarReserva($id)
    {
        $bookReserva = Reserva::find()
            ->where(['idLibros' => $id])
            ->andWhere(['idUser' => Yii::$app->user->identity->getId()])
            ->andWhere(['estado' => '0'])
            ->count();

        return $bookReserva;
    }

    /**
     * @return string
     */
    public function actionConsulreserva()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Reserva::find()->where(['idUser' => Yii::$app->user->identity->getId()])->orderBy('fechaR'),'pagination' => ['pagesize' => 50,],
        ]);

        return $this->render('consulreserva',['dataProvider' => $dataProvider]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws \Exception
     * @throws \Throwable
     */
    public function actionDelete($id)
    {
        $table = new Reserva();
        $transaction = $table->getDb()->beginTransaction();
        try
        {
            if ($table->deleteAll("idreserva=:idreserva",[":idreserva"=>$id]))
            {
                $transaction->commit();
                \Yii::$app->session->setFlash('success', 'Se ha borrado correctamente la Reserva ');
            }else {
                $transaction->rollBack();
                \Yii::$app->session->setFlash('error', 'Ocurrió un error, no se borro la Reserva.-');
            }
        }
        catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
        catch (\Throwable $e)
        {
            $transaction->rollBack();
            throw $e;
        }
        return $this->redirect(['index']);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws \Exception
     * @throws \Throwable
     */
    public function actionReservar($id)
    {
        if (($model = Libros::findOne($id)) !== null)
        {
            //Verificar que este usuario solo tenga dos libros en reserva
            if($this->verificarLibrosbyUser()>1)
            {
                Yii::$app->session->setFlash('error', 'Sólo se permiten reservar dos libros.-');
            }else{
                // preguntamos si el usuario ya a reservado este ejemplar
                if($this->verificarReserva($id)>0)
                {
                    Yii::$app->session->setFlash('error', 'Este libro ya ha sido reservado por el Usuario.-');
                } else {
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
            }

        }
        return $this->redirect(['libros/consulta']);
    }

}
