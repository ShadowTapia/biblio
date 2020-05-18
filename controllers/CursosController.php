<?php

namespace app\controllers;

use app\models\cursos\Cursos;
use app\models\cursos\FormCreaCursos;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

class CursosController extends Controller
{
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider(['query' => Cursos::find()]);
        $dataProvider->sort->defaultOrder = ['Orden' => SORT_ASC];
        return $this->render('index',compact('dataProvider'));
    }
    
    /**
     * 
     * Se encarga de actualizar un curso
     * 
     */
    public function actionUpdatecurso($id)
    {
        $model = new FormCreaCursos;
        
        $table = new Cursos;
        
        if($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax)
        {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        
        if($model->load(Yii::$app->request->post()))
        {
            if($model->validate())
            {
                $transaction = $table->getDb()->beginTransaction();
                try
                {
                    $table = Cursos::findOne(["idCurso" => $id]);
                    if ($table)
                    {
                        $table->Nombre = $model->Nombre;
                        $table->Orden = $model->Orden;
                        $table->visible = $model->visible;
                        
                        if ($table->update())
                        {
                            $transaction->commit();
                            \raoul2000\widget\pnotify\PNotify::widget(['pluginOptions' => ['title' =>
                                utf8_encode('Cursos'), 'text' => utf8_encode('El Curso se ha actualizado exitosamente.-'), 'type' =>
                                'success', ]]);
                                echo "<meta http-equiv='refresh' content='3; " . Url::toRoute("cursos/index") .
                            "'>";
                        }else{
                            $transaction->rollBack();
                            \raoul2000\widget\pnotify\PNotify::widget(['pluginOptions' => ['title' =>
                                utf8_encode('Cursos'), 'text' => utf8_encode('No se ha actualizado el Curso.-'), 'type' => 'error', ]]);
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
            $table = Cursos::findOne(["idCurso" => $id]);
            if($table)
            {
                $model->Nombre = $table->Nombre;
                $model->Orden = $table->Orden;
                $model->visible = $table->visible;
            }
        }
        
        return $this->render('updatecurso',["model" => $model]);
    }
    
    /**
     * 
     * Se encarga de crear los cursos
     * 
     */
    public function actionCrearcursos()
    {
        $model = new FormCreaCursos;
        
        //Validaci�n mediante ajax
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post()))
        {
            if($model->validate())
            {
                $table = new Cursos;
                
                $transaction = $table->getDb()->beginTransaction();
                try
                {
                    $table->Nombre = $model->Nombre;
                    $table->Orden = $model->Orden;
                    $table->visible = $model->visible;
                    
                    if($table->insert())
                    {
                        $transaction->commit();
                        $model->Nombre = null;
                        $model->Orden = null;
                        \raoul2000\widget\pnotify\PNotify::widget([
		                  'pluginOptions' => [
			                 'title' => utf8_encode('Cursos'),
			                 'text' => utf8_encode('Se ha creado correctamente el <b>Curso</b>.-.') ,
                             'type' => 'info',
		                      ]
	                       ]);
                           echo "<meta http-equiv='refresh' content='3; " . Url::toRoute("cursos/index") .
                            "'>";
                    }else{
                        \raoul2000\widget\pnotify\PNotify::widget([
		                  'pluginOptions' => [
                            'title' => 'Error',
                            'text' => utf8_encode('Ocurrio un error, al ingresar un <b>Curso</b>.-') ,
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
        
        return $this->render('crearcursos',["model" =>$model]);
    }

}
