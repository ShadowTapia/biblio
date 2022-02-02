<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\temas\Temas */

$this->title = 'Crear Temas';
$this->params['breadcrumbs'][] = ['label' => 'Temas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="temas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
