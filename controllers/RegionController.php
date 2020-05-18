<?php

namespace app\controllers;

use app\models\FormRegiones;
use app\models\FormUpdateRegiones;
use app\models\Provincias;
use app\models\Regiones;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

class RegionController extends Controller
{
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
                        \raoul2000\widget\pnotify\PNotify::widget([
		                  'pluginOptions' => [
			                 'title' => utf8_encode('Regi�n'),
			                 'text' => utf8_encode('Se ha creado correctamente la <b>Regi�n</b>.-.') ,
                             'type' => 'info',
		                      ]
	                       ]);
                        //Yii::$app->session->setFlash('success', utf8_encode('Se ha creado una nueva Regi�n-'));
                        //Redireccionamos a la p�gina origen
                        echo "<meta http-equiv='refresh' content='3; " . Url::toRoute("region/create") .
                            "'>";
                    } else {
                        \raoul2000\widget\pnotify\PNotify::widget([
		                  'pluginOptions' => [
			                 'title' => 'Error',
			                 'text' => utf8_encode('Ocurrio un error, al ingresar una <b>Regi�n</b>.-') ,
                             'type' => 'error',
		                      ]
	                       ]);
                        //Yii::$app->session->setFlash('error', utf8_encode('Ocurrio un error, al ingresar una Regi�n.-'));
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

        return $this->render('crearegiones', compact('model'));
    }
    
    /**
     * 
     * Se encarga de actualizar la regi�n seleccionada
     * 
     **/ 
    public function actionUpdateregion($id)
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
                    $table = Regiones::findOne(["codRegion" => $id]);
                    if ($table){
                        $table->region = mb_strtoupper($model->region);
                        $table->orden = $model->orden;
                        if ($table->update())
                        {
                               $transaction->commit();
                               \raoul2000\widget\pnotify\PNotify::widget([
		                          'pluginOptions' => [
                                  'title' => utf8_encode('Regi�n') ,
			                      'text' => utf8_encode('Se ha actualizado correctamente la <b>Regi�n</b>.'),
                                  'type' => 'info',
		                          ]]);
  
                               //Yii::$app->session->setFlash('success', utf8_encode('La Regi�n fue cambiada exitosamente.-'));
                            echo "<meta http-equiv='refresh' content='3; " . Url::toRoute("region/create") .
                                "'>"; 
                        } else {
                                $transaction->rollBack();
                               \raoul2000\widget\pnotify\PNotify::widget([
		                             'pluginOptions' => [
		                             'title' => utf8_encode('Regi�n'),
			                         'text' => utf8_encode('La Regi�n no fue actualizada.') ,
                                     'type' => 'error',
		                          ]]);  
                                //Yii::$app->session->setFlash('error', utf8_encode('La Regi�n no fue cambiada.-'));
                            echo "<meta http-equiv='refresh' content='3; " . Url::toRoute("region/create") .
                                "'>";
                        }
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
            $table = Regiones::findOne(["codRegion" => $id]);
            if ($table)
            {
                $model->region = $table->region;
                $model->orden = $table->orden;   
            }   
        } 
        
        return $this->render('updateregion',["model" => $model]);
    }

    public function actionCreate()
    {
        $dataProvider = new ActiveDataProvider(['query' => Regiones::find(), ]);
        $dataProvider->sort->defaultOrder = ['orden' => SORT_ASC]; //Ordenamos el resultado de la consulta
        return $this->render('create',compact('dataProvider'));
    }
    
    /**
     * 
     * Se encarga de eliminar una regi�n
     * 
     **/ 
    public function actionRemove($id)
    {
        if ((int)$id) {
            //recordar hacer verificaci�n en tabla provincias antes de borrar la regi�n
            $table2 = Provincias::find()->where("codRegion=:codRegion", [":codRegion" => $id]);
            //Si existen provincias asociadas lanzamos la advertencia
            if($table2->count()>0){
                Yii::$app->session->setFlash('error', utf8_encode('Ocurrio un error, existen provincias asociadas a esta regi�n.-'));
                echo "<meta http-equiv='refresh' content='3; " . Url::toRoute("region/create") .
                    "'>";
            } else {

                $table = new Regiones;

                $transaction = $table::getDb()->beginTransaction();
                try {
                    if ($table::deleteAll("codRegion=:codRegion", [":codRegion" => $id])) {
                        $transaction->commit();
                        Yii::$app->session->setFlash('success', utf8_encode('Se ha borrado correctamente la Regi�n.-'));
                        echo "<meta http-equiv='refresh' content='3; " . Url::toRoute("region/create") .
                            "'>";
                    } else {
                        $transaction->rollBack();
                        Yii::$app->session->setFlash('error', utf8_encode('Ocurrio un error, no se borro la Regi�n.-'));
                        echo "<meta http-equiv='refresh' content='3; " . Url::toRoute("region/create") .
                            "'>";
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
            echo "<meta http-equiv='refresh' content='3; " . Url::toRoute("region/create") .
                    "'>";
         }       
    }
}
