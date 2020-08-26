<?php
/**
 * Created by PhpStorm.
 * User: chelo
 * Date: 20-06-2020
 * Time: 17:38
 */

use app\models\alumnos\AlumnosSearch;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use kartik\spinner\Spinner;
use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = 'Listado de Alumnos con Apoderados';
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

    <!-- Genera el formulario de consulta -->
    <?= $this->render('_form',['model' => $model,]) ?>

    <div id="well" style="display: none">
        <?= Spinner::widget([
            'preset' => Spinner::LARGE,
            'color' => 'blue',
            'align' => 'center'
        ]);
        ?>
    </div>

    <div id="toggleSearch" style="display: none">
        <?php Pjax::begin([
            'id' => 'alumnos',
            'timeout' => false,
            'enablePushState' => false,
            'clientOptions' => ['method' => 'GET']
        ]); ?>

        <?php
            $gridColumns = [
                [
                    'class' => 'yii\grid\SerialColumn'
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
                    'label' => 'Nombre Apoderado',
                    'format' => 'html',
                    'value' => function($data){
                        return !empty(AlumnosSearch::getNombreTrigger($data->idalumno)) ? AlumnosSearch::getNombreTrigger($data->idalumno) : '<span class="glyphicon glyphicon-question-sign"></span>';
                    },
                ]
            ];

            $gridexportMenu = ExportMenu::widget([
                'dataProvider' => $dataProvider,
                'columns' => $gridColumns,
                'target' => ExportMenu::TARGET_BLANK,
                'pjaxContainerId' => 'kv-pjax-container',
                'exportContainer' => [
                    'class' => 'btn-group mr-2'
                ],
                'dropdownOptions' => [
                        'label' => 'Exportar',
                        'class' => 'btn btn-outline-secondary',
                        'itemsBefore' => [
                            '<div class="dropdown-header">Exporta todo los datos</div>',
                        ],
                ],
                //Elegimos los tipos de exportación admitidos
                'exportConfig' => [
                        ExportMenu::FORMAT_HTML => false,
                        ExportMenu::FORMAT_TEXT => false,
                ],
            ]);

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
            'toolbar' => [
                    $gridexportMenu,
            ],
            'panel' => [
                    'type' => 'primary',
                    'heading' => '<h3 class="panel-title">Listado Curso ' . ' ' . $nomcurso . ' ' . Yii::$app->session->get('nameAno') . '</h3>',
                    'footer' => false
            ]
        ]); ?>
    </div>

</div>
