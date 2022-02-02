<?php
/**
 * Created by PhpStorm.
 * User: chelo
 * Date: 19-05-2021
 * Time: 0:02
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\docente\Docente;

$this->title = 'Prestar Libro ' . $titulo;
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
$this->registerJs(
    '$("#rutdocente").on("change", function(e){
                 var x = document.getElementById("togglesearch");
                 if(x.style.display==="none"){
                       x.style.display="block";
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
<h1><?= Html::encode($this->title) ?></h1>
<h2>Prestamo a Profesores <?= Yii::$app->session->get('nameAno') ?></h2>
<?php $form=ActiveForm::begin(['method'=>'post', 'id'=>'formIngProfesor', 'class'=>'form-horizontal',
    'enableClientValidation' => false, 'enableAjaxValidation' => true,]);
?>
<div class="container">
    <div class="row">
        <div class="col-sm-5">
            <?= $form->field($modelProfesor,'rutdocente')->dropDownList(Docente::getListdocentes(),
                ['class'=> 'form-control', 'style' => 'width:100%;','prompt'=> 'Seleccione Docente', 'id' => 'rutdocente'])->label('Docente*') ?>
        </div>
    </div>
    <div id="togglesearch" style="display: none" >
        <?= $this->render('_form',['model'=>$model,'modelEjemplar'=>$modelEjemplar]) ?>
    </div>
</div>
<?php $form->end() ?>
