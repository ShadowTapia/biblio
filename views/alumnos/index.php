<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\alumnos\AlumnosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Alumnos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alumnos-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Alumnos', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'rutalumno',
            'digrut',
            'sexo',
            'nombrealu',
            'paternoalu',
            //'maternoalu',
            //'calle',
            //'nro',
            //'depto',
            //'block',
            //'villa',
            //'codRegion',
            //'idProvincia',
            //'codComuna',
            //'email:email',
            //'fono',
            //'fechanac',
            //'nacionalidad',
            //'fechaing',
            //'fecharet',
            //'idalumno',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
