<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\categorias\Categorias */

$this->title = 'Actualizar Categorías: ' . $model->categoria;
$this->params['breadcrumbs'][] = ['label' => 'Categorías', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->categoria, 'url' => ['view', 'id' => $model->idcategoria]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="categorias-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
