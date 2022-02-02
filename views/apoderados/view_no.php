<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\apoderados\Apoderados */

$this->title = $model->idApo;
$this->params['breadcrumbs'][] = ['label' => 'Apoderados', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="apoderados-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->idApo], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->idApo], [
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
            'rutapo',
            'digrut',
            'nombreapo',
            'apepat',
            'apemat',
            'calle',
            'nro',
            'depto',
            'block',
            'villa',
            'codRegion',
            'idProvincia',
            'codComuna',
            'fono',
            'email:email',
            'celular',
            'estudios',
            'niveledu',
            'profesion',
            'trabajoplace',
            'relacion',
            'rutalumno',
            'idApo',
        ],
    ]) ?>

</div>
