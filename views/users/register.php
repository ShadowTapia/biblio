<?php

/**
 * @author Marcelo
 * @copyright 2019
 */

use app\models\Roles;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

$this->title='Ingresar Usuario';
$this->params['breadcrumbs'][] = ['label' => 'Administrar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<h1><?= Html::encode($this->title) ?></h1>

<?php $form = ActiveForm::begin(['method' => 'post', 'id' => 'formulario', 'class' => 'form-horizontal', 
'enableClientValidation' => false, 'enableAjaxValidation' => true, ]);
?>
<div class="container">
    <div class="row">
        <div class="col-xs-2">
            <?= $form->field($model,"UserRut")->widget(MaskedInput::className(),['mask'=>'99.999.999-*',])->label('RUN*') ?>
        </div>
        <div class="col-xs-3">
            <?= $form->field($model, "UserName")->input("text",['style'=>'width:100%'])->label('Nombre Usuario*') ?>
        </div>
        <div class="col-xs-3">
            <?= $form->field($model, "UserLastName")->input("text",['style'=>'width:100%'])->label('Apellido Usuario') ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, "UserMail")->input("text",['style'=>'width:160%'])->label('E-mail Usuario*') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-3">
            <?= $form->field($model,"idroles")->dropDownList(
                ArrayHelper::map(Roles::find()->all(),'idroles','nombre'),
                ['prompt'=>'Seleccione Rol']
            )->label('Roles') ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model,"UserPass")->input("password",['style'=>'width:100%'])->label('Contraseña Usuario*') ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model,"UserPass_repeat")->input("password",['style'=>'width:100%'])->label('Repetir Contraseña*') ?>
        </div>
    </div>
    <div class="row" style="text-align: center">
        <?= Html::submitButton("Registrar", ["class" => "btn btn-primary"]) ?>
    </div>
</div>
<?php $form->end() ?> 
