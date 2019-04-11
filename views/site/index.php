<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Я - ГОДКА, Я - МРАЗЬ!</h1>

        <p class="lead">Будь с нами, будь как мы!</p>

        <?= Html::a('Присоединиться', ['/site/register'], ['class'=>'btn btn-lg btn-success']) ?>
    </div>

    <div class="body-content">

    </div>
</div>
