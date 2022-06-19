<?php
/**
 * Created by PhpStorm.
 * User: chelo
 * Date: 08-07-2020
 * Time: 12:58
 */

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;
use app\models\cursos\Cursos;


$this->title='Listado de alumnos para promoción';
$this->params['breadcrumbs'][]=$this->title;
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
    <h6>*No Incluye alumnos retirados</h6>
    <!-- Renderizamos el combo de consulta -->
    <?= $this->render('_form',['model' => $model,]) ?>

    <div id="toggleSearch">
        <?php Pjax::begin([
            'id' => 'alumnos',
            'timeout' => false,
            'enablePushState' => false,
            'clientOptions' => ['method' => 'POST']
        ]); ?>
        <?= $form = Html::beginForm(['pivot/promocion']); ?>
        <?= GridView::widget([
            'id' => 'gridpromo',
            'caption' => 'Listado' . " " . $nomcurso . " " . Yii::$app->session->get('nameAno'),
            'captionOptions' => [
                    'class' => 'text-center',
                    'style' => 'font-size: 18px;font-bold: true;'
            ],
            'dataProvider' => $dataProvider,
            'summary' => "",
            'tableOptions' => ['class' => 'table table-bordered table-hover table-condensed table-striped table-primary'],
            'columns' => [
                [
                    'class' => 'yii\grid\SerialColumn',
                    'header'=>'',
                    'headerOptions' => ['width' => '20px'],
                    'contentOptions' => ['style' => 'width: 20px;', 'class' => 'text-center'],
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
                    'class' => 'yii\grid\CheckboxColumn',
                    'checkboxOptions'=>function($d)
                    {
                        return ['value' => $d['idalumno']];
                    }
                ],
            ],
        ]); ?>
        <div class="row">
            <div class="col-xs-2">
                <?= Html::dropDownList('idCurso',null,Cursos::getListCursos(),[
                    'onchange' => 'this.form.submit()',
                    'prompt' => 'Curso Destino',
                    'class' => 'form-control'
                ]) ?>
            </div>
        </div>
        <?php
            Html::endForm();
        ?>
        <?php Pjax::end(); ?>
    </div>
</div>
