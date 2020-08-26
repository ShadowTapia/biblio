<?php

namespace app\controllers;

use Yii;
use app\models\autor\Autor;
use app\models\autor\FormUpdateAutor;
use app\models\autor\AutorSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
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
            'verbs' => [
                'class' => VerbFilter::className(),
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
     * Creates a new Autor model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     **/
    public function actionCreate()
    {
        $model = new Autor();

        //Validación mediante ajax
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            if($model->validate())
            {
                $table = new Autor();
                $transaction = $table->getDb()->beginTransaction();
                try
                {
                    $table->nombre = mb_strtoupper($model->nombre);
                    $table->nacionalidad = $model->nacionalidad;
                    if($table->insert())
                    {
                        $transaction->commit();
                        Yii::$app->session->setFlash('success', 'Se ha ingresado correctamente el <b>Autor</b>.-.');
                        return $this->redirect(['autor/index']);
                    }else{
                        $transaction->rollBack();
                        Yii::$app->session->setFlash('error', 'Ocurrio un error, al ingresar el <b>Autor</b>.-');
                        return $this->redirect(['autor/index']);
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
     * Updates an existing Autor model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = new FormUpdateAutor();
        $table = new Autor();

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
                    $table = Autor::findOne(["idautor" => $id]);
                    if($table)
                    {
                        $table->nombre = mb_strtoupper($model->nombre);
                        $table->nacionalidad = $model->nacionalidad;
                        if($table->update())
                        {
                            $transaction->commit();
                            Yii::$app->session->setFlash('success','El Autor se ha actualizado exitosamente.-');
                            return $this->redirect(['autor/index']);
                        }else{
                            $transaction->rollBack();
                            Yii::$app->session->setFlash('error','No se ha actualizado el Autor.-');
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
            $table = Autor::findOne(["idautor"=>$id]);
            if($table)
            {
                $model->idautor = $table->idautor;
                $model->nombre = $table->nombre;
                $model->nacionalidad = $table->nacionalidad;
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Autor model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
