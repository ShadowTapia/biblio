<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\historico\Historico */

$this->title = 'Update Historico: ' . $model->idhistorico;
$this->params['breadcrumbs'][] = ['label' => 'Historicos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idhistorico, 'url' => ['view', 'id' => $model->idhistorico]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="historico-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
