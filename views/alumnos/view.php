<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\alumnos\Alumnos */

$this->title = $model->idalumno;
$this->params['breadcrumbs'][] = ['label' => 'Alumnos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="alumnos-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->idalumno], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->idalumno], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'rutalumno',
            'digrut',
            'sexo',
            'nombrealu',
            'paternoalu',
            'maternoalu',
            'calle',
            'nro',
            'depto',
            'block',
            'villa',
            'codRegion',
            'idProvincia',
            'codComuna',
            'email:email',
            'fono',
            'fechanac',
            'nacionalidad',
            'fechaing',
            'fecharet',
            'idalumno',
        ],
    ]) ?>

</div>
