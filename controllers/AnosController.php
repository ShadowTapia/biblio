<?php

namespace app\controllers;

use app\models\anos\Anos;
use app\models\anos\FormUpdateAnos;
use app\models\pivot\Pivot;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\Controller;

class AnosController extends Controller
{
    /**
     * 
     * Indice del menu anos
     * 
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider(['query' => Anos::find()]);
        $dataProvider->sort->defaultOrder = ['idano' => SORT_ASC];
        return $this->render('index',['dataProvider' => $dataProvider]);
    }
    
    /**
     * 
     * Se encarga de seleccionar el a�o en el cual trabajar
     * 
     */
    public function actionSelectano()
    {
        $dataProvider = new ActiveDataProvider(['query' => Anos::find()]);
        $dataProvider->sort->defaultOrder = ['idano' => SORT_ASC];
        return $this->render('selectano',['dataProvider' => $dataProvider]);
    }
    
    public function actionSeleccionaano($id)
    {
        if (Yii::$app->session['anoActivo']==$id)
        {
            Yii::$app->session->setFlash('error', utf8_encode('Ocurrio un error, este a�o ya se encuentra seleccionado.-'));
            echo "<meta http-equiv='refresh' content='3; " . Url::toRoute("anos/selectano") .
                    "'>";     
        }
        else{
            unset(Yii::$app->session['anoActivo']);
            unset(Yii::$app->session['nameAno']);
            $year = Anos::find()
                    ->where(['idano' => $id])
                    ->one();
            Yii::$app->session['anoActivo'] = $year->idano;
            Yii::$app->session['nameAno'] = $year->nombreano;
            Yii::$app->session->setFlash('success', utf8_encode('Se ha seleccionado el a�o '. Yii::$app->session['nameAno']));
                        echo "<meta http-equiv='refresh' content='3; " . Url::toRoute("anos/selectano") .
                            "'>";
        }
        
    }
    
    /**
     * 
     * Procedimiento de Actualizaci�n de anos
     */
    public function actionUpdateanos($id)
    {
        $model = new FormUpdateAnos;
        
        $table = new Anos;
        
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax)
        {
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
                    $table = Anos::findOne(["idano" => $id]);
                    if ($table)
                    {
                        $table->nombreano = $model->nombreano;
                        $table->activo = $model->activo;
                        
                        if ($table->update())
                        {
                            $transaction->commit();
                            \raoul2000\widget\pnotify\PNotify::widget(['pluginOptions' => ['title' =>
                                utf8_encode('A�os'), 'text' => utf8_encode('El A�o se ha actualizado exitosamente.-'), 'type' =>
                                'success', ]]);
                                echo "<meta http-equiv='refresh' content='3; " . Url::toRoute("anos/index") .
                            "'>";
                        }else{
                            $transaction->rollBack();
                            \raoul2000\widget\pnotify\PNotify::widget(['pluginOptions' => ['title' =>
                                utf8_encode('A�os'), 'text' => utf8_encode('No se ha actualizado el A�o.-'), 'type' => 'error', ]]);
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
            $table = Anos::findOne(["idano" => $id]);
            if ($table)
            {
                $model->nombreano = $table->nombreano;
                $model->activo = $table->activo;
            }
        }
        
        return $this->render('updateanos', ["model" => $model]);
    }
    
    /**
     * 
     * Se encarga de crear un a�o
     * 
     */
    public function actionCrearanos()
    {
        $model = new FormUpdateAnos;
        
        //Validaci�n mediante ajax
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->validate())
            {
                $table = new Anos;
                
                $transaction = $table->getDb()->beginTransaction();
                try
                {
                    $table->nombreano = $model->nombreano;
                    $table->activo = $model->activo;
                    
                    if ($table->insert())
                    {
                        $transaction->commit();
                        $model->nombreano = null;
                        \raoul2000\widget\pnotify\PNotify::widget([
		                  'pluginOptions' => [
			                 'title' => utf8_encode('A�os'),
			                 'text' => utf8_encode('Se ha creado correctamente el <b>A�o</b>.-.') ,
                             'type' => 'info',
		                      ]
	                       ]);
                           echo "<meta http-equiv='refresh' content='3; " . Url::toRoute("anos/index") .
                            "'>";
                    }else{
                        \raoul2000\widget\pnotify\PNotify::widget([
		                  'pluginOptions' => [
                            'title' => 'Error',
                            'text' => utf8_encode('Ocurrio un error, al ingresar un <b>A�o</b>.-') ,
                            'type' => 'error',
		                      ]
	                       ]);
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
        return $this->render('crearanos',["model" =>$model]);
    }
    
    /**
     * 
     * Metodo de eliminaci�n de a�os
     * 
     */
    public function actionDelete($id)
    {
        $table2 = Pivot::find()->where("idano=:idano", [":idano" => $id]);
        //Si existen alumnos con a�os ya asignados en la tabla
        if ($table2->count()>0)
        {
            Yii::$app->session->setFlash('error', utf8_encode('Ocurrio un error, existen a�os asociados a Alumnos.-'));
                echo "<meta http-equiv='refresh' content='3; " . Url::toRoute("anos/index") .
                    "'>";
        }else{
            $table = new Anos;
            
            $transaction = $table->getDb()->beginTransaction();
            try{
                if ($table->deleteAll("idano=:idano", [":idano" => $id]))
                {
                    $transaction->commit();
                        Yii::$app->session->setFlash('success', utf8_encode('Se ha borrado correctamente el A�o.-'));
                        echo "<meta http-equiv='refresh' content='3; " . Url::toRoute("anos/index") .
                            "'>";
                }else{
                    $transaction->rollBack();
                        Yii::$app->session->setFlash('error', utf8_encode('Ocurrio un error, no se borro el A�o.-'));
                        echo "<meta http-equiv='refresh' content='3; " . Url::toRoute("anos/index") .
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
    }

}
