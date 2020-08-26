<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ejemplar\Ejemplar */

$this->title = 'Ingresar Ejemplar para '. $_GET['name'];
$this->params['breadcrumbs'][] = ['label' => 'Libros', 'url' => ['libros/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ejemplar-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
