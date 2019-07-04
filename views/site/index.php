<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
$this->title = 'Ягодка';
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => 'icons/logo.png']);
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Я - ГОДКА, Я - МРАЗЬ!</h1>

        <p class="lead">Будь с нами, будь как мы!</p>

        <?php if(Yii::$app->user->isGuest) echo Html::a('Присоединиться', ['/site/register'], ['class'=>'btn btn-lg btn-success']) ?>
    </div>

    <div class="body-content">

    </div>
</div>
