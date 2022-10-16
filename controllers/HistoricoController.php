<?php

namespace app\controllers;

use Yii;
use app\models\historico\HistoricoSearch;
use yii\web\Controller;

/**
 * Class HistoricoController
 * @package app\controllers
 */
class HistoricoController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new HistoricoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
