<?php

namespace app\controllers;

use Yii;
use app\models\categorias\Categorias;
use app\models\categorias\CategoriasSearch;
use app\models\categorias\FormUpdateCategorias;
use app\models\libros\Libros;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * CategoriasController implements the CRUD actions for Categorias model.
 */
class CategoriasController extends Controller
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
     * Lists all Categorias models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategoriasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Categorias model.
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
        $model = new Categorias();

        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $table = new Categorias();
                $transaction = $table->getDb()->beginTransaction();
                try {
                    $table->categoria = mb_strtoupper($model->categoria);
                    if ($table->insert()) {
                        $transaction->commit();
                        \Yii::$app->session->setFlash('success', 'Se ha ingresado correctamente la Categoría.-');
                    } else {
                        $transaction->rollBack();
                        \Yii::$app->session->setFlash('error', 'Ocurrió un error, al ingresar la Categoría.-');
                    }
                    return $this->redirect(['categorias/index']);
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
            //return $this->redirect(['view', 'id' => $model->idcategoria]);
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
        $model = new FormUpdateCategorias();
        $table = new Categorias();

        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $transaction = $table->getDb()->beginTransaction();
                try {
                    $table = Categorias::findOne(['idcategoria' => $id]);
                    if ($table) {
                        $table->categoria = mb_strtoupper($model->categoria);
                        if ($table->update()) {
                            $transaction->commit();
                            \Yii::$app->session->setFlash('success', 'La Categoría se ha actualizado exitosamente.-');
                        } else {
                            $transaction->rollBack();
                            \Yii::$app->session->setFlash('error', 'No se ha actualizado la Categoría.-');
                        }
                        return $this->redirect(['categorias/index']);
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
            $table = Categorias::findOne(["idcategoria" => $id]);
            if ($table) {
                $model->categoria = $table->categoria;
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
        //Se debe hacer la busqueda de categorías por libro
        $tableLibros = Libros::find()->where("idcategoria=:idcategoria", [":idcategoria" => $id]);
        if ($tableLibros->count() > 0) {
            \Yii::$app->session->setFlash('error', 'Ocurrió un error, esta categoría esta asociada al menos a un Libro.-');
            return $this->redirect(['index']);
        } else {
            $table = new Categorias();

            $transaction = $table->getDb()->beginTransaction();
            try {
                if ($table->deleteAll("idcategoria=:idcategoria", [":idcategoria" => $id])) {
                    $transaction->commit();
                    \Yii::$app->session->setFlash('success', 'Se ha borrado correctamente la Categoría ' . $table->categoria);
                } else {
                    $transaction->rollBack();
                    \Yii::$app->session->setFlash('error', 'Ocurrió un error, no se borro la Categoría.-');
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
     * Finds the Categorias model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Categorias the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Categorias::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
