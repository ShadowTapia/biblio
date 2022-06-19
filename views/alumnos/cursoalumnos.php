<?php
/**
 * Created by PhpStorm.
 * User: chelo
 * Date: 28-04-2020
 * Time: 0:23
 */

use kartik\grid\GridView;
use kartik\spinner\Spinner;
use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title='Alumnos por Curso '. Yii::$app->session->get('nameAno');
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
    <h6>*No incluye alumnos retirados</h6>
    <?= $this->render('_form',['model'=>$model,]) ?>

    <div id="well" style="display: none">
        <?= Spinner::widget([
            'preset' => Spinner::LARGE,
            'color' => 'blue',
            'align' => 'center'
        ]);
        ?>
    </div>
    <div id="toggleSearch" style="display: none">
        <p id="divImprime" class="row" style="text-align: right">
            <?= Html::a('<span class="glyphicon glyphicon-print"></span> Imprimir', ['reporte'],['class' => 'btn btn-warning','target'=>'_blank','data-toggle'=>'tooltip','title'=>'Generara un reporte en formato pdf']) ?>
        </p>
        <?php Pjax::begin([
           'id'=>'alumnos',
            'timeout'=>false,
            'enablePushState'=>false,
            'clientOptions'=>['method'=>'GET']
        ]); ?>

        <?php
            $gridColumns = [
                [
                    'class' => 'yii\grid\SerialColumn',
                    'headerOptions' => ['width' => '20px'],
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
                //Apellido paterno
                [
                    'attribute' => 'paternoalu',
                    'label' => 'A. Paterno',
                    'format' => 'html',
                    'value' => function($model){
                        return !empty($model->paternoalu) ? $model->paternoalu : '<span class="glyphicon glyphicon-question-sign"></span>';
                    }
                ],
                //Apellido materno
                [
                    'attribute' => 'maternoalu',
                    'label' => 'A. Materno',
                    'format' => 'html',
                    'value' => function($model){
                        return !empty($model->maternoalu) ? $model->maternoalu : '<span class="glyphicon glyphicon-question-sign"></span>';
                    }
                ],
                //Nombre alumno
                [
                    'attribute' => 'nombrealu',
                    'label' => 'Nombres',
                    'format' => 'html',
                    'value' => function($model){
                        return !empty($model->nombrealu) ? $model->nombrealu : '<span class="glyphicon glyphicon-question-sign"></span>';
                    }
                ]
            ];
        ?>

        <?= GridView::widget([
                'dataProvider'=>$dataProvider,
                'columns'=>$gridColumns,
                'export'=>false,
                'pjax'=>true,
                'emptyText'=>'No hay resultados para este Curso',
                'showPageSummary' => false,
                'panel'=>[
                    'type' => 'primary',
                    'heading' => '<h3 class="panel-title">Listado Curso ' . ' ' . $nomcurso . ' ' . Yii::$app->session->get('nameAno') . '</h3>',
                    'footer' => false
                ]
        ]); ?>
        <?php Pjax::end(); ?>
    </div>

</div>






