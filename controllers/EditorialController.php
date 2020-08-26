<?php

namespace app\controllers;

use Yii;
use app\models\editorial\Editorial;
use app\models\editorial\EditorialSearch;
use app\models\editorial\FormUpdateEditorial;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;


/**
 * EditorialController implements the CRUD actions for Editorial model.
 */
class EditorialController extends Controller
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
     * Lists all Editorial models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EditorialSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Editorial model.
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
     * Creates a new Editorial model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Editorial();

        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if($model->load(Yii::$app->request->post()))
        {
            if($model->validate())
            {
                $table = new Editorial();
                $transaction = $table->getDb()->beginTransaction();
                try
                {
                    $table->nombre = mb_strtoupper($model->nombre);
                    $table->direccion = $model->direccion;
                    $table->telefono = $model->telefono;
                    $table->mail = $model->mail;
                    if($table->insert())
                    {
                        $transaction->commit();
                        Yii::$app->session->setFlash('success', 'Se ha ingresado correctamente la <b>Editorial</b>.-.');
                        return $this->redirect(['editorial/index']);
                    }else{
                        $transaction->rollBack();
                        Yii::$app->session->setFlash('error', 'Ocurrio un error, al ingresar la <b>Editorial</b>.-');
                        return $this->redirect(['editorial/index']);
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
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Editorial model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = new FormUpdateEditorial();
        $table = new Editorial();

        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax)
        {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            if($model->validate())
            {
                $transaction = $table->getDb()->beginTransaction();
                try{
                    $table = Editorial::findOne(["ideditorial"=>$id]);
                    if($table)
                    {
                        $table->nombre = mb_strtoupper($model->nombre);
                        $table->direccion = $model->direccion;
                        $table->telefono = $model->telefono;
                        $table->mail = $model->mail;
                        if($table->update())
                        {
                            $transaction->commit();
                            Yii::$app->session->setFlash('success','La <b>Editorial</b> se ha actualizado exitosamente.-');
                            return $this->redirect(['editorial/index']);
                        }else{
                            $transaction->rollBack();
                            Yii::$app->session->setFlash('error','No se ha actualizado la <b>Editorial</b>.-');
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
            $table = Editorial::findOne(["ideditorial"=>$id]);
            if($table)
            {
                $model->ideditorial=$table->ideditorial;
                $model->nombre=$table->nombre;
                $model->direccion=$table->direccion;
                $model->telefono=$table->telefono;
                $model->mail=$table->mail;
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Editorial model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        //Se debe realizar la busqueda de Editorial por Libro
        //
        $table = new Editorial();

        $transaction = $table->getDb()->beginTransaction();
        try{
            if($table->deleteAll("ideditorial=:ideditorial",[":ideditorial"=>$id]))
            {
                $transaction->commit();
                Yii::$app->session->setFlash('success', 'Se ha borrado correctamente la Editorial '. $table->nombre );
            }else{
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', 'Ocurrió un error, no se borro la Editorial.-');
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
     * Finds the Editorial model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Editorial the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Editorial::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
