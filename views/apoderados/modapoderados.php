<?php
/**
 * Created by PhpStorm.
 * User: chelo
 * Date: 14-02-2022
 * Time: 23:59
 */
use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;

$this->title = 'Modificar Apoderados segun Curso';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="varcontador" style="display: none"><?= $count ?></div>
<?php
$this->registerJs(
    '$("document").ready(function(){
                    var x = document.getElementById("toggleSearch");
                    var myParam = document.getElementById("varcontador").innerHTML;
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
<div class="apoderados-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('/alumnos/_form',['model' => $model,]) ?>
    <div id="toggleSearch" style="display: none">
        <?php
            Pjax::begin([
                'id' => 'apoderados',
                'timeout' => false,
                'enablePushState' => false,
                'clientOptions'=>['method'=>'GET']
            ]);
        ?>
        <?php
        $gridColumns = [
            [
                'class' => 'yii\grid\SerialColumn'
            ],
            //Run
            [
                'attribute' => 'rutapo',
                'label' => 'RUN',
                'headerOptions' => ['width' => '120px'],
                'value' => function($model){
                    return Yii::$app->formatter->asDecimal($model->rutapo,0). "-" . $model->digrut;
                }
            ],
            //Nombre
            [
                'attribute' => 'nombreapo',
                'label' => 'Nombre',
                'format' => 'html',
                'value' => function($model){
                    return !empty($model->nombreapo) ? $model->nombreapo : '<span class="glyphicon glyphicon-question-sign"></span>';
                }
            ],
            //A. Paterno
            [
                'attribute' => 'apepat',
                'label' => 'A. Paterno',
                'format' => 'html',
                'value' => function($model){
                    return !empty($model->apepat) ? $model->apepat : '<span class="glyphicon glyphicon-question-sign"></span>';
                }
            ],
            //A. Materno
            [
                'attribute' => 'apemat',
                'label' => 'A. Materno',
                'format' => 'html',
                'value' => function($model){
                    return !empty($model->apemat) ? $model->apemat : '<span class="glyphicon glyphicon-question-sign"></span>';
                }
            ],
            //Email
            [
                'attribute' => 'email',
                'label' => 'E-mail',
                'format' => 'html',
                'value' => function($model){
                    return !empty(mb_strtolower($model->email)) ? mb_strtolower($model->email) : '<span class="glyphicon glyphicon-question-sign"></span>';
                }
            ],
            //Acciones
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Acciones',
                'headerOptions' => ['width'=> '80'],
                'template'=> ' {update} ',
                'buttons' => [
                    'update' => function($url, $model){
                        return Html::a("<span class='glyphicon glyphicon-pencil'></span>",['apoderados/update','id'=>$model->idApo],
                            ['class' => 'btn btn-circle btn-success btn-sm','title' => 'Modificar Apoderado']);
                    },
                ],
            ],
        ];
        ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns,
            'pjax' => true,
            'bordered' => true,
            'striped' => false,
            'condensed' => false,
            'responsive' => true,
            'hover' => true,
            'toggleDataContainer' => ['class' => 'btn-group mr-2'],
            'panel' => [
                'type' => 'primary',
                'heading' => '<h3 class="panel-title">Listado Curso ' . ' ' . $nomcurso . ' ' . Yii::$app->session->get('nameAno') . '</h3>',
                'footer' => false
            ]
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>

