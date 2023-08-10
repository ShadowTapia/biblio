<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Ingreso Sistema';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Login</h4>
        </div>
        <div class="modal-body">
            <div class="site-login">
                <h1><?= Html::encode($this->title) ?></h1>

                <p>Por favor completa los siguientes campos para ingresar:</p>

                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'layout' => 'horizontal',
                ]); ?>
                <div class="row">
                    <div class="col-md-7">
                        <?= $form->field($model, 'userrun')->widget(\yii\widgets\MaskedInput::class, ['mask' => '99.999.999-*',], ['autofocus' => true])->label('RUN') ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-7">
                        <?= $form->field($model, 'password')->passwordInput()->label('Contraseña') ?>
                    </div>
                </div>

                <!-- <?= $form->field($model, 'rememberMe')->checkbox([
                            'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
                        ])->label('Recuerdame') ?> -->

                <div class="form-group">
                    <div class="col-lg-offset-1 col-lg-11">
                        <?= Html::submitButton('Ingresar', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-lg-offset-1 col-lg-11">
                        <a href="<?= Url::toRoute('site/recoverpass') ?>">Recuperar Acceso</a>
                    </div>
                </div>


                <?php ActiveForm::end(); ?>


            </div>
        </div>
    </div>
</div>