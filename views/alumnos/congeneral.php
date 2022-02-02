<?php
/**
 * Created by PhpStorm.
 * User: chelo
 * Date: 01-10-2020
 * Time: 13:59
 */

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use app\models\apoderados\ApoderadosSearch;
use app\models\cursos\Cursos;

$this->title = 'Consulta General de Alumnos '. Yii::$app->session->get('nameAno');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="alumnos-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <h6>*No incluye alumnos retirados</h6>
    <?php Pjax::begin(); ?>
    <?php
    $gridColumns = [
        [
            'class' => 'yii\grid\SerialColumn',
            'headerOptions' => ['width' => '20px'],
            'header' => 'N°',
            'contentOptions' => ['style' => 'width: 20px;', 'class' => 'text-center'],
        ],
        [
            'class' => 'kartik\grid\ExpandRowColumn',
            'width' => '50px',
            'value' => function ($model, $key, $index, $column) {
                return GridView::ROW_COLLAPSED;
            },
            'detail' => function($model, $key, $index, $column){
                $Cursox = Cursos::find()->joinWith(['pivots pi'])
                    ->where(['pi.idano' => Yii::$app->session->get('anoActivo')])
                    ->andWhere(['pi.idalumno' => $model->idalumno])
                    ->one();
                $name = $Cursox->Nombre;
                $searchModel = new ApoderadosSearch();
                $searchModel->rutalumno = $model->rutalumno;
                $dataProvider2 = $searchModel->search(Yii::$app->request->queryParams);
                return Yii::$app->controller->renderPartial('view', ['model'=> $model, 'dataProvider2' => $dataProvider2,'name' => $name]);
            },
            'expandOneOnly' => true
        ],
        //Rut alumno
        [
            'attribute' => 'rutalumno',
            'label' => 'RUN',
            'format' => 'html',
            'headerOptions' => ['width' => '120px'],
            'value' => function($model) {
                return Yii::$app->formatter->asDecimal($model->rutalumno, 0) . "-" . $model->digrut;
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
        ],
    ];
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumns,
        'export' => false,
        'pjax' => true,
        'emptyText' => 'No hay Alumnos registrados.-',
        'showPageSummary' => false,
        'layout' => '{pager}', //Con esto logramos que se muestre la paginaciÃ³n
        'panel' => [
            'type' => 'primary',
            'heading' => '<h3 class="panel-title">Listado de Alumnos ' .'</h3>',
        ]
    ]); ?>

    <?php Pjax::end(); ?>

</div>

