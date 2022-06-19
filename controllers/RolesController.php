<?php

namespace app\controllers;

use app\models\FormRoles;
use app\models\Roles;
use app\models\Users;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Class RolesController
 * @package app\controllers
 */
class RolesController extends Controller
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
        $dataProvider = new ActiveDataProvider(['query' => Roles::find()]);
        $dataProvider->sort->defaultOrder = ['idroles' => SORT_ASC];     
        return $this->render('index',compact('dataProvider'));
    }
    
    /**
     * 
     * Se enecarga de crear los roles de usuario
     * 
     **/
    public function actionCrearroles()
    {
        $model = new FormRoles;
        
        //validación mediante ajax
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post()))
        {
            if($model->validate())
            {
                $table = new Roles;
                
                $transaction = $table::getDb()->beginTransaction();
                try{
                    $table->nombre = $model->nombre;
                    $table->descripcion = $model->descripcion;
                    
                    if($table->insert()){
                        $transaction->commit();
                        //limpiamos los campos del formulario
                        $model->nombre = null;
                        $model->descripcion = null;
                        \Yii::$app->session->setFlash('success', 'Se ha creado correctamente el Rol.-.');
                    }else{
                        \Yii::$app->session->setFlash('error', 'Ocurrio un error, al ingresar un Rol.-');
                    }
                    return $this->redirect(['index']);
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
        return $this->renderAjax('crearroles',["model" => $model]);
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
            //Recordar hacer verificaci�n de que no exista un rol asignado antes de borrar
            $table2 = Users::find()->where("Idroles=:Idroles", [":Idroles" => $id]);
            //Si existen usuarios asignados lanzamos la advertencia
            if($table2->count()>0)
            {
                \Yii::$app->session->setFlash('error', utf8_encode('Ocurrio un error, existen roles asociados a Usuarios.-'));
                return $this->redirect(['roles/index']);
            }else{
                $table = new Roles;
                
                $transaction = $table::getDb()->beginTransaction();
                try{
                    if($table->deleteAll("Idroles=:Idroles", [":Idroles" => $id]))
                    {
                        $transaction->commit();
                        \Yii::$app->session->setFlash('success', utf8_encode('Se ha borrado correctamente el Rol.-'));
                    }else{
                        $transaction->rollBack();
                        Yii::$app->session->setFlash('error', utf8_encode('Ocurrio un error, no se borro el Rol.-'));
                    }
                    return $this->redirect(['roles/index']);
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
            return $this->redirect(['roles/index']);
        }
    }

}
