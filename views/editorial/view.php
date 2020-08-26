<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\editorial\Editorial */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Editoriales', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="editorial-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->ideditorial], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Borrar', ['delete', 'id' => $model->ideditorial], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Estas seguro de borrar esta Editorial?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ideditorial',
            'nombre',
            'direccion',
            'telefono',
            'mail',
        ],
    ]) ?>

</div>
