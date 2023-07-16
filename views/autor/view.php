<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;


/* @var $this yii\web\View */
/* @var $model app\models\autor\Autor */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Autores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<?php
$this->registerJs(
    '
    function init_click_handlers(){
        $(".custom_button").on("click", function(){
            $("#modal").modal("show").find("#modalContent").load($(this).attr("value"));           
        });        
    }
    init_click_handlers();//first run
    $("#pjax-container").on("pjax:success", function(){
        init_click_handlers();
    });    
'
);
?>
<div class="autor-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    Modal::begin([
        'header' => '<h4>Autor</h4>',
        'id' => 'modal',
        'size' => 'modal-lg',
    ]);
    echo "<div id='modalContent'></div>";

    Modal::end();
    ?>

    <p>
        <?=
        Html::button(
            "Actualizar",
            [
                'value' => Url::to(['autor/update', 'id' => $model->idautor]), 'class' => 'btn btn-circle btn-primary custom_button',
                'title' => 'Actualizar Autor'
            ]
        );
        ?>
        <?= Html::a('Borrar', ['delete', 'id' => $model->idautor], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Estas seguro de borrar este Autor?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idautor',
            'nombre',
            'nacionalidad',
        ],
    ]) ?>

</div>