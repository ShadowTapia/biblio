<?php

namespace app\controllers;

use app\models\Comunas;
use app\models\FormComunas;
use app\models\Provincias;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;

class ComunasController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
        'query' => Comunas::find()->joinWith(['provincia pro'])->joinWith(['codRegion0 cod'])->orderBy('orden'),]);
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }
    /**
     * Se encarga de borrar una comuna 
     * 
     **/
    public function actionDelete($id)
    {
        if((int)$id)
        {
            $table = new Comunas;
            $transaction = $table::getDb()->beginTransaction();
            try{
                    if ($table::deleteAll("codComuna=:codComuna", [":codComuna" => $id])) {
                        $transaction->commit();
                        Yii::$app->session->setFlash('success', utf8_encode('Se ha borrado correctamente la Comuna.-'));
                        echo "<meta http-equiv='refresh' content='3; " . Url::toRoute("comunas/index") .
                            "'>";
                    } else {
                        $transaction->rollBack();
                        Yii::$app->session->setFlash('error', utf8_encode('Ocurrio un error, no se borro la Comuna.-'));
                        echo "<meta http-equiv='refresh' content='3; " . Url::toRoute("Comunas/index") .
                            "'>";
                    }                    
            }catch (\Exception $e){
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
    /**
     * Procedimiento para crear comunas
     * 
     **/
    public function actionCrearcomunas()
    {
        $model = new FormComunas;
        
        //validaci�n mediante ajax
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }  
        
        if($model->load(Yii::$app->request->post()))
        {
            if($model->validate())
            {
                $table=new Comunas;
                
                //comenzar la transacci�n
                $transaction = $table::getDb()->beginTransaction();
                try{
                    $table->codComuna = $model->codComuna;                    
                    $table->comuna = ucwords($model->comuna);
                    $table->idProvincia = $model->idProvincia;
                    
                    if($table->insert())
                    {
                        $transaction->commit();
                        //limpiamos los controles del formulario
                        $model->codComuna = null;
                        $model->comuna = null;
                        \raoul2000\widget\pnotify\PNotify::widget([
		                  'pluginOptions' => [
			                 'title' => 'Ingreso',
			                 'text' => 'Se ha creado correctamente la <b>Comuna</b>.',
                             'type' => 'info',
		                      ]
	                       ]);
                        
                        //Yii::$app->session->setFlash('success', utf8_encode('Se ha agregado una nueva Comuna.-'));
                        //Redireccionamos a la p�gina origen
                        echo "<meta http-equiv='refresh' content='3; " . Url::toRoute("comunas/index") ."'>";
                    }else{
                        \raoul2000\widget\pnotify\PNotify::widget([
		                  'pluginOptions' => [
			                 'title' => 'Error',
			                 'text' => 'Ocurrio un error, al ingresar la <b>Comuna</b>.-.',
                             'type' => 'error',
		                      ]
	                       ]);
                        //Yii::$app->session->setFlash('error', utf8_encode('Ocurrio un error, al ingresar la Comuna.-'));
                    }
                }
                catch (\Exception $e){
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
        return $this->render('crearcomunas',["model" => $model]);
    }
    /**
     * Se encarga de cargar y poblar el dropdown dependiente
     * 
     **/    
    public function actionLists($id) {        
        $countProvincias = Provincias::find()
            ->where(['codRegion' => $id])
            ->count();
        
        $provincialists = Provincias::find()
            ->where(['codRegion' => $id])
            ->all();
            
        if($countProvincias>0)
        {
            
            foreach($provincialists as $provi)
            {
                echo "<option value='".$provi->idProvincia."'>".$provi->Provincia."</option>";
            }            
        }
        else
        {
            echo "<option>--------</option>";
        }
    }
}
