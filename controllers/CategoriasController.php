<?php

namespace app\controllers;

use Yii;
use app\models\categorias\Categorias;
use app\models\categorias\CategoriasSearch;
use app\models\categorias\FormUpdateCategorias;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
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
            'verbs' => [
                'class' => VerbFilter::className(),
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
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Categorias model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Categorias();

        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            if($model->validate())
            {
                $table = new Categorias();
                $transaction = $table->getDb()->beginTransaction();
                try{
                    $table->categoria = mb_strtoupper($model->categoria);
                    if($table->insert())
                    {
                        $transaction->commit();
                        Yii::$app->session->setFlash('success', 'Se ha ingresado correctamente la <b>Categoría</b>.-.');
                        return $this->redirect(['categorias/index']);
                    }else{
                        $transaction->rollBack();
                        Yii::$app->session->setFlash('error', 'Ocurrió un error, al ingresar la <b>Categoría</b>.-');
                        return $this->redirect(['categorias/index']);
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
            }else{
                $model->getErrors();
            }
            //return $this->redirect(['view', 'id' => $model->idcategoria]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Categorias model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = new FormUpdateCategorias();
        $table = new Categorias();

        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax)
        {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
                if($model->validate())
                {
                    $transaction = $table->getDb()->beginTransaction();
                    try
                    {
                        $table = Categorias::findOne(['idcategoria' => $id]);
                        if($table)
                        {
                            $table->categoria = mb_strtoupper($model->categoria);
                            if($table->update())
                            {
                                $transaction->commit();
                                Yii::$app->session->setFlash('success','La <b>Categoría</b> se ha actualizado exitosamente.-');
                                return $this->redirect(['categorias/index']);
                            }else{
                                $transaction->rollBack();
                                Yii::$app->session->setFlash('error','No se ha actualizado la <b>Categoría</b>.-');
                            }
                        }
                    }
                    catch (\Exception $e) {
                        $transaction->rollBack();
                        throw $e;
                    }
                    catch (\Throwable $e) {
                        $transaction->rollBack();
                        throw $e;
                    }
                }else{
                    $model->getErrors();
                }
        }else{
            $table = Categorias::findOne(["idcategoria" => $id]);
            if($table)
            {
                $model->categoria = $table->categoria;
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Categorias model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        //Se debe hacer la busqueda de categorías por libro
        $table = new Categorias();

        $transaction = $table->getDb()->beginTransaction();
        try
        {
            if($table->deleteAll("idcategoria=:idcategoria",[":idcategoria"=>$id]))
            {
                $transaction->commit();
                Yii::$app->session->setFlash('success', 'Se ha borrado correctamente la Categoría '. $table->categoria );
            }else{
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', 'Ocurrió un error, no se borro la Catgoría.-');
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
