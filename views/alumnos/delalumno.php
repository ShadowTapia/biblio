<?php
/**
 * Created by PhpStorm.
 * User: chelo
 * Date: 30-08-2021
 * Time: 23:55
 */
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Eliminar Alumnos por Curso ' . Yii::$app->session->get('nameAno');
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
]) ?>
<div class="alumnos-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <h6>*Incluye alumnos retirados</h6>

    <?= $this->render('_form',['model'=>$model]) ?>

    <div id="toggleSearch">
        <?php Pjax::begin([
            'id' => 'alumnos',
            'timeout' => false,
            'enablePushState' => false,
            'clientOptions' => ['method' => 'GET']
        ]); ?>
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
            //Botones de acción
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Acciones',
                'headerOptions' => ['width'=> '80'],
                'template'=> ' {delete} ',
                'buttons' => [
                    'delete' => function($url, $model){
                        return Html::a("<span class='glyphicon glyphicon-trash'></span>",['alumnos/delete','id'=>$model->idalumno ],
                            [
                                'class' => 'btn btn-circle btn-danger btn-sm',
                                'title' => 'Eliminar Alumno',
                                'data-toggle' => 'tooltip',
                                'data' => [
                                    'confirm' => 'Estas seguro de borrar al Alumno(a) ' . $model->nombrealu . ' ' . $model->paternoalu . ' ' . $model->maternoalu . '?',
                                    'method' => 'post',
                                ],
                            ]);
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
        ]);
        ?>
        <?php Pjax::end(); ?>
    </div>
</div>
