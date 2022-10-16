<?php

namespace app\controllers;

use app\models\Comunas;
use app\models\FormComunas;
use app\models\Provincias;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\base\Exception;

/**
 * Class ComunasController
 * @package app\controllers
 */
class ComunasController extends Controller
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

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
        'query' => Comunas::find()->joinWith(['provincia pro'])->joinWith(['codRegion0 cod'])->orderBy('orden'),]);
        return $this->render('index',compact('dataProvider'));
    }

    /**
     * @param $id
     * @return Response
     * @throws \Exception
     * @throws \Throwable
     */
    public function actionDelete($id)
    {
        if((int)$id)
        {
            $table = new Comunas;
            $transaction = $table::getDb()->beginTransaction();
            try{
                    if ($table::deleteAll("codComuna=:codComuna", [":codComuna" => $id])) {
                        $transaction->commit();
                        \Yii::$app->session->setFlash('success', 'Se ha borrado correctamente la Comuna.-');
                    } else {
                        $transaction->rollBack();
                        \Yii::$app->session->setFlash('error', 'Ocurrio un error, no se borro la Comuna.-');
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
        return $this->redirect('index');
    }

    /**
     * @return array|string|Response
     * @throws \Throwable
     */
    public function actionCrearcomunas()
    {
        $model = new FormComunas;
        
        //validación mediante ajax
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

                        \Yii::$app->session->setFlash('success', 'Se ha creado correctamente la Comuna.');

                    }else{
                        Yii::$app->session->setFlash('error', 'Ocurrio un error, al ingresar la Comuna.-.');

                    }
                    return $this->redirect('index');
                }
                catch (Exception $e){
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
        return $this->renderAjax('crearcomunas',["model" => $model]);
    }

    /**
     * @param $id
     */
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
