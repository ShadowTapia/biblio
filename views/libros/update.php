<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\libros\Libros */

$this->title = 'Actualizar Libro: ' . $model->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Libros', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->titulo, 'url' => ['view', 'id' => $model->idLibros]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="libros-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formupdate', [
        'model' => $model,
    ]) ?>

</div>
