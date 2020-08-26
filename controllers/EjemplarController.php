<?php

namespace app\controllers;

use Yii;
use app\models\ejemplar\Ejemplar;
use app\models\ejemplar\EjemplarSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use yii\web\Response;

/**
 * EjemplarController implements the CRUD actions for Ejemplar model.
 */
class EjemplarController extends Controller
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
     * Lists all Ejemplar models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EjemplarSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Ejemplar model.
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
     * Creates a new Ejemplar model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {

        $model = new Ejemplar();

        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->validate())
            {
                $table = new Ejemplar();
                $transaction = $table->getDb()->beginTransaction();
                try
                {
                    $table->norden = $model->norden;
                    $table->edicion = $model->edicion;
                    $table->ubicacion = $model->ubicacion;
                    $table->idLibros = $id;
                    $table->fechain = Yii::$app->formatter->asDate($model->fechain,"yyyy-MM-dd");
                    $table->disponible = $model->disponible;
                    if ($table->insert())
                    {
                        $transaction->commit();
                        Yii::$app->session->setFlash('success','El <b>Ejemplar</b> se ha ingresado exitosamente.-');
                        return $this->redirect(['libros/index']);
                    }else{
                        $transaction->rollBack();
                        Yii::$app->session->setFlash('error','No se logro ingresar el <b>Ejemplar</b>.-');
                        return $this->redirect(['libros/index']);
                    }
                }
                catch (\Exception $e)
                {
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
     * Updates an existing Ejemplar model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = new Ejemplar();
        $table = new Ejemplar();


        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->validate())
            {
                $transaction = $table->getDb()->beginTransaction();
                try
                {
                    $table = Ejemplar::findOne(['idejemplar' => $id]);
                    if ($table)
                    {
                        $table->norden = $model->norden;
                        $table->edicion = $model->edicion;
                        $table->ubicacion = $model->ubicacion;
                        $table->fechain = Yii::$app->formatter->asDate($model->fechain,"yyyy-MM-dd");
                        $table->disponible = $model->disponible;
                        $table->fechaout = Yii::$app->formatter->asDate($model->fechaout,"yyyy-MM-dd");
                        if ($table->update())
                        {
                            $transaction->commit();
                            Yii::$app->session->setFlash('success','El Ejemplar se ha actualizado exitosamente.-');
                            return $this->redirect(['ejemplar/index']);
                        }else{
                            $transaction->rollBack();
                            Yii::$app->session->setFlash('error','No se ha actualizado el Ejemplar.-');
                            return $this->redirect(['ejemplar/index']);
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
            $model = $this->findModel($id);
        }


        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Ejemplar model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        //verificar que no exista un prestamo
        //verificar que el ejemplar no este registrado en la tabla de historicos
        $table = new Ejemplar();
        $transaction = $table->getDb()->beginTransaction();
        try
        {
            if ($table->deleteAll("idejemplar=:idejemplar",[":idejemplar" => $id]))
            {
                $transaction->commit();
                Yii::$app->session->setFlash('success', 'Se ha borrado correctamente el Ejemplar para '. $table->idLibros0->titulo);
            }else{
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', 'Ocurrió un error, no se borro el Ejemplar.-');
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
     * Finds the Ejemplar model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Ejemplar the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ejemplar::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
