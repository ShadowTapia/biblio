<?php

namespace app\controllers;

use app\models\Comunas;
use app\models\FormProvincias;
use app\models\FormUpdateProvincia;
use app\models\Provincias;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Class ProvinciasController
 * @package app\controllers
 */
class ProvinciasController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([ //find() retorna un objeto de tipo query
            //codRegion0 el nombre de la propiedad q apunta al modelo Region
            'query' => Provincias::find()->joinWith(['codRegion0 cod'])->orderBy('cod.orden'),
        ]);

        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    /**
     * @return array|string|Response
     * @throws \Exception
     * @throws \Throwable
     */
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

                        \Yii::$app->session->setFlash('success', 'Se ha creado correctamente la Provincia.-');
                    } else {
                        \Yii::$app->session->setFlash('error', utf8_encode('Ocurrió un error, al ingresar la Provincia.-'));
                    }
                    return $this->redirect('index');
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    throw $e;
                } catch (\Throwable $e) {
                    $transaction->rollBack();
                    throw $e;
                }
            } else {
                $model->getErrors();
            }
        }
        return $this->renderAjax('create', ["model" => $model]);
    }

    /**
     * @param $id
     * @return Response
     * @throws \Exception
     */
    public function actionDelete($id)
    {
        if ((int)$id) {
            //recordar hacer la verificaci�n en la tabla comunas
            $table2 = Comunas::find()->where("idProvincia=:idProvincia", [":idProvincia" =>
            $id]);
            //Si existen comunas asociadas a la provincia, lanzamos la advertencia
            if ($table2->count() > 0) {
                \Yii::$app->session->setFlash('error', 'Ocurrio un error, existen Comunas asociadas a la Provincia.-');
                return $this->redirect('index');
            } else {
                $table = new Provincias;
                $transaction = $table::getDb()->beginTransaction();
                try {
                    if ($table::deleteAll("idProvincia=:idProvincia", [":idProvincia" => $id])) {
                        $transaction->commit();
                        \Yii::$app->session->setFlash('success', 'Se ha borrado correctamente la Provincia.-');
                    } else {
                        $transaction->rollBack();
                        \Yii::$app->session->setFlash('error', 'Ocurrio un error, no se borro la Provincia.-');
                    }
                    return $this->redirect('index');
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    throw $e;
                }
            }
        } else {
            return $this->redirect('index');
        }
    }

    /**
     * @param $id
     * @return array|string
     * @throws \Exception
     * @throws \Throwable
     */
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
                            \Yii::$app->session->setFlash('success', 'La Provincia fue actualizada correctamente.-');
                        } else {
                            $transaction->rollBack();
                            \Yii::$app->session->setFlash('error', 'La Provincia no pudo ser actualizada.');
                        }
                        return $this->redirect('index');
                    }
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    throw $e;
                } catch (\Throwable $e) {
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

        return $this->renderAjax('update', ["model" => $model]);
    }
}
