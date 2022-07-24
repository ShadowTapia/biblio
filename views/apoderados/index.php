<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\apoderados\ApoderadosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Apoderados';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="apoderados-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Apoderados', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'rutapo',
            'digrut',
            'nombreapo',
            'apepat',
            'apemat',
            //'calle',
            //'nro',
            //'depto',
            //'block',
            //'villa',
            //'codRegion',
            //'idProvincia',
            //'codComuna',
            //'fono',
            //'email:email',
            //'celular',
            //'estudios',
            //'niveledu',
            //'profesion',
            //'trabajoplace',
            //'relacion',
            //'rutalumno',
            //'idApo',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
