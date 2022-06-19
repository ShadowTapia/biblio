<?php
/**
 * Created by PhpStorm.
 * User: chelo
 * Date: 18-07-2021
 * Time: 12:08
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Users;

$this->title = 'Prestar Libro ' . $titulo;
$this->params['breadcrumbs'][]= $this->title;
?>
<?php
$this->registerJs(
    '$("#UserRut").on("change", function(e){
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
<h2>Prestamo Funcionarios <?= Yii::$app->session->get('nameAno') ?></h2>
<?php
    $form=ActiveForm::begin(['method'=>'post','id'=>'formIngFuncionario','class'=>'form-horizontal',
        'enableClientValidation' => false, 'enableAjaxValidation' => true,]);
?>
<div class="container">
    <div class="row">
        <div class="col-sm-5">
            <?= $form->field($modelUser,'UserRut')->dropDownList(Users::getListafuncionarios(),
                ['class'=>'form-control','style'=>'width:100%','prompt'=>'Seleccione Funcionario','id'=>'UserRut'])->label('Funcionario*') ?>
        </div>
    </div>
    <div id="togglesearch" style="display: none" >
        <?= $this->render('_form',['model'=>$model,'modelEjemplar'=>$modelEjemplar]) ?>
    </div>
</div>
<?php $form->end() ?>
