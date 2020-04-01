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
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Por favor completa los siguientes campos para ingresar:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form', 
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-md-2\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],            
    ]); ?>
        
        <?= $form->field($model, 'userrun')->widget(\yii\widgets\MaskedInput::className(),['mask'=>'99.999.999-*',],['autofocus'=>true])->label('RUN') ?>
        <?= $form->field($model, 'password')->passwordInput()->label(utf8_encode('Contrase�a')) ?>

        <?= $form->field($model, 'rememberMe')->checkbox([
            'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
        ])->label('Recuerdame') ?>

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
