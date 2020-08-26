<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\autor\Autor */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Autores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="autor-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->idautor], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Borrar', ['delete', 'id' => $model->idautor], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Estas seguro de borrar este Autor?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idautor',
            'nombre',
            'nacionalidad',
        ],
    ]) ?>

</div>
