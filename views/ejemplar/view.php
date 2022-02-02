<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ejemplar\Ejemplar */

$this->title = $model->idLibros0->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Ejemplares', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="ejemplar-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->idejemplar], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Borrar', ['delete', 'id' => $model->idejemplar], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Estás seguro de borrar este Ejemplar?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

            'norden',
            'edicion',
            'ubicacion',
            [
                'attribute' => 'idLibros',
                'label' => 'Título',
                'value' => function($model){
                    return $model->idLibros0->titulo;
                }
            ],
            [
                'attribute' => 'fechain',
                'format' => ['date','php:d-m-Y'],
            ],
            [
                'attribute' => 'fechaout',
                'format' => ['date','php:d-m-Y'],
            ],
            [
                'attribute' => 'disponible',
                'value' => function($model){
                    return !empty($model->disponible) ? 'Si' : 'No';
                }
            ],
        ],
    ]) ?>

</div>
