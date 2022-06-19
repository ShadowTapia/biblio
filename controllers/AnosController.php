<?php

namespace app\controllers;

use app\models\anos\Anos;
use app\models\anos\FormUpdateAnos;
use app\models\pivot\Pivot;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Class AnosController
 * @package app\controllers
 */
class AnosController extends Controller
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
     * Se encarga de seleccionar el año en el cual trabajar
     * 
     */
    public function actionSelectano()
    {
        $dataProvider = new ActiveDataProvider(['query' => Anos::find()]);
        $dataProvider->sort->defaultOrder = ['idano' => SORT_ASC];
        return $this->render('selectano',compact('dataProvider'));
    }

    /**
     *
     * @param $id
     * Se encarga de seleccionar el año
     *
     * @return Response
     */
    public function actionSeleccionaano($id)
    {
        if (Yii::$app->session['anoActivo']==$id)
        {
            \Yii::$app->session->setFlash('error', 'Ocurrio un error, este año ya se encuentra seleccionado.-');
            return $this->redirect(['anos/selectano']);
        }
        else{
            unset(Yii::$app->session['anoActivo']);
            unset(Yii::$app->session['nameAno']);
            $year = Anos::find()
                    ->where(['idano' => $id])
                    ->one();
            /** @noinspection PhpUndefinedFieldInspection */
            Yii::$app->session->set('anoActivo',$year->idano);
            /** @noinspection PhpUndefinedFieldInspection */
            Yii::$app->session->set('nameAno',$year->nombreano);
            \Yii::$app->session->setFlash('success', 'Se ha seleccionado el año '. Yii::$app->session['nameAno']);
            return $this->redirect(['anos/selectano']);
        }
    }

    /**
     * @param $id
     * @return array|string
     * @throws \Exception
     * @throws \Throwable
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
                            \Yii::$app->session->setFlash('success','El Año se ha actualizado exitosamente.-');
                        }else{
                            $transaction->rollBack();
                            \Yii::$app->session->setFlash('error','No se ha actualizado el Año.-');
                        }
                        return $this->redirect(['anos/index']);
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
     * Se encarga de crear un año
     * 
     */
    public function actionCrearanos()
    {
        $model = new FormUpdateAnos;
        
        //Validación mediante ajax
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
                        \Yii::$app->session->setFlash('success','Se ha creado correctamente el Año.-');
                    }else{
                        \Yii::$app->session->setFlash('error','Ocurrió un error, al ingresar un Año.-');
                    }
                    return $this->redirect(['anos/index']);
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
     * @param $id
     * @return Response
     * @throws \Exception
     * @throws \Throwable
     */
    public function actionDelete($id)
    {
        $table2 = Pivot::find()->where("idano=:idano", [":idano" => $id]);
        //Si existen alumnos con a�os ya asignados en la tabla
        if ($table2->count()>0)
        {
            \Yii::$app->session->setFlash('error', 'Ocurrio un error, existen años asociados a Alumnos.-');
            return $this->redirect('anos/index');
        }else{
            $table = new Anos;
            
            $transaction = $table->getDb()->beginTransaction();
            try{
                if ($table->deleteAll("idano=:idano", [":idano" => $id]))
                {
                    $transaction->commit();
                        \Yii::$app->session->setFlash('success', 'Se ha borrado correctamente el Año.-');
                }else{
                    $transaction->rollBack();
                        \Yii::$app->session->setFlash('error', 'Ocurrió un error, no se borro el Año.-');
                }
                return $this->redirect(['anos/index']);
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
