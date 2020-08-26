<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ejemplar\Ejemplar */

$this->title = 'Actualizar Ejemplar: ' . $model->idLibros0->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Ejemplares', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idLibros0->titulo, 'url' => ['view', 'id' => $model->idejemplar]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="ejemplar-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
