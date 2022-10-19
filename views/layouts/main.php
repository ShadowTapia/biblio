<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use kartik\nav\NavX;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use bluezed\scrollTop\ScrollTop;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <? if (!Yii::$app->user->isGuest) { ?>
        <meta http-equiv="refresh" content="<?php echo Yii::$app->params['sessionTimeoutSeconds']; ?>;" />
    <? } ?>
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
    <?php $this->beginBody() ?>
    <?= ScrollTop::widget() ?>
    <div class="wrap">
        <?php
        NavBar::begin([
            'brandLabel' => '<img src=' . Yii::$app->request->baseUrl . "/images/logo.gif" . ' style="margin-top: -10px;" class="img-responsive"></img>',
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]);
        echo NavX::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                ['label' => 'Inicio', 'url' => ['/site/index']],

                (!Yii::$app->user->isGuest) ? (
                    //Begin Menu Libros
                    [
                        'label' => 'Libros',
                        'items' => [
                            ['label' => 'Libro', 'url' => ['/libros/index'], 'visible' => Yii::$app->session['biblioUser'] == 'biblio' || Yii::$app->session['adminUser'] == 'admin'],
                            ['label' => 'Autor', 'url' => ['/autor/index'], 'visible' => Yii::$app->session['biblioUser'] == 'biblio' || Yii::$app->session['adminUser'] == 'admin'],
                            ['label' => 'Categorías', 'url' => ['/categorias/index'], 'visible' => Yii::$app->session['biblioUser'] == 'biblio' || Yii::$app->session['adminUser'] == 'admin'],
                            ['label' => 'Editorial', 'url' => ['/editorial/index'], 'visible' => Yii::$app->session['biblioUser'] == 'biblio' || Yii::$app->session['adminUser'] == 'admin'],
                            ['label' => 'Ejemplares', 'url' => ['/ejemplar/index'], 'visible' => Yii::$app->session['biblioUser'] == 'biblio' || Yii::$app->session['adminUser'] == 'admin'],
                            ['label' => 'Reservas', 'url' => ['/reserva/index'], 'visible' => Yii::$app->session['biblioUser'] == 'biblio' || Yii::$app->session['adminUser'] == 'admin'],
                            ['label' => 'Temas', 'url' => ['/temas/index'], 'visible' => Yii::$app->session['biblioUser'] == 'biblio' || Yii::$app->session['adminUser'] == 'admin'],
                            [
                                'label' => 'Consultar',
                                'items' => [
                                    ['label' => 'Libros', 'url' => ['/libros/consulta']],
                                    ['label' => 'Mis Reservas', 'url' => ['/reserva/consulreserva']],
                                ], 'visible' => Yii::$app->session['biblioUser'] == 'biblio' || Yii::$app->session['adminUser'] == 'admin' || Yii::$app->session['profeUser'] == 'profe' || Yii::$app->session['InspecUser'] == 'Inspec' || Yii::$app->session['alumnoUser'] == 'alumno'
                            ],
                        ],
                    ]
                    //End Menu Libros
                ) : (""),
                (!Yii::$app->user->isGuest) ? (
                    //Begin Prestamo
                    [
                        'label' => 'Prestamo',
                        'items' => [
                            ['label' => 'Indice', 'url' => ['/prestamos/index'],],
                            ['label' => 'Prestar', 'url' => ['/prestamos/prestar'],],
                            ['label' => 'Historico', 'url' => ['/historico/index']],
                        ], 'visible' => Yii::$app->session['biblioUser'] == 'biblio' || Yii::$app->session['adminUser'] == 'admin'
                    ]
                    //End Prestamos
                ) : (""),
                (!Yii::$app->user->isGuest) ? (
                    //Begin Menu Alumnos
                    [
                        'label' => 'Alumnos',
                        'items' => [
                            [
                                'label' => 'Ingresar',
                                'items' => [
                                    ['label' => 'General', 'url' => ['/alumnos/ingresaalu']],
                                    ['label' => 'Alumnos Existentes', 'url' => ['/alumnos/consultarutalu']],
                                ], 'visible' => Yii::$app->session['adminUser'] == 'admin' || Yii::$app->session['InspecUser'] == 'Inspec'
                            ],
                            [
                                'label' => 'Consultar',
                                'items' => [
                                    ['label' => 'General', 'url' => ['/alumnos/congeneral']],
                                    ['label' => 'Por Curso', 'url' => ['/alumnos/cursoalumnos']],
                                    ['label' => 'L. con Apoderados', 'url' => ['/alumnos/listadoalumnosapos']],
                                    ['label' => 'L. con datos extras', 'url' => ['alumnos/fulllistaalumnos']],
                                    ['label' => 'Apoderados', 'url' => ['/apoderados/listapoderados']],
                                    ['label' => 'A. retirados', 'url' => ['/alumnos/conretirados']],
                                ], 'visible' => Yii::$app->session['biblioUser'] == 'biblio' || Yii::$app->session['adminUser'] == 'admin' || Yii::$app->session['InspecUser'] == 'Inspec' || Yii::$app->session['profeUser'] == 'profe' || Yii::$app->session['funcionarioUser'] == 'funcionario',
                            ],
                            [
                                'label' => 'Modificar',
                                'items' => [
                                    ['label' => 'Asignar curso', 'url' => ['/alumnos/asignar'], 'visible' => Yii::$app->session['adminUser'] == 'admin'],
                                    ['label' => 'Cambiar de Curso', 'url' => ['/alumnos/listacambiocurso'], 'visible' => Yii::$app->session['adminUser'] == 'admin' || Yii::$app->session['InspecUser'] == 'Inspec'],
                                    ['label' => 'Asignar Apoderados', 'url' => ['/alumnos/relacionapos'], 'visible' => Yii::$app->session['adminUser'] == 'admin' || Yii::$app->session['InspecUser'] == 'Inspec'],
                                    ['label' => 'Promoción', 'url' => ['/alumnos/listapromocion'], 'visible' => Yii::$app->session['adminUser'] == 'admin'],
                                    ['label' => 'Datos con curso', 'url' => ['/alumnos/upconcurso'], 'visible' => Yii::$app->session['adminUser'] == 'admin' || Yii::$app->session['InspecUser'] == 'Inspec'],
                                    ['label' => 'Datos', 'url' => ['/alumnos/upgeneral'], 'visible' => Yii::$app->session['adminUser'] == 'admin' || Yii::$app->session['InspecUser'] == 'Inspec'],
                                    ['label' => 'Datos Apoderados', 'url' => ['/apoderados/modapoderados'], 'visible' => Yii::$app->session['adminUser'] == 'admin' || Yii::$app->session['InspecUser'] == 'Inspec']
                                ], 'visible' => Yii::$app->session['biblioUser'] == 'biblio' || Yii::$app->session['adminUser'] == 'admin' || Yii::$app->session['InspecUser'] == 'Inspec'
                            ],
                            ['label' => 'Eliminar', 'url' => ['/alumnos/delalumno'], 'visible' => Yii::$app->session['adminUser'] == 'admin'],
                        ], 'visible' => Yii::$app->session['biblioUser'] == 'biblio' || Yii::$app->session['adminUser'] == 'admin' || Yii::$app->session['InspecUser'] == 'Inspec' || Yii::$app->session['profeUser'] == 'profe'
                    ]
                    //End Menu Alumnos
                ) : (""),
                (!Yii::$app->user->isGuest) ? (
                    //Begin Menu opciones
                    [
                        'label' => 'Opciones',
                        'items' => [
                            [
                                'label' => 'Años',
                                'items' => [
                                    ['label' => 'Seleccionar', 'url' => ['/anos/selectano'], 'visible' => Yii::$app->session['InspecUser'] == 'Inspec' || Yii::$app->session['profeUser'] == 'profe' || Yii::$app->session['biblioUser'] == 'biblio' || Yii::$app->session['funcionarioUser'] == 'funcionario' || Yii::$app->session['adminUser'] == 'admin'],
                                    ['label' => 'Administrar', 'url' => ['/anos/index'], 'visible' => Yii::$app->session['adminUser'] == 'admin'],
                                ],
                            ],
                            [
                                'label' => 'Cursos',
                                'items' => [
                                    ['label' => 'Administrar', 'url' => ['/cursos/index'],],

                                ], 'visible' => Yii::$app->session['adminUser'] == 'admin'
                            ],
                            ['label' => 'Roles', 'url' => ['/roles/index'], 'visible' => Yii::$app->session['adminUser'] == 'admin'],
                            [
                                'label' => 'Usuarios',
                                'items' => [
                                    ['label' => 'Administrar', 'url' => ['/users/index']],
                                    ['label' => 'Docentes', 'url' => ['/docente/indexdocente']],
                                    ['label' => 'Alumnos', 'url' => ['/alumnos/alumodper']],
                                ], 'visible' => Yii::$app->session['adminUser'] == 'admin'
                            ],
                            [
                                'label' => 'Localidades',
                                'items' => [
                                    ['label' => 'Regiones', 'url' => ['/region/create']],
                                    ['label' => 'Provincias', 'url' => ['/provincias/index']],
                                    ['label' => 'Comunas', 'url' => ['/comunas/index']]
                                ], 'visible' => Yii::$app->session['adminUser'] == 'admin'
                            ],
                        ], 'visible' => Yii::$app->session['biblioUser'] == 'biblio' || Yii::$app->session['adminUser'] == 'admin' || Yii::$app->session['InspecUser'] == 'Inspec' || Yii::$app->session['profeUser'] == 'profe'
                    ]
                    //End Menu opciones
                ) : (""),
                (!Yii::$app->user->isGuest) ? (
                    //Begin Menu Actualizar
                    [
                        'label' => 'Actualizar',
                        'items' => [
                            ['label' => 'Contraseña', 'url' => ['/users/changepass']],
                            ['label' => 'Correo', 'url' => ['/users/changedatos']],
                        ], 'visible' => !Yii::$app->user->isGuest
                    ]
                ) : (""),
                //Fin menu Actualizar
                ['label' => 'Contactar', 'url' => ['/site/contact']],
                Yii::$app->user->isGuest ? (['label' => 'Ingresar', 'url' => ['/site/login']]
                ) : ('<li>'
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
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>