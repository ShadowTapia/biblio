<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\libros\Libros */

$this->title = 'Alta Libros';
$this->params['breadcrumbs'][] = ['label' => 'Libros', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="libros-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <h7>Campos con * son obligatorios</h7>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>