<?php

namespace app\controllers;

use Yii;
use app\models\temas\Temas;
use app\models\temas\FormUpdateTemas;
use app\models\temas\TemasSearch;
use app\models\libros\Libros;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * TemasController implements the CRUD actions for Temas model.
 */
class TemasController extends Controller
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
     * Lists all Temas models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TemasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Temas model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
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
        $model = new Temas();

        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $table = new Temas();
                $transaction = $table->getDb()->beginTransaction();
                try {
                    $table->nombre = mb_strtoupper($model->nombre);
                    $table->codtemas = $model->codtemas;
                    if ($table->insert()) {
                        $transaction->commit();
                        \Yii::$app->session->setFlash('success', 'Se ha ingresado correctamente el Tema.-');
                    } else {
                        $transaction->rollBack();
                        \Yii::$app->session->setFlash('error', 'Ocurrió un error, al ingresar el Tema.-');
                    }
                    return $this->redirect(['temas/index']);
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
        $model = new FormUpdateTemas();
        $table = new Temas();

        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $transaction = $table->getDb()->beginTransaction();
                try {
                    $table = Temas::findOne(['idtemas' => $id]);
                    if ($table) {
                        $table->nombre = mb_strtoupper($model->nombre);
                        $table->codtemas = $model->codtemas;
                        if ($table->update()) {
                            $transaction->commit();
                            \Yii::$app->session->setFlash('success', 'El Tema se ha actualizado exitosamente.-');
                        } else {
                            $transaction->rollBack();
                            \Yii::$app->session->setFlash('error', 'No se ha actualizado el Tema.-');
                        }
                        return $this->redirect(['temas/index']);
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
            $table = Temas::findOne(['idtemas' => $id]);
            if ($table) {
                $model->idtemas = $table->idtemas;
                $model->nombre = $table->nombre;
                $model->codtemas = $table->codtemas;
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
        $tableLibros = Libros::find()->where("idtemas=:idtemas", [":idtemas" => $id]);
        if ($tableLibros->count() > 0) {
            \Yii::$app->session->setFlash('error', 'Ocurrió un error, existen Temas  asociadas a este Libro.-');
            return $this->redirect(['index']);
        } else {
            $table = new Temas();

            $transaction = $table->getDb()->beginTransaction();
            try {
                if ($table->deleteAll("idtemas=:idtemas", [":idtemas" => $id])) {
                    $transaction->commit();
                    \Yii::$app->session->setFlash('success', 'Se ha borrado correctamente el tema ' . $table->nombre);
                } else {
                    $transaction->rollBack();
                    \Yii::$app->session->setFlash('error', 'Ocurrió un error, no se borro el Tema.-');
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
     * Finds the Temas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Temas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Temas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
