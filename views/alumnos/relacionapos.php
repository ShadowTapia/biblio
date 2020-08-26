<?php

use app\models\alumnos\AlumnosSearch;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\alumnos\AlumnosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Listado de Alumnos para Asignar Apoderados';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="variable" style="display: none;"><?= $count ?></div>
<?php
$this->registerJs(
    '$("document").ready(function(){                    
                    var x = document.getElementById("toggleSearch");
                    var myParam = document.getElementById("variable").innerHTML;
                    if(myParam>0){
                        if(x.style.display==="none"){
                            x.style.display="block";
                        }
                    }else{
                         x.style.display="none";
                    }
            });'
);
?>
<div class="alumnos-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- Render consulta form -->
    <?= $this->render('_form',[
            'model' => $model,
    ]) ?>

    <div id="toggleSearch">
        <?php Pjax::begin([
            'id' => 'alumnos',
            'timeout' => false,
            'enablePushState' => false,
            'clientOptions' => ['method' => 'GET']
        ]); ?>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <?php
            $gridColumns = [
                [
                    'class' => 'yii\grid\SerialColumn',
                    'headerOptions' => ['width' => '20px'],
                    'header' => 'N°',
                    'contentOptions' => ['style' => 'width: 20px;', 'class' => 'text-center'],
                ],
                //Run alumno
                [
                    'attribute' => 'rutalumno',
                    'label' => 'Run',
                    'headerOptions' => ['width' => '120px'],
                    'value' => function($model){
                        return Yii::$app->formatter->asDecimal($model->rutalumno,0). "-" .  $model->digrut;
                    }
                ],
                //Nombre alumno
                [
                    'attribute' => 'nombrealu',
                    'label' => 'Nombre',
                    'format' => 'html',
                    'value' => function($model){
                        return !empty($model->nombrealu) ? $model->nombrealu : '<span class="glyphicon glyphicon-question-sign"></span>';
                    }
                ],
                // A. Paterno
                [
                    'attribute' => 'paternoalu',
                    'label' => 'A. Paterno',
                    'format' => 'html',
                    'value' => function($model){
                        return !empty($model->paternoalu) ? $model->paternoalu : '<span class="glyphicon glyphicon-question-sign"></span>';
                    }
                ],
                //A. Materno
                [
                    'attribute' => 'maternoalu',
                    'label' => 'A. Materno',
                    'format' => 'html',
                    'value' => function($model){
                        return !empty($model->maternoalu) ? $model->maternoalu : '<span class="glyphicon glyphicon-question-sign"></span>';
                    }
                ],
                //Nombre apoderado
                [
                    'label' => 'Nombre Apoderado',
                    'format' => 'html',
                    'value' => function($data){
                        return !empty(AlumnosSearch::getNombreTrigger($data->idalumno)) ? AlumnosSearch::getNombreTrigger($data->idalumno) : '<span class="glyphicon glyphicon-question-sign"></span>';
                    },
                ],
                //Botones de acción
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => 'Acciones',
                    'headerOptions' => ['width'=> '80'],
                    'template'=> ' {update} ',
                    'buttons' => [
                        'update' => function($url, $model){
                            return Html::a("<span class='glyphicon glyphicon-pencil'></span>",['apoderados/ingresaapo','id' => $model->idalumno,'run' => $model->rutalumno],
                                ['class' => 'btn btn-circle btn-success btn-sm','title' => 'Ingresar Apoderado']);
                        },
                    ],
                ],
            ];
        ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns,
            'export' => false,
            'pjax' => true,
            //'filterModel' => $searchModel,
            'emptyText' => 'No hay resultados para este Curso',
            'showPageSummary' => false,
            'panel' => [
                'type' => 'primary',
                'heading' => '<h3 class="panel-title">Listado Curso ' . ' ' . $nomcurso . ' ' . Yii::$app->session->get('nameAno') . '</h3>',
                'footer' => false
            ]
        ]); ?>

        <?php Pjax::end(); ?>
    </div>


</div>
