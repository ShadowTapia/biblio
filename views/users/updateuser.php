<?php
/* @var $this yii\web\View */

/**
 * @author Marcelo
 * @copyright 2019
 */

use app\models\Roles;
use kartik\switchinput\SwitchInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


$this->title = 'Actualizar Usuario';
$this->params['breadcrumbs'][] = ['label' => 'Administrar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<h1><?= $this->title ?></h1>

<?php $form = ActiveForm::begin([
    'method' => 'post',
    'enableClientValidation' => true,
]);
?>
<div class="row">
    <div class="form-group col-xs-4">
        <?= $form->field($model, "UserName")->input("text", ['width:450px;'])->label('Nombre Usuario') ?>
    </div>
    <div class="form-group col-xs-4">
        <?= $form->field($model, "UserLastName")->input("text", ['width:450px;'])->label('Apellido Usuario') ?>
    </div>
    <div class="form-group col-xs-4">
        <?= $form->field($model, "UserMail")->input("text", ['width:450px'])->label('Email Usuario') ?>
    </div>
</div>
<div class="row">
    <div class="form-group col-xs-4">
        <?=
        $form->field($model, "idroles")->dropDownList(
            ArrayHelper::map(Roles::find()->all(), 'idroles', 'nombre')
        )->label('Roles')
        ?>
    </div>
    <div class="col-xs-offset-0">
        <?= $form->field($model, "activate")->widget(
            SwitchInput::class,
            [
                'type' => SwitchInput::CHECKBOX, 'pluginOptions' =>
                [
                    'handleWidth' => 20,
                    'onText' => '<i class="glyphicon glyphicon-ok"></i>',
                    'offText' => '<i class="glyphicon glyphicon-remove"></i>',
                    'onColor' => 'success',
                    'offColor' => 'danger',
                ],
            ]
        )->label('Activo') ?>
    </div>
</div>
<div class="row">
    <?= Html::submitButton('Modificar', ['class' => 'btn btn-primary']) ?>
</div>
<?php $form->end() ?>