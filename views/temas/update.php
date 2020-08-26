<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\temas\Temas */

$this->title = 'Actualizar Temas: ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Temas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->idtemas]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="temas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
