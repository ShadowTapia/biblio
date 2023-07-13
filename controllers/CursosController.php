<?php

namespace app\controllers;

use app\models\cursos\Cursos;
use app\models\cursos\FormCreaCursos;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\base\Exception;

/**
 * Class CursosController
 * @package app\controllers
 */
class CursosController extends Controller
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
        $dataProvider = new ActiveDataProvider([
            'query' => Cursos::find(),
            'pagination' => false,
        ]);
        $dataProvider->sort->defaultOrder = ['Orden' => SORT_ASC];
        return $this->render('index', compact('dataProvider'));
    }

    /**
     * @param $id
     * @return array|string
     * @throws Exception
     * @throws \Throwable
     */
    public function actionUpdatecurso($idcur)
    {
        $model = new FormCreaCursos;

        $table = new Cursos;

        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $transaction = $table->getDb()->beginTransaction();
                try {
                    $table = Cursos::findOne(["idCurso" => $idcur]);
                    if ($table) {
                        $table->Nombre = $model->Nombre;
                        $table->Orden = $model->Orden;
                        $table->visible = $model->visible;

                        if ($table->update()) {
                            $transaction->commit();
                            \Yii::$app->session->setFlash('success', 'El curso se ha actualizado exitosamente.-');
                        } else {
                            $transaction->rollBack();
                            \Yii::$app->session->setFlash('error', 'No se ha actualizado el Curso.-');
                        }
                        return $this->redirect(['cursos/index']);
                    }
                } catch (Exception $e) {
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
            $table = Cursos::findOne(["idCurso" => $idcur]);
            if ($table) {
                $model->Nombre = $table->Nombre;
                $model->Orden = $table->Orden;
                $model->visible = $table->visible;
            }
        }

        return $this->renderAjax('updatecurso', ["model" => $model]);
    }

    /**
     * 
     * Se encarga de crear los cursos
     * 
     */
    public function actionCrearcursos()
    {
        $model = new FormCreaCursos;

        //Validaci�n mediante ajax
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $table = new Cursos;

                $transaction = $table->getDb()->beginTransaction();
                try {
                    $table->Nombre = $model->Nombre;
                    $table->Orden = $model->Orden;
                    $table->visible = $model->visible;

                    if ($table->insert()) {
                        $transaction->commit();
                        $model->Nombre = null;
                        $model->Orden = null;
                        \Yii::$app->session->setFlash('info', 'Se ha creado correctamente el Curso.-');
                    } else {
                        \Yii::$app->session->setFlash('error', 'Ocurrio un error, al ingresar un Curso.-');
                    }
                    return $this->redirect(['cursos/index']);
                } catch (Exception $e) {
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

        return $this->renderAjax('crearcursos', ["model" => $model]);
    }
}
