<?php
/* @var $this yii\web\View */

/**
 * @author Marcelo
 * @copyright 2019
 */

use kartik\spinner\Spinner;
use kartik\switchinput\SwitchInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Actualizar Años';
$this->params['breadcrumbs'][] = ['label' => 'Administrar Años', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= $this->title ?></h1>

<div id="well" style="display: none">
    <?= Spinner::widget([
        'preset' => Spinner::LARGE,
        'color' => 'blue',
        'align' => 'center'
    ]);
    ?>
</div>

<?php $form = ActiveForm::begin([
    'options' => [
        'id' => 'form_up',
    ],
]);
?>
<div class="container">
    <div class="row">
        <div class="col-xs-2">
            <?= $form->field($model, "nombreano")->input("text", ['width:450px;'])->label('Año*') ?>
        </div>
        <div class="col-xs-offset-0">
            <?= $form->field($model, "activo")->widget(
                SwitchInput::class,
                [
                    'type' => SwitchInput::CHECKBOX, 'pluginOptions' =>
                    [
                        'size' => 'small',
                        'onText' => '<i class="glyphicon glyphicon-ok"></i>',
                        'offText' => '<i class="glyphicon glyphicon-remove"></i>',
                        'onColor' => 'success',
                        'offColor' => 'danger',
                    ],
                ]
            )->label('Activo') ?>
        </div>

        <div class="col-ms-2">
            <?= Html::submitButton('Modificar', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>