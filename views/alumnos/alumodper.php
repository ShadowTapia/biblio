<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = 'Permisos para Alumnos ' . Yii::$app->session->get('nameAno');
$this->params['breadcrumbs'][] = $this->title;
?>
<?= \lavrentiev\widgets\toastr\NotificationFlash::widget([
    'options' => [
        "closeButton" => true,
        "debug" => false,
        "newestOnTop" => false,
        "progressBar" => false,
        "positionClass" => \lavrentiev\widgets\toastr\NotificationFlash::POSITION_TOP_RIGHT,
        "preventDuplicates" => false,
        "onclick" => null,
        "showDuration" => "300",
        "hideDuration" => "1000",
        "timeOut" => "5000",
        "extendedTimeOut" => "1000",
        "showEasing" => "swing",
        "hideEasing" => "linear",
        "showMethod" => "fadeIn",
        "hideMethod" => "fadeOut"
    ]
])
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
    <?= $this->render('_form', ['model' => $model,]) ?>

    <div id="toggleSearch" style="display:none">
        <?php
        Pjax::begin([
            'id' => 'alumnos',
            'timeout' => false,
            'enablePushState' => false,
            'clientOptions' => ['method' => 'GET']
        ]);
        ?>
        <?php
        $gridColumns = [
            [
                'class' => 'yii\grid\SerialColumn',
                'headerOptions' => ['width' => '20px'],
                'contentOptions' => ['style' => 'width: 20px;', 'class' => 'text-center'],
            ],
            //id Users
            [
                'attribute' => 'rutalumno0',
                'label' => 'id User',
                'visible' => false,
                'format' => 'html',
                'value' => function ($model) {
                    return $model->rutalumno0->idUser;
                }
            ],
            //Run alumno
            [
                'attribute' => 'rutalumno',
                'label' => 'Run',
                'headerOptions' => ['width' => '120px'],
                'value' => function ($model) {
                    return Yii::$app->formatter->asDecimal($model->rutalumno, 0) . "-" .  $model->digrut;
                }
            ],
            //Apellido paterno
            [
                'attribute' => 'paternoalu',
                'label' => 'A. Paterno',
                'format' => 'html',
                'value' => function ($model) {
                    return !empty($model->paternoalu) ? $model->paternoalu : '<span class="glyphicon glyphicon-question-sign"></span>';
                }
            ],
            //Apellido materno
            [
                'attribute' => 'maternoalu',
                'label' => 'A. Materno',
                'format' => 'html',
                'value' => function ($model) {
                    return !empty($model->maternoalu) ? $model->maternoalu : '<span class="glyphicon glyphicon-question-sign"></span>';
                }
            ],
            //Nombre alumno
            [
                'attribute' => 'nombrealu',
                'label' => 'Nombres',
                'format' => 'html',
                'value' => function ($model) {
                    return !empty($model->nombrealu) ? $model->nombrealu : '<span class="glyphicon glyphicon-question-sign"></span>';
                }
            ],
            //Acciones
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Acciones',
                'headerOptions' => ['width' => '120'],
                'template' => '{up_pass},{activa_cta}',
                'buttons' => [
                    'up_pass' => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-refresh"></span>',
                            ['users/uppass', 'id' => $model->rutalumno0->idUser, 'fuente' => 2],
                            [
                                'class' => 'btn btn-circle btn-success',
                                'title' => 'Resetear contraseña',
                                'data' => [
                                    'confirm' => 'Desea resetear la contraseña de ' . $model->nombrealu . ' ' . $model->paternoalu . ' ' . $model->maternoalu  . '?',
                                    'method' => 'post',
                                ],
                            ]
                        );
                    },
                    'activa_cta' => function ($url, $model) {
                        return Html::a(
                            "<span class='glyphicon glyphicon-pencil'></span>",
                            [
                                'users/updateuser', 'id' => $model->rutalumno0->idUser, 'fuente' => 2
                            ],
                            ['class' => 'btn btn-circle btn-primary', 'title' => 'Actualizar']
                        );
                    }
                ],
            ]
        ];
        ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns,
            'rowOptions' => function ($model) {
                if ($model->rutalumno0->activate == '1') {
                    return ['class' => 'info'];
                } else {
                    return ['class' => 'danger'];
                }
            },
            'export' => false,
            'pjax' => true,
            'emptyText' => 'No hay resultados para este Curso',
            'showPageSummary' => false,
            'panel' => [
                'type' => 'primary',
                'heading' => '<h3 class="panel-title">Permisos para Alumnos ' . ' ' . $nomcurso . ' ' . Yii::$app->session->get('nameAno') . '</h3>',
                'footer' => false
            ]
        ]); ?>

        <?php Pjax::end(); ?>
    </div>
</div>