<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\categorias\Categorias */

$this->title = 'Crear Categorías';
$this->params['breadcrumbs'][] = ['label' => 'Categorías', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categorias-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
