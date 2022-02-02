<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\autor\Autor */

$this->title = 'Actualizar Autor: ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Autores', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->idautor]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="autor-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
