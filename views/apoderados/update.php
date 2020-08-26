<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\apoderados\Apoderados */

$this->title = 'Update Apoderados: ' . $model->idApo;
$this->params['breadcrumbs'][] = ['label' => 'Apoderados', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idApo, 'url' => ['view', 'id' => $model->idApo]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="apoderados-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
