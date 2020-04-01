<?php

namespace app\controllers;

use app\models\pivot\FormSelectPivot;
use Yii;


class AlumnosController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    public function actionAsignar()
    {
        $model = new FormSelectPivot();
        
        //validaci�n mediante ajax
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        
        if($model->load(Yii::$app->request->post()))
        {

        }
        
        return $this->render('asignar',["model" => $model]);        
        
    }

}
