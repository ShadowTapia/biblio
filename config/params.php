<?php

use yii\helpers\Html;

Yii::setAlias('@libroImgPath', 'D:\Server\UniServerZ\www\php\biblio\web\images\libros\\');
Yii::setAlias('@libroImgUrl',  'http://localhost/Biblio/web/images/libros');
return [
    //cambiar estos parametros cuando se suba al servidor de producción
    'adminEmail' => 'educacionks@gmail.com',
    'title' => Html::encode('The Kingstown School - Fundación Educacional Bosques de Santa Julia'),
    'salt' => 'fsddsflj38343lj0',
    'senderEmail' => 'marcelo.tapia@kingstownschool.cl',
    'senderName' => 'Sistema Administración Bibliotecaria',
    'sessionTimeoutSeconds' => '600',
];
