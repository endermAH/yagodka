<?php
/**
 * Created by PhpStorm.
 * User: kuratovevgenij
 * Date: 10/04/2019
 * Time: 01:25
 */

use yii\helpers\Html;
$i = 1;
?>
    <center><h1>Рейтинг участников клуба</h1></center><br>

    <div class="container-fluid">
        <div class="row justify-content-md-center">
            <div class="col-md-8 col-md-push-2 table-body">
                <div class="container-fluid">
                    <div class="row row-special">
                        <div class="col-12">Toп-5</div>
                    </div>
                    <div id="inner-div">
                        <?php foreach ($rating as $user): ?>

                            <div class="row row-<?= ((($i % 2) == 1)?('even'):('odd'))?>">
                                <div class="col-xs-1">
                                    <div class="table-text">
                                        <?=  (($i==1)?('<i class="fas fa-crown" style="color: #990099"></i>'):($i)) ?>
                                    </div>
                                </div>
                                <div class="col-xs-2">
                                    <div class="img-small-borders">
                                        <img src="<?= \app\models\User::userAvatar(\app\models\User::findIdentity($user->id)) ?>" class="img-small">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="table-text">
                                        <?= Html::a($user->berry, ['/site/profile', 'uid' => $user->id], ['class' => 'berry-link'] ) ?>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="table-text">
                                        <span id="heart-count-'+ i +'"> <?= $user->rating ?></span>
                                    </div>
                                </div>
                            </div>
                            <?php $i++ ?>
                            <?php if($i == 6): ?>
                                <div class="row row-special">
                                    <div class="col-12">Остальные</div>
                                </div>
                            <?php endif;?>
                        <?php endforeach;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
