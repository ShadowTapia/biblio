<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\cursos\Cursos;
use app\models\docente\Docente;
use app\models\User;
use app\models\Users;
use kartik\depdrop\DepDrop;
use yii\widgets\ActiveForm;
use kartik\switchinput\SwitchInput;


$this->title = "Prestamos de Ejemplares";
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
$script = <<< JS
    $('#rutalumno').on('change',function(e){
        var x = document.getElementById("togglesearch");        
        if(x.style.display==="none"){
            x.style.display="block";    
        }
    });
    $('#rutdocente').on('change',function(e){
        var x = document.getElementById("togglesearch");        
        if(x.style.display==="none"){
            x.style.display="block";    
        }
    });
    $('#rutapo').on('change',function(e){
        var x = document.getElementById("togglesearch");        
        if(x.style.display==="none"){
            x.style.display="block";    
        }
    });
    $('#UserRut').on('change',function(e){
        var x = document.getElementById("togglesearch");        
        if(x.style.display==="none"){
            x.style.display="block";    
        }
    });

    // allows user to set the final place 
    $('input[name="personaje"]').on('switchChange.bootstrapSwitch', function(e, s) {
        
        var w = document.getElementById("divAlumnos");
        var t = document.getElementById("divApoderados");
        var q = document.getElementById("divProfesores");
        var y = document.getElementById("divFuncionarios");          
        if(e.target.value==="1"){
            if(w.style.display==="none"){
                q.style.display="none";
                t.style.display="none";
                w.style.display="block";
                y.style.display="none";
            }
        }
        if(e.target.value==="2")
        {
            if(t.style.display==="none")
            {
                q.style.display="none";
                t.style.display="block";
                w.style.display="none";
                y.style.display="none";
            }
        }
        if(e.target.value==="3")
        {
            if(q.style.display==="none")
            {
                q.style.display="block";
                t.style.display="none";
                w.style.display="none";
                y.style.display="none";
            }
        }
        if(e.target.value==="4")
        {
            if(y.style.display==="none")
            {
                q.style.display="none";
                t.style.display="none";
                w.style.display="none";
                y.style.display="block";               
            }
        }        
    });  

