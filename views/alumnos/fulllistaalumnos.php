<?php
/**
 * Created by PhpStorm.
 * User: chelo
 * Date: 31-08-2021
 * Time: 14:25
 */
use app\models\alumnos\AlumnosSearch;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = 'Listado completo de datos de alumnos';
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
    <!-- Genera el formulario de consulta -->
    <?= $this->render('_form',['model' => $model,]) ?>

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
            //Run Alumno
            [
                'attribute' => 'rutalumno',
                'label' => 'RUN',
                'value' => function($model) {
                    return Yii::$app->formatter->asDecimal($model->rutalumno, 0) . "-" . $model->digrut;
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
            //Apellido Paterno
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
            //Sexo
            [
                'attribute' => 'sexo',
                'label' => 'Sexo',
                'format' => 'html',
                'value' => function($model){
                    return !empty($model->sexo) ? $model->sexo : '<span class="glyphicon glyphicon-question-sign"></span>';
                }
            ],
            //Dirección
            [
                'attribute' => 'calle',
                'label' => 'calle',
                'format' => 'html',
                'value' => function($model){
                    return !empty($model->calle) ? $model->calle : '<span class="glyphicon glyphicon-question-sign"></span>';
                }
            ],
            //Telefono
            [
                'attribute' => 'fono',
                'label' => 'fono',
                'format' => 'html',
                'value' => function($model){
                    return !empty($model->fono) ? $model->fono : '<span class="glyphicon glyphicon-question-sign"></span>';
                }
            ],
            //Fecha Nacimiento
            [
                'attribute' => 'fechanac',
                'label' => 'F. Nacimiento',
                'format' => 'html',
                'value' => function($model){
                    return !empty(Yii::$app->formatter->asDate($model->fechanac,'dd/MM/yyyy'))  ? Yii::$app->formatter->asDate($model->fechanac,'dd/MM/yyyy') : '<span class="glyphicon glyphicon-question-sign"></span>';
                }
            ],
            //Edad
            [
                'label' => 'Edad',
                'format' => 'html',
                'value' => function($data){
                    return !empty(AlumnosSearch::CalcularEdad($data->fechanac)) ? AlumnosSearch::CalcularEdad($data->fechanac) : '<span class="glyphicon glyphicon-question-sign"></span>';
                }
            ],
            //Comuna
            [
                'attribute' => 'codComuna',
                'label' => 'Comuna',
                'format' => 'html',
                'value' => function($data){
                    return !empty(AlumnosSearch::getNameComuna($data->codComuna)) ? AlumnosSearch::getNameComuna($data->codComuna) : '<span class="glyphicon glyphicon-question-sign"></span>';
                }
            ],
            //Fono
            [
                'attribute' => 'nro',
                'label' => 'Nro',
                'format' => 'html',
                'value' => function($model){
                    return !empty($model->nro) ? $model->nro : '<span class="glyphicon glyphicon-question-sign"></span>';
                }
            ],
            //Depto
            [
                'attribute' => 'depto',
                'label' => 'Depto',
                'format' => 'html',
                'value' => function($model){
                    return !empty($model->depto) ? $model->depto : '<span class="glyphicon glyphicon-question-sign"></span>';
                }
            ],
            //Población
            [
                'attribute' => 'villa',
                'label' => 'Población',
                'format' => 'html',
                'value' => function($model){
                    return !empty($model->villa) ? $model->villa : '<span class="glyphicon glyphicon-question-sign"></span>';
                }
            ],
            //Email
            [
                'attribute' => 'email Alumno',
                'label' => 'Email',
                'format' => 'html',
                'value' => function($model){
                    return !empty($model->email) ? $model->email : '<span class="glyphicon glyphicon-question-sign"></span>';
                }
            ],
            //Run Apoderado
            [
                'label' => 'Run Apoderado',
                'format' => 'html',
                'value' => function($data){
                    return !empty(AlumnosSearch::getRunapoTrigger($data->idalumno)) ? AlumnosSearch::getRunapoTrigger($data->idalumno) : '<span class="glyphicon glyphicon-question-sign"></span>';
                }
            ],
            //Nombre Apoderado
            [
                'label' => 'Nombre Apoderado',
                'format' => 'html',
                'value' => function($data){
                    return !empty(AlumnosSearch::getNombreTrigger($data->idalumno)) ? AlumnosSearch::getNombreTrigger($data->idalumno) : '<span class="glyphicon glyphicon-question-sign"></span>';
                }
            ],
            //Mail apoderado
            [
                'label' => 'E-mail Apoderado',
                'format' => 'html',
                'value' => function($data){
                    return !empty(AlumnosSearch::getMailTrigger($data->idalumno)) ? AlumnosSearch::getMailTrigger($data->idalumno) : '<span class="glyphicon glyphicon-question-sign"></span>';
                }
            ],
            //Fono
            [
                'label' => 'Fono',
                'format' => 'html',
                'value' => function($data){
                    return !empty(AlumnosSearch::getFonoTrigger($data->idalumno)) ? AlumnosSearch::getFonoTrigger($data->idalumno) : '<span class="glyphicon glyphicon-question-sign"></span>';
                }
            ],
            //Celular
            [
                'label' =>  'Celular',
                'format' => 'html',
                'value' => function($data){
                    return !empty(AlumnosSearch::getCelularTrigger($data->idalumno)) ? AlumnosSearch::getCelularTrigger($data->idalumno) : '<span class="glyphicon glyphicon-question-sign"></span>';
                }
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

        <?php Pjax::end(); ?>
    </div>
</div>
