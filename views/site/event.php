<?php
/**
 * Created by PhpStorm.
 * User: kuratovevgenij
 * Date: 18/06/2019
 * Time: 19:11
 */

use yii\helpers\Html;
use app\models\User;
use app\models\EventToUser;

$this->title = $event->name;
$manager_id = EventToUser::find()->where(['event_id' => $event['id'], 'role' => '1'])->one()->id;
$manager = User::findIdentity($manager_id);
$team = $event->users;

?>

<style>
    .medium-avatar {
        width: 135px;
        height: 135px;
        border-radius: 100%;
        overflow: hidden;
        border: 2px solid white;
        box-shadow: 0 0  0 2px #990099;
    }

    #inline {
        width: 100%;
        height: auto;
        display: flex;
        align-items: center;
    }

    .one {
        align-items: center;
        width: 50%;
        height: 10%;
    }

    .two {
        width: 50%;
        height: 100%;
        text-align: center;
    }

    .btn {
        height: 40px;
        padding: 10px 12px;
        width: 100%;
    }

    #testimg {
        width: 100%;
        height: 40%;
    }

</style>

<div class="row">
    <div class='page-header clearfix' style="margin-top: 0;">
        <div class="col-md-6">
            <h1><?= $event['name'] ?></h1>
        </div>

    </div>
</div>
<div class="row">

</div>
<div class="row">

    <div class="col-md-4" style="padding: 10px">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div id="inline">
                    <div class="one"><?= Html::img(User::userAvatar($manager), ['class' => "medium-avatar"]) ?></div>
                    <div class="two">
                        <h3 style="margin-bottom: 20px;">
                            <?= $manager['surname'] . ' ' . $manager['name'] . ' ' . $manager['patronymic'] ?>
                        </h3></div>
                </div>

            </div>
            <div class="panel-body" style="padding: 0 15px 0 15px">
                <?php $i = 0; foreach ($team as $member):?>
                    <?php if($member->id != $manager_id):?>
                        <div class="row row-<?= ((($i % 2) == 1)?('even'):('odd'))?>">
                            <div class="col-xs-4">
                                <div class="img-small-borders">
                                    <img src="<?= \app\models\User::userAvatar(\app\models\User::findIdentity($member->id)) ?>" class="img-small">
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="table-text">
                                    <?= Html::a($member->berry, ['/site/profile', 'uid' => $member->id], ['class' => 'berry-link'] ) ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php $i++ ?>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                О мероприятии
            </div>
            <div class="panel-body">
                <p><b>Дата проведения:</b> <?= $event['date'] ?> </p>
                <p><b>Уровень мероприятия:</b> <?= $event['level'] ?> </p>
                <p><b>Место проведения:</b> <?= $event['place'] ?> </p>
            </div>
        </div>
    </div>

    <div class="col-md-5" >
        <div class="row" style="padding: 10px">
            <div class="col-md-12" style="padding: 1px 1px;">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Описание
                    </div>

                    <div class="panel-body">
                        <?= $event['description'] ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3" >
        <div class="row" style="padding: 10px">
            <div class="col-md-12" style="padding: 1px 1px;">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        План
                    </div>

                    <div class="panel-body">
                        <?= $event['program'] ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>


