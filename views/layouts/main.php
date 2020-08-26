<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use app\widgets\Alert;
use kartik\nav\NavX;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">  
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
       NavBar::begin([
        'brandLabel' => '<img src='. Yii::$app->request->baseUrl . "/images/logo.gif" .' style="margin-top: -10px;" class="img-responsive"></img>',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]); 
       echo NavX::widget([
        'options' => ['class' => 'nav navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Inicio', 'url' => ['/site/index']],
            //Begin Menu Libros
            ['label' => 'Libros',
                'items' => [
                        ['label' => 'Libro', 'url' => ['/libros/index']],
                        ['label' => 'Ejemplares', 'url' => ['/ejemplar/index']],
                        ['label' => 'Autor', 'url' => ['/autor/index']],
                        ['label' => 'Categorías', 'url' => ['/categorias/index']],
                        ['label' => 'Editorial','url'=> ['/editorial/index']],
                        ['label' => 'Temas','url' => ['/temas/index']],
                ],
            ],
            //End Menu Libros
            //Begin Menu Alumnos
            ['label' => 'Alumnos',
                'items' => [
                    ['label' => 'Ingresar', 'url' => ['/alumnos/ingresaalu']],
                    ['label' => 'Consultar',
                        'items' => [
                           ['label' => 'Por Curso','url' => ['/alumnos/cursoalumnos']],
                           ['label' => 'L. con Apoderados','url'=>['/alumnos/listadoalumnosapos']],
                        ]],
                    ['label' => 'Modificar',
                        'items' => [
                            ['label' => 'Asignar curso', 'url' => ['/alumnos/asignar']],
                            ['label' => 'Cambiar de Curso', 'url' => ['/alumnos/listacambiocurso']],
                            ['label' => 'Asignar Apoderados', 'url' => ['/alumnos/relacionapos']],
                            ['label' => 'Promoción','url' => ['/alumnos/listapromocion']],
                            ['label' => 'Datos', 'url' => ['#']],
                        ],
                    ],
                ],
            ],
            //End Menu Alumnos
            //Begin Menu opciones
            ['label' => 'Opciones',
                'items' => [
                    ['label' => 'Años',
                        'items' => [
                            ['label' => 'Seleccionar','url' => ['/anos/selectano'],'visible'=>Yii::$app->session['adminUser']=='admin'],
                            ['label' => 'Administrar','url' => ['/anos/index'],'visible'=>Yii::$app->session['adminUser']=='admin'],  
                        ],  
                    ],
                    ['label' => 'Cursos',
                        'items' => [
                            ['label' => 'Administrar','url' => ['/cursos/index'],],
                            
                        ],'visible'=>Yii::$app->session['adminUser']=='admin'
                    ],
                    ['label' => 'Roles', 'url' => ['/roles/index'],'visible'=>Yii::$app->session['adminUser']=='admin'],
                    ['label' => 'Usuarios',
                        'items' => [
                            ['label' => 'Administrar','url'=>['/users/index']],
                            ['label' => 'Docentes','url' => ['/docente/indexdocente']],
                        ],'visible'=>Yii::$app->session['adminUser']=='admin'
                    ],
                    ['label' => 'Localidades',
                        'items' => [
                              ['label' => 'Regiones','url' => ['/region/create']],                              
                              ['label' => 'Provincias','url' => ['/provincias/index']],                                  
                              ['label' => 'Comunas','url' => ['/comunas/index']]       
                        ],'visible'=>Yii::$app->session['adminUser']=='admin'
                    ],                      
                    ],               
            ],
            //End Menu opciones
            //Begin Menu Actualizar
            ['label' => 'Actualizar',
                        'items' => [
                            ['label' => 'Contraseña','url'=> ['/users/changepass']],
                            ['label' => 'Correo','url'=>['/users/changedatos']],
            ],'visible'=>!Yii::$app->user->isGuest],
            //Fin menu Actualizar            
            ['label' => 'Contactar', 'url' => ['/site/contact']],
            Yii::$app->user->isGuest ? (
                ['label' => 'Ingresar', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Salir (' . Yii::$app->user->identity->UserName . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
        ]);
        NavBar::end();
     ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Yii::$app->params["title"] ?> <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
