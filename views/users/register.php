<?php

/**
 * @author Marcelo
 * @copyright 2019
 */

use app\models\Roles;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Ingresar Usuario';
$this->params['breadcrumbs'][] = ['label' => 'Administrar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<h1><?= Html::encode($this->title) ?></h1>

<?php $form = ActiveForm::begin([
    'method' => 'post', 'id' => 'formulario', 'class' => 'form-horizontal',
    'enableClientValidation' => false, 'enableAjaxValidation' => true,
]);
?>

<table>
    <tr>
        <td style="padding: 15px;"><?= $form->field($model, "UserRut")->widget(\yii\widgets\MaskedInput::class, ['mask' => '99.999.999-*',], ['style' => 'width:40%'])->label('RUN*') ?></td>
        <td style="padding: 15px;"><?= $form->field($model, "UserName")->input("text", ['style' => 'width:100%'])->label('Nombre Usuario*') ?></td>
        <td style="padding: 15px;"> <?= $form->field($model, "UserLastName")->input("text", ['style' => 'width:100%'])->label('Apellido Usuario') ?></td>
        <td style="padding: 15px;"><?= $form->field($model, "UserMail")->input("text", ['style' => 'width:160%'])->label('E-mail Usuario*') ?></td>
    </tr>
    <tr>
        <td style="padding: 15px;"><?= $form->field($model, "idroles")->dropDownList(
                                        ArrayHelper::map(Roles::find()->all(), 'idroles', 'nombre'),
                                        ['prompt' => 'Seleccione Rol']
                                    )->label('Roles') ?></td>
        <td style="padding: 15px;"><?= $form->field($model, "UserPass")->input("password", ['style' => 'width:100%'])->label('Contraseña Usuario*') ?></td>
        <td style="padding: 15px;"><?= $form->field($model, "UserPass_repeat")->input("password", ['style' => 'width:100%'])->label('Repetir Contraseña*') ?></td>
    </tr>
</table>

<?= Html::submitButton("Registrar", ["class" => "btn btn-primary"]) ?>

<?php $form->end() ?>