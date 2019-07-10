<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
$this->title = 'Ягодка';
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => 'icons/logo.png']);
?>
<style>
    .stat {
        height: 25vh;
        width: 25vh;
        background-color: indianred;
        color: white;
        border-radius: 50%;
        font-size: 8vh;
        margin-left: auto;
        margin-right: auto;
        margin-bottom: 15px;
    }

    .stat-text {
        position: relative;
        top: 50%;
        /*left: 50%;*/
        transform: translate(0, -50%);
    }
</style>
<div class="site-index">

    <div class="jumbotron">
        <h1>Я - ГОДКА, Я - МРАЗЬ!</h1>

        <p class="lead">Будь с нами, будь как мы!</p>

        <?php if(Yii::$app->user->isGuest) echo Html::a('Присоединиться', ['/site/register'], ['class'=>'btn btn-lg btn-success']) ?>
    </div>

    <div class="body-content">
        <div class="row">
            <div class="col-md-4">
                <div class="stat">
                    <div class="stat-text text-center"> <?= $total_coverage ?> <p style="font-size: 2vh">ОБЩИЙ  <br> ОХВАТ</p> </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat">
                    <div class="stat-text text-center"> <?= $event_count ?> <p style="font-size: 2vh">МЕРОПРИТИЙ  <br> КЛУБА</p>  </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat">
                    <div class="stat-text text-center"> <?= $member_count ?> <p style="font-size: 2vh">УЧАСТНИКОВ <br> В КЛУБЕ</p> </div>
                </div>
            </div>
        </div>
    </div>
</div>
