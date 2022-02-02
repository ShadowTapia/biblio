<?php
/**
 * Created by PhpStorm.
 * User: chelo
 * Date: 03-06-2021
 * Time: 0:22
 */
use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\spinner\Spinner;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use app\models\apoderados\ApoderadosSearch;

$this->title = 'Listado de Apoderados';
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
<div class="apoderados-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('/alumnos/_form', ['model'=> $model,]) ?>
    <div id="well" style="display: none">
        <?= Spinner::widget([
            'preset' => Spinner::LARGE,
            'color' => 'blue',
            'align' => 'center'
        ]);
        ?>
    </div>
    <div id="toggleSearch" style="display: none">
        <?php
            Pjax::begin([
                'id'=>'alumnos',
                'timeout'=>false,
                'enablePushState'=>false,
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
                //Teléfono
                [
                    'attribute' => 'fono',
                    'label' => 'Teléfono',
                    'format' => 'html',
                    'value' => function($model){
                        return !empty($model->fono) ? $model->fono : '<span class="glyphicon glyphicon-question-sign"></span>';
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
                //Alumno
                [
                    'label' => 'Nombre Alumno',
                    'format' => 'html',
                    'value' => function($data){
                        return !empty(ApoderadosSearch::getNameTrigger($data->rutalumno)) ? ApoderadosSearch::getNameTrigger($data->rutalumno) : '<span class="glyphicon glyphicon-question-sign"></span>';
                    }
                ],
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
                        '<div class="dropdown-header">Exporta todos los datos</div>',
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
        <?php Pjax::end(); ?>
  </div>
</div>
