<?php

namespace app\controllers;

use app\models\Comunas;
use app\models\FormProvincias;
use app\models\FormUpdateProvincia;
use app\models\Provincias;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;

class ProvinciasController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([ //find() retorna un objeto de tipo query
            //codRegion0 el nombre de la propiedad q apunta al modelo Region
        'query' => Provincias::find()->joinWith(['codRegion0 cod'])->orderBy('cod.orden'), ]);

        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionCreate()
    {
        $model = new FormProvincias;

        //validaci�n mediante ajax
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $table = new Provincias;

                $transaction = $table::getDb()->beginTransaction();
                try {
                    $table->idProvincia = $model->idProvincia;
                    $table->Provincia = mb_strtoupper($model->Provincia);
                    $table->codRegion = $model->codRegion;

                    if ($table->insert()) {
                        $transaction->commit();
                        //limpiamos los controles del formulario
                        $model->idProvincia = null;
                        $model->Provincia = null;
                        \raoul2000\widget\pnotify\PNotify::widget([
		                  'pluginOptions' => [
			                 'title' => 'Provincia',
			                 'text' => 'Se ha creado correctamente la <b>Provincia</b>.-.',
                             'type' => 'info',
		                      ]
	                       ]);

                        //Yii::$app->session->setFlash('success', utf8_encode('Se ha agregado una nueva Provincia.-'));
                        //Redireccionamos a la p�gina origen
                        echo "<meta http-equiv='refresh' content='3; " . Url::toRoute("provincias/index") .
                            "'>";
                    } else {
                        \raoul2000\widget\pnotify\PNotify::widget([
		                  'pluginOptions' => [
			                 'title' => 'Error',
			                 'text' => 'Ocurrio un error, al ingresar la <b>Provincia</b>.-.',
                             'type' => 'error',
		                      ]
	                       ]);

                        //Yii::$app->session->setFlash('error', utf8_encode('Ocurrio un error, al ingresar la Provincia.-'));
                    }
                }
                catch (\Exception $e) {
                    $transaction->rollBack();
                    throw $e;
                }
            } else {
                $model->getErrors();
            }
        }
        return $this->render('create', ["model" => $model]);
    }

    /**
     * 
     * Se encarga de eliminar una provincia
     * 
     **/ 
    public function actionDelete($id)
    {
        if ((int)$id) {
            //recordar hacer la verificaci�n en la tabla comunas
            $table2 = Comunas::find()->where("idProvincia=:idProvincia", [":idProvincia" =>
                $id]);
            //Si existen comunas asociadas a la provincia, lanzamos la advertencia
            if ($table2->count() > 0) {
                Yii::$app->session->setFlash('error', utf8_encode('Ocurrio un error, existen Comunas asociadas a la Provincia.-'));
                echo "<meta http-equiv='refresh' content='3; " . Url::toRoute("provincias/index") .
                    "'>";
            } else {
                $table = new Provincias;
                $transaction = $table::getDb()->beginTransaction();
                try {
                    if ($table::deleteAll("idProvincia=:idProvincia", [":idProvincia" => $id])) {
                        $transaction->commit();
                        Yii::$app->session->setFlash('success', utf8_encode('Se ha borrado correctamente la Provincia.-'));
                        echo "<meta http-equiv='refresh' content='3; " . Url::toRoute("provincias/index") .
                            "'>";
                    } else {
                        $transaction->rollBack();
                        Yii::$app->session->setFlash('error', utf8_encode('Ocurrio un error, no se borro la Provincia.-'));
                        echo "<meta http-equiv='refresh' content='3; " . Url::toRoute("provincias/index") .
                            "'>";

                    }
                }
                catch (\Exception $e) {
                    $transaction->rollBack();
                    throw $e;
                }
            }
        } else {
            echo "<meta http-equiv='refresh' content='3; " . Url::toRoute("provincias/index") .
                "'>";
        }
    }

    /**
     * 
     * Actualiza una provincia
     * 
     **/ 
    public function actionUpdate($id)
    {
        $model = new FormUpdateProvincia;

        $table = new Provincias;

        //validaci�n mediante ajax
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $transaction = $table::getDb()->beginTransaction();
                try {
                    $table = Provincias::findOne(["idProvincia" => $id]);
                    if ($table) {
                        $table->Provincia = mb_strtoupper($model->Provincia);
                        if ($table->update()) {
                            $transaction->commit();
                            \raoul2000\widget\pnotify\PNotify::widget([
                                'pluginOptions' => [
                                'title' => 'Provincias',
                                'text' => 'La Provincia fue actualizada correctamente.',
                                'type' => 'info',
		                      ]]);
  
                            //Yii::$app->session->setFlash('success', utf8_encode('La Provincia fue cambiada exitosamente.-'));
                            echo "<meta http-equiv='refresh' content='3; " . Url::toRoute("provincias/index") .
                                "'>";
                        } else {
                            $transaction->rollBack();
                            \raoul2000\widget\pnotify\PNotify::widget([
                                'pluginOptions' => [
                                'title' => 'Error',
                                'text' => 'La Provincia no pudo ser actualizada.',
                                'type' => 'error',
		                      ]]);
                            //Yii::$app->session->setFlash('error', utf8_encode('La Provincia no fue cambiada.-'));
                            echo "<meta http-equiv='refresh' content='3; " . Url::toRoute("provincias/index") .
                                "'>";
                        }
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

            } else {
                $model->getErrors();
            }

        } else {
            $table = Provincias::findOne(["idProvincia" => $id]);
            if ($table) {
                $model->Provincia = $table->Provincia;
                $model->codRegion = $table->codRegion;
            }
        }

        return $this->render('update', ["model" => $model]);
    }

}
