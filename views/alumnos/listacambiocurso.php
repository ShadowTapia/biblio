<?php
/**
 * Created by PhpStorm.
 * User: chelo
 * Date: 29-06-2020
 * Time: 0:01
 */

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

$this->title = "Listado de alumnos para cambio de curso";
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

    <!-- Renderizamos el combo de consulta -->
    <?= $this->render('_form',['model' => $model,]) ?>

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
                'header'=>'',
                'headerOptions'=>['class'=>'kartik-sheet-style'],
            ],
            [
                'attribute' => 'rutalumno',
                'label' => 'RUN',
                'value' => function($model) {
                    return Yii::$app->formatter->asDecimal($model->rutalumno, 0) . "-" . $model->digrut;
                }
            ],
            [
                'attribute' => 'nombrealu',
                'label' => 'Nombre',
                'format' => 'html',
                'value' => function($model){
                    return !empty($model->nombrealu) ? $model->nombrealu : '<span class="glyphicon glyphicon-question-sign"></span>';
                }
            ],
            [
                'attribute' => 'paternoalu',
                'label' => 'A. Paterno',
                'format' => 'html',
                'value' => function($model){
                    return !empty($model->paternoalu) ? $model->paternoalu : '<span class="glyphicon glyphicon-question-sign"></span>';
                }
            ],
            [
                'attribute' => 'maternoalu',
                'label' => 'A. Materno',
                'format' => 'html',
                'value' => function($model){
                    return !empty($model->maternoalu) ? $model->maternoalu : '<span class="glyphicon glyphicon-question-sign"></span>';
                }
            ],
            [
                    'class'=> '\kartik\grid\ActionColumn',
                    'header'=> 'Acciones',
                    'template'=> ' {update} ',
                    'buttons'=>[
                            'update'=>function($url,$model){
                                return Html::a("<span class='glyphicon glyphicon-pencil'></span>",['alumnos/cambiocurso','id'=>$model->idalumno],
                                    ['class'=>'btn btn-circle btn-success btn-sm','title'=>'Actualizar Curso']);
                            },
                    ],
            ]
        ];
        ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns,
            'export'=>false, //evita para que aparezca el menu exportar en el panel
            'pjax' => true,
            'bordered' => true,
            'striped' => false,
            'condensed' => false,
            'emptyText' => 'No hay resultados para este Curso',
            'responsive' => true,
            'hover' => true,
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