JS;
$position = \yii\web\View::POS_READY;
$this->registerJs($script, $position);
?>
<h1><?= Html::encode($this->title) ?></h1>
<div class="prestamos-div">
    <?php $form = ActiveForm::begin([
        'method' => 'post',
        'id' => 'formPrestamosbarra',
        'class' => 'form-horizontal',
        'enableClientValidation' => false,
        'enableAjaxValidation' => true,
    ]);
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h3><?= $titulo ?></h3>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-3">
                <?= $form->field($modelEjemplar, "idejemplar")
                    ->textInput(['class' => 'form-control', 'placeholder' => 'Ejemplar', 'disabled' => true, 'style' => 'width:100%'])
                    ->label('Código ejemplar') ?>
            </div>
            <div class="col-xs-2">
                <?= $form->field($modelEjemplar, 'norden')
                    ->textInput(['class' => 'form-control', 'placeholder' => 'N° Orden', 'disabled' => true, 'style' => 'width:100%'])
                    ->label("N° orden") ?>
            </div>
            <div class="col-xs-2">
                <?= $form->field($modelEjemplar, "edicion")
                    ->textInput(['class' => 'form-control', 'placeholder' => 'Edición', 'disabled' => true, 'style' => 'width:100%'])
                    ->label("Edición") ?>
            </div>
            <div class="col-xs-3">
                <?= $form->field($modelEjemplar, "ubicacion")
                    ->textInput(['class' => 'form-control', 'placeholder' => 'Ubicación', 'disabled' => true, 'style' => 'width:100%'])
                    ->label("Ubicación") ?>
            </div>
        </div>
        <div class="row">
            <?php echo $modelEjemplar->idLibros0 ?>
        </div>
        <div class="row">
            <div class="col-xs-offset-0">
                <?= SwitchInput::widget([
                    'name' => 'personaje',
                    'type' => SwitchInput::RADIO,
                    'items' => [
                        ['label' => 'Alumno', 'value' => 1],
                        ['label' => 'Apoderado', 'value' => 2],
                        ['label' => 'Docente', 'value' => 3],
                        ['label' => 'Funcionario', 'value' => 4],
                    ],
                    'pluginOptions' => ['size' => 'mini'],
                    'labelOptions' => ['style' => 'font-size:12px'],
                ]); ?>
            </div>
        </div>
        <div id="divAlumnos" style="display: none;" class="row">
            <h2>Prestamo para Alumnos <?= Yii::$app->session->get('nameAno') ?></h2>
            <div class="row">
                <div class="row">
                    <div class="col-xs-2">
                        <?= Html::label('Curso') ?>
                    </div>
                </div>
                <div class="col-xs-4">
                    <?= Html::dropDownList('idCurso', null,  ArrayHelper::map(Cursos::find()->where(['visible' => '1'])->indexBy('idCurso')->orderBy('Orden')->all(), 'idCurso', 'Nombre'), ['id' => 'curAlu']) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-5">
                    <?= $form->field($modelAlumno, 'rutalumno')->widget(DepDrop::class, [
                        'options' => ['id' => 'rutalumno', 'prompt' => 'Seleccione Alumno(a)'],
                        'pluginOptions' => [
                            'depends' => ['curAlu'],
                            'placeholder' => 'Seleccione Alumno(a)',
                            'url' => Url::to(['prestamos/lista_alumnos']),
                            'loadingText' => 'Cargando Alumnos...',
                        ]
                    ])->label('Alumnos*') ?>
                </div>
            </div>
        </div>
        <div id="divApoderados" style="display: none;" class="row">
            <h2>Prestamo para Apoderados <?= Yii::$app->session->get('nameAno') ?></h2>
            <div class="row">
                <div class="row">
                    <div class="col-xs-2">
                        <?= Html::label('Curso') ?>
                    </div>
                </div>
                <div class="col-xs-4">
                    <?= Html::dropDownList('idCurso', null,  ArrayHelper::map(Cursos::find()->where(['visible' => '1'])->indexBy('idCurso')->orderBy('Orden')->all(), 'idCurso', 'Nombre'), ['id' => 'curApo']) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-5">
                    <?= $form->field($modelApoderado, 'rutapo')->widget(DepDrop::class, [
                        'options' => ['id' => 'rutapo', 'prompt' => 'Seleccione Apoderado(a)'],
                        'pluginOptions' => [
                            'depends' => ['curApo'],
                            'placeholder' => 'Seleccione Apoderado(a)',
                            'url' => Url::to(['prestamos/lista_apoderados']),
                            'loadingText' => 'Cargando Apoderados...',
                        ]
                    ])->label('Apoderados*') ?>
                </div>
            </div>
        </div>
        <div id="divProfesores" style="display: none;" class="row">
            <h2>Prestamo para Docentes <?= Yii::$app->session->get('nameAno') ?></h2>
            <div class="row">
                <div class="col-sm-5">
                    <?= $form->field($modelProfesor, 'rutdocente')->dropDownList(
                        Docente::getListdocentes(),
                        ['class' => 'form-control', 'style' => 'width:100%;', 'prompt' => 'Seleccione Docente', 'id' => 'rutdocente']
                    )->label('Docente*') ?>
                </div>
            </div>
        </div>
        <div id="divFuncionarios" style="display: none;" class="row">
            <div class="row">
                <div class="col-sm-5">
                    <?= $form->field($modelUser, 'UserRut')->dropDownList(
                        Users::getListafuncionarios(),
                        ['class' => 'form-control', 'style' => 'width:100%;', 'prompt' => 'Seleccione Funcionario', 'id' => 'UserRut']
                    )->label('Funcionarios*') ?>
                </div>
            </div>
        </div>
        <!-- display general para todos los usuarios    -->
        <div id="togglesearch" style="display: none">
            <?= $this->render('_form', ['model' => $model, 'modelEjemplar' => $modelEjemplar]) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>