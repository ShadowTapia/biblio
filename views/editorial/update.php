<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\editorial\Editorial */

$this->title = 'Actualizar Editorial: ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Editoriales', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->ideditorial]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="editorial-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
