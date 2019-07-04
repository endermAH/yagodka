<?php
/**
 * Created by PhpStorm.
 * User: kuratovevgenij
 * Date: 26/06/2019
 * Time: 18:18
 */

use yii\helpers\Html;

$this->title = 'Участники клуба';
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => 'icons/members.png']);
?>

<div class="page-header">
    <h1 class="mb20">
        <?= Html::encode($this->title) ?>
    </h1>
</div>

<div class="row">
    <div class="panel-body col-md-8 col-md-push-2 " style="padding: 0 15px 0 15px">
        <?php $i = 0; foreach ($users as $user):?>
                <div class="row row-<?= ((($i % 2) == 1)?('even'):('odd'))?>">
                    <div CLASS="col-xs-1">
                        <div class="table-text">
                            <?= $i+1 ?>
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class="img-small-borders">
                            <img src="<?= \app\models\User::userAvatar(\app\models\User::findIdentity($user->id)) ?>" class="img-small">
                        </div>
                    </div>
                    <div class="col-xs-5">
                        <div class="table-text">
                            <?= Html::a($user->berry, ['/site/profile', 'uid' => $user->id], ['class' => 'berry-link'] ) ?>
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class="table-text">
                            <?php if(
                                    (Yii::$app->user->identity->role_id > \app\models\User::ROLE_MANAGER) &&
                                    ($user->id != Yii::$app->user->getId()) &&
                                    (Yii::$app->user->identity->role_id > $user->role_id)
                            ){
                                if(!$user->status) echo Html::a('Принять', ['site/confirm', 'uid' => $user->id], ['class' => 'btn btn-success']);
                                else echo Html::a('Заблокировать', ['site/confirm', 'uid' => $user->id], ['class' => 'btn btn-danger']);
                            }
                            ?>
                        </div>
                    </div>
                </div>
            <?php $i++ ?>
        <?php endforeach; ?>
    </div>
</div>