<?php

namespace app\controllers;

use Yii;
use app\models\autor\Autor;
use app\models\autor\FormUpdateAutor;
use app\models\libros\Libros;
use app\models\autor\AutorSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\widgets\ActiveForm;
use yii\web\Response;

/**
 * AutorController implements the CRUD actions for Autor model.
 */
class AutorController extends Controller
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

    /**
     * Lists all Autor models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AutorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Autor model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * @return array|string
     * @throws \Exception
     * @throws \Throwable
     */
    public function actionCreate()
    {
        $model = new Autor();

        //Validación mediante ajax
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $table = new Autor();
                $transaction = $table->getDb()->beginTransaction();
                try {
                    $table->nombre = mb_strtoupper($model->nombre);
                    $table->nacionalidad = $model->nacionalidad;
                    if ($table->insert()) {
                        $transaction->commit();
                        \Yii::$app->session->setFlash('success', 'Se ha ingresado correctamente el Autor.-');
                    } else {
                        $transaction->rollBack();
                        \Yii::$app->session->setFlash('error', 'Ocurrio un error, al ingresar el Autor.-');
                    }
                    return $this->redirect(['autor/index']);
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

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return array|string
     * @throws \Exception
     * @throws \Throwable
     */
    public function actionUpdate($id)
    {
        $model = new FormUpdateAutor();
        $table = new Autor();

        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $transaction = $table->getDb()->beginTransaction();
                try {
                    $table = Autor::findOne(["idautor" => $id]);
                    if ($table) {
                        $table->nombre = mb_strtoupper($model->nombre);
                        $table->nacionalidad = $model->nacionalidad;
                        if ($table->update()) {
                            $transaction->commit();
                            \Yii::$app->session->setFlash('success', 'El Autor se ha actualizado exitosamente.-');
                        } else {
                            $transaction->rollBack();
                            \Yii::$app->session->setFlash('error', 'No se ha actualizado el Autor.-');
                        }
                        return $this->redirect(['autor/index']);
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
            $table = Autor::findOne(["idautor" => $id]);
            if ($table) {
                $model->idautor = $table->idautor;
                $model->nombre = $table->nombre;
                $model->nacionalidad = $table->nacionalidad;
            }
        }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return Response
     * @throws \Exception
     * @throws \Throwable
     */
    public function actionDelete($id)
    {

        $tableLibro = Libros::find()->where("idautor=:idautor", [":idautor" => $id]);
        if ($tableLibro->count() > 0) {
            \Yii::$app->session->setFlash('error', 'Ocurrió un error, existen Libros asociadas a este Autor.-');
            return $this->redirect(['index']);
        } else {
            $table = new Autor();
            $transaction = $table->getDb()->beginTransaction();
            try {
                if ($table->deleteAll("idautor=:idautor", [":idautor" => $id])) {
                    $transaction->commit();
                    \Yii::$app->session->setFlash('success', 'Se ha borrado correctamente el Autor ' . $table->nombre);
                } else {
                    $transaction->rollBack();
                    \Yii::$app->session->setFlash('error', 'Ocurrió un error, no se borro el Autor.-');
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            } catch (\Throwable $e) {
                $transaction->rollBack();
                throw $e;
            }
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the Autor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Autor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Autor::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
