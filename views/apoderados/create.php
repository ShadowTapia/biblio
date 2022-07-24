<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\apoderados\Apoderados */

$this->title = 'Create Apoderados';
$this->params['breadcrumbs'][] = ['label' => 'Apoderados', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="apoderados-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
