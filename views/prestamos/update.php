<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\prestamos\Prestamos */

$this->title = 'Update Prestamos: ' . $model->idPrestamo;
$this->params['breadcrumbs'][] = ['label' => 'Prestamos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idPrestamo, 'url' => ['view', 'id' => $model->idPrestamo]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="prestamos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
