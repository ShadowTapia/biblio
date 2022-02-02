<?php

namespace app\controllers;

use yii\web\Controller;

/**
 * Class HistoricoController
 * @package app\controllers
 */
class HistoricoController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
