<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use app\models\alumnos\AlumnosSearch;

/* @var $this yii\web\View */
/* @var $model app\models\alumnos\Alumnos */

?>
<div class="alumnos-view">

       <?= DetailView::widget([
        'model' => $model,
        'condensed' => true,
        'hover' => true,
        'enableEditMode' => false,
        'mode' => DetailView::MODE_VIEW,
        'fadeDelay' => 6,
        'panel' => [
            'type' => DetailView::TYPE_INFO,
            'heading' => '<i class="glyphicon glyphicon-user"></i> '. $model->nombrealu . " " . $model->paternoalu . " " . $model->maternoalu
        ],
        'attributes' => [
                [
                    'group' => true,
                    'label' => 'Sección 1: Datos',
                    'rowOptions' => ['class' => 'table-info']
                ],
                [
                    'columns' => [
                            [
                                'attribute' => 'rutalumno',
                                'format' => 'raw',
                                'label' => 'RUN',
                                'value' => '<kbd>' .Yii::$app->formatter->asDecimal($model->rutalumno,0). '-'. $model->digrut. '</kbd>',
                                'displayOnly' => true,
                                'valueColOptions' => ['style' => 'width:30%']
                            ],
                            [
                                'attribute' => 'name',
                                'label' => 'Curso',
                                'valueColOptions' => ['style' => 'width:30%'],
                                'value' => $name,
                            ],
                    ],
                ],
                [
                        'columns' => [
                            [
                                'attribute' => 'calle',
                                'label' => 'Dirección',
                                'format' => 'html',
                                'valueColOptions' => ['style' => 'width:60%'],
                                'value' => $model->calle ? $model->calle : '<span class="glyphicon glyphicon-question-sign"></span>',
                            ],
                        ],
                ],
                [
                        'columns' => [
                            [
                                'attribute' => 'nro',
                                'label' => 'Nro.',
                                'format' => 'html',
                                'valueColOptions' => ['style' => 'width:30%'],
                                'value' => $model->nro ? $model->nro : '<span class="glyphicon glyphicon-question-sign"></span>',
                            ],
                            [
                                'attribute' => 'depto',
                                'label' => 'Depto',
                                'format' => 'html',
                                'valueColOptions' => ['style' => 'width:30%'],
                                'value' => $model->depto ? $model->depto : '<span class="glyphicon glyphicon-question-sign"></span>',
                            ],
                        ],
                ],
                [
                        'columns' => [
                            [
                                'attribute' => 'block',
                                'label' => 'Block',
                                'format' => 'html',
                                'valueColOptions' => ['style' => 'width:30%'],
                                'value' => $model->block ? $model->block : '<span class="glyphicon glyphicon-question-sign"></span>',
                            ],
                            [
                                'attribute' => 'villa',
                                'label' => 'Villa',
                                'format' => 'html',
                                'valueColOptions' => ['style' => 'width:30%'],
                                'value' => $model->villa ? $model->villa : '<span class="glyphicon glyphicon-question-sign"></span>',
                            ],
                        ],
                ],
                [
                        'columns' => [
                            [
                                'attribute' => 'codRegion',
                                'label' => 'Region',
                                'valueColOptions' => ['style' => 'width:30%'],
                                'value' => $model->codRegion ? $model->codRegion0->region : "",
                            ],
                            [
                                'attribute' => 'idProvincia',
                                'label' => 'Provincia',
                                'valueColOptions' => ['style' => 'width:30%'],
                                'value' => $model->idProvincia ? $model->idProvincia0->Provincia : "",
                            ],
                        ],
                ],
                [
                        'columns' => [
                            [
                                'attribute' => 'codComuna',
                                'label' => 'Comuna',
                                'valueColOptions' => ['style' => 'width:30%'],
                                'value' => $model->codComuna ? $model->codComuna0->comuna : "",
                            ],
                            [
                                'attribute' => 'email',
                                'label' => 'E-Mail',
                                'format' => 'html',
                                'valueColOptions' => ['style' => 'width:30%'],
                                'value' => $model->email ? $model->email : '<span class="glyphicon glyphicon-question-sign"></span>',
                            ],
                        ],
                ],
                [
                        'columns' => [
                            [
                                'attribute' => 'fono',
                                'label' => 'Teléfono',
                                'format' => 'html',
                                'valueColOptions' => ['style' => 'width:30%'],
                                'value' => $model->fono ? $model->fono : '<span class="glyphicon glyphicon-question-sign"></span>',
                            ],
                            [
                                'attribute' => 'fechanac',
                                'label' => 'F. Nacimiento',
                                'format' => 'html',
                                'valueColOptions' => ['style' => 'width:30%'],
                                'value' => Yii::$app->formatter->asDate($model->fechanac,'dd/MM/yyyy') ? Yii::$app->formatter->asDate($model->fechanac,'dd/MM/yyyy') : '<span class="glyphicon glyphicon-question-sign"></span>',
                            ],
                        ],
                ],
                [
                        'columns' => [
                            [
                                'attribute' => 'nacionalidad',
                                'label' => 'Nacionalidad',
                                'format' => 'html',
                                'valueColOptions' => ['style' => 'width:30%'],
                                'value' => (($model->nacionalidad ==1) ? 'Chilena' : (($model->nacionalidad ==2) ? 'Extranjero(a)' : '<span class="glyphicon glyphicon-question-sign"></span>')),
                            ],
                            [
                                'attribute' => 'fechaing',
                                'label' => 'F. Ingreso',
                                'valueColOptions' => ['style' => 'width:30%'],
                                'value' => Yii::$app->formatter->asDate($model->fechaing,'dd/MM/yyyy')  ? Yii::$app->formatter->asDate($model->fechaing,'dd/MM/yyyy') : "",
                            ],
                        ],
                ],
                [
                        'columns' => [
                            [
                                'attribute' => 'edad',
                                'label' => 'Edad',
                                'valueColOptions' => ['style' => 'width:30%'],
                                'value' => AlumnosSearch::CalcularEdad($model->fechanac) . ' años.',
                            ],
                            [
                                'attribute' => 'sexo',
                                'format' => 'text',
                                'label' => 'Sexo',
                                'displayOnly' => true,
                                'value' => ($model->sexo == 'M')? "Masculino":"Femenino",
                                'valueColOptions' => ['style' => 'width:30%']
                            ],
                        ],
                ],
                [
                        'columns' => [
                            [
                                'attribute' => 'sangre',
                                'label' => 'Grupo Sangre',
                                'format' => 'html',
                                'valueColOptions' => ['style' => 'width:30%'],
                                'value' => function($model){
                                    return !empty($model->sangre) ? $model->sangre : '<span class="glyphicon glyphicon-question-sign"></span>';
                                }
                            ],
                            [
                                'attribute' => 'enfermedades',
                                'label' => 'Enfermedades',
                                'format' => 'html',
                                'valueColOptions' => ['style' => 'width:30%'],
                                'value' => function($model){
                                    return !empty($model->enfermedades) ? $model->enfermedades : '<span class="glyphicon glyphicon-question-sign"></span>';
                                }
                            ],
                        ],
                ],
                [
                        'columns' => [
                            [
                                'attribute' => 'alergias',
                                'label' => 'Alergias',
                                'format' => 'html',
                                'valueColOptions' => ['style' => 'width:30%'],
                                'value' => function($model){
                                    return !empty($model->alergias) ? $model->alergias : '<span class="glyphicon glyphicon-question-sign"></span>';
                                }
                            ],
                            [
                                'attribute' => 'medicamentos',
                                'label' => 'Medicamentos',
                                'format' => 'html',
                                'valueColOptions' => ['style' => 'width:30%'],
                                'value' => function($model){
                                    return !empty($model->medicamentos) ? $model->medicamentos : '<span class="glyphicon glyphicon-question-sign"></span>';
                                }
                            ],
                        ],
                ],
                [
                        'columns' => [
                            [
                                'attribute' => 'fecharet',
                                'label' => 'F. Retiro',
                                'format' => 'html',
                                'valueColOptions' => ['style' => 'width:30%'],
                                'value' => Yii::$app->formatter->asDate($model->fecharet,'dd/MM/yyyy') ? Yii::$app->formatter->asDate($model->fecharet,'dd/MM/yyyy') : '<span class="glyphicon glyphicon-question-sign"></span>',
                            ],
                        ],
                ],
        ],
    ]) ?>
       <?php
            $gridColumns = [
                [
                    'class' => 'yii\grid\SerialColumn',
                    'headerOptions' => ['width' => '20px'],
                    'header' => 'N°',
                    'contentOptions' => ['style' => 'width: 20px;', 'class' => 'text-center'],
                ],
                //Run Apoderado
                [
                    'attribute' => 'rutapo',
                    'label' => 'RUN',
                    'format' => 'html',
                    'headerOptions' => ['width' => '100px'],
                    'value' => function($model) {
                        return Yii::$app->formatter->asDecimal($model->rutapo, 0) . "-" . $model->digrut;
                    }
                ],
                //Nombre de alumno
                [
                    'attribute' => 'nombreapo',
                    'label' => 'Nombre',
                    'format' => 'html',
                    'headerOptions' => ['width' => '200px'],
                    'value' => function($model){
                        return $model->nombreapo. ' ' . $model->apepat. ' ' . $model->apemat;
                    }
                ],
                //Relación
                [
                    'attribute' => 'relacion',
                    'label' => 'Relación',
                    'format' => 'html',
                    'headerOptions' => ['width' => '120px'],
                    'value' => function($model){
                        return $model->relacion;
                    }
                ],
                //Telefonos
                [
                    'attribute' => 'fono',
                    'label' => 'Teléfonos',
                    'format' => 'html',
                    'headerOptions' => ['width' => '170px'],
                    'value' => function($model){
                        return $model->fono. ' ' .$model->celular;
                    }
                ],
                //Email
                [
                    'attribute' => 'email',
                    'label' => 'E-mail',
                    'format' => 'html',
                    'headerOptions' => ['width' => '200px'],
                    'value' => function($model){
                        return $model->email;
                    }
                ]
            ];
       ?>
       <?= GridView::widget([
           'dataProvider' => $dataProvider2,
           'columns' => $gridColumns,
           'export' => false,
           'emptyText' => 'No hay Apoderados registrados.-',
           'showPageSummary' => false,
           'panel' => [
               'type' => 'success',
               'heading' => '<h3 class="panel-title">Familiares Asociados ' . '</h3>',
           ]
       ]); ?>

</div>
