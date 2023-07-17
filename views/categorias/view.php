<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\categorias\Categorias */

$this->title = $model->categoria;
$this->params['breadcrumbs'][] = ['label' => 'Categorías', 'url' => ['index']];
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
<div class="categorias-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    Modal::begin([
        'header' => '<h4>Categoría</h4>',
        'id' => 'modal',
        'size' => 'modal-lg',
    ]);
    echo "<div id='modalContent'></div>";

    Modal::end();
    ?>

    <p>
        <?=
        Html::button(
            'Actualizar',
            [
                'value' => Url::to(['update', 'id' => $model->idcategoria]), 'class' => 'btn btn-primary custom_button'
            ]
        );
        ?>
        <?= Html::a('Borrar', ['delete', 'id' => $model->idcategoria], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Estás seguro de borrar este item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idcategoria',
            'categoria',
        ],
    ]) ?>

</div>