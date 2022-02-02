<?php

namespace app\controllers;

use app\models\FormRegiones;
use app\models\FormUpdateRegiones;
use app\models\Provincias;
use app\models\Regiones;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Class RegionController
 * @package app\controllers
 */
class RegionController extends Controller
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
     * Se encarga de crear las regiones
     * 
     **/
    public function actionCrearegiones()
    {
        $model = new FormRegiones;

        //validaci�n mediante ajax
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $table = new Regiones;

                $transaction = $table::getDb()->beginTransaction();
                try {
                    $table->codRegion = $model->codRegion;
                    $table->region = mb_strtoupper($model->region);
                    $table->orden = $model->orden;

                    if ($table->insert()) {
                        $transaction->commit();
                        //limpiamos los campos rn el formulario
                        $model->codRegion = null;
                        $model->region = null;
                        $model->orden = null;

                        \Yii::$app->session->setFlash('success', 'Se ha creado una nueva Región-');
                        //Redireccionamos a la p�gina origen
                        return $this->redirect(['create']);

                    } else {
                        \Yii::$app->session->setFlash('error', 'Ocurrio un error, al ingresar la Región.-');
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
        }

        return $this->renderAjax('crearegiones', compact('model'));
    }

    /**
     * @param $idregion
     * @return array|string
     * @throws \Exception
     * @throws \Throwable
     */
    public function actionUpdateregion($idregion)
    {
        $model = new FormUpdateRegiones;
        
        $table = new Regiones;
        
        //validaci�n mediante ajax
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->validate()){
                $transaction = $table::getDb()->beginTransaction();
                try{
                    $table = Regiones::findOne(["codRegion" => $idregion]);
                    if ($table){
                        $table->region = mb_strtoupper($model->region);
                        $table->orden = $model->orden;
                        if ($table->update())
                        {
                               $transaction->commit();
                               \Yii::$app->session->setFlash('success', 'Se ha actualizado correctamente la <b>Región</b>.');

                        } else {
                               $transaction->rollBack();
                               \Yii::$app->session->setFlash('error', 'La Región no fue cambiada.-');

                        }
                        return $this->redirect('create');
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
            } else {
                $model->getErrors();  
            }
        } else {
            $table = Regiones::findOne(["codRegion" => $idregion]);
            if ($table)
            {
                $model->region = $table->region;
                $model->orden = $table->orden;   
            }   
        } 
        
        return $this->render('updateregion',compact('model'));
    }

    /**
     * @return string
     * Se encarga de poblar e mostrar el index de Regiones
     */
    public function actionCreate()
    {
        $dataProvider = new ActiveDataProvider(['query' => Regiones::find(), ]);
        $dataProvider->sort->defaultOrder = ['orden' => SORT_ASC]; //Ordenamos el resultado de la consulta
        return $this->render('create',compact('dataProvider'));
    }

    /**
     * @param $id
     * @return Response
     * @throws \Exception
     * @throws \Throwable
     */
    public function actionRemove($id)
    {
        if ((int)$id) {
            //recordar hacer verificaci�n en tabla provincias antes de borrar la regi�n
            $table2 = Provincias::find()->where("codRegion=:codRegion", [":codRegion" => $id]);
            //Si existen provincias asociadas lanzamos la advertencia
            if($table2->count()>0){
                \Yii::$app->session->setFlash('error', 'Ocurrio un error, existen provincias asociadas a esta región.-');
                return $this->redirect(['create']);
                //echo "<meta http-equiv='refresh' content='3; " . Url::toRoute("region/create") .
                //    "'>";
            } else {

                $table = new Regiones;

                $transaction = $table::getDb()->beginTransaction();
                try {
                    if ($table::deleteAll("codRegion=:codRegion", [":codRegion" => $id])) {
                        $transaction->commit();
                        \Yii::$app->session->setFlash('success', 'Se ha borrado correctamente la Región.-');
                        return $this->redirect(['create']);
                        //echo "<meta http-equiv='refresh' content='3; " . Url::toRoute("region/create") .
                        //    "'>";
                    } else {
                        $transaction->rollBack();
                        \Yii::$app->session->setFlash('error', 'Ocurrio un error, no se borro la Región.-');
                        return $this->redirect(['create']);
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

            }
         }else{
            return $this->redirect(['create']);
         }       
    }
}
