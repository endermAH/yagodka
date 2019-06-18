<?php
/**
 * Created by PhpStorm.
 * User: kuratovevgenij
 * Date: 18/06/2019
 * Time: 19:11
 */

use yii\helpers\Html;
use app\models\User;

$this->title = $event->name;
$description = json_decode($test['description'], true);
$manager = User::find()->where(['event_id' => $event['id'], 'role' => '1'])->one();

?>

<style>
    .medium-avatar {
        width: 135px;
        height: 135px;
        border-radius: 50%;
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

    .col-md-3 {
        padding: 1px 1px;
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

    <div class="col-md-8">
        <div class="row">
            <div class="col-md-12" style="padding: 1px 1px;">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 style="line-height: 1; margin: 0px">Информация о мероприятии</h3>
                    </div>

                    <div class="panel-body">
                        <!-- style="padding: 0 20%"-->
                        <p></p>
                        <p><b>Описание:</b> <?= $event['description'] ?> </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div id="inline">
                    <div class="one"><?= Html::img(User::userAvatar($manager->getId()), ['class' => "medium-avatar"]) ?></div>
                    <div class="two">
                        <h3 style="margin-bottom: 20px;">
                            <?= $manager['surname'] . ' ' . $manager['name'] . ' ' . $manager['patronymic'] ?>
                        </h3></div>
                </div>

            </div>
            <div class="panel-body">
<!--                <h4>О руководителе</h4>-->
<!--                <p><b>Подразделение:</b> --><?//= $teacher['department']; ?><!--</p>-->
<!--                <p><b>Должность:</b> --><?//= User::rolesLabels()[$teacher['role']] ?><!--</p>-->
<!--                <hr>-->
<!--                <h4>Контактная информация</h4>-->
<!--                <p><b>Электронная почта:</b> --><?//= Html::a($teacher['email'], 'mailto:' . $teacher['email']); ?><!--</p>-->
<!--                <p><b>Телефон:</b> --><?//= Html::a(88005553535, 'callto: 88005553535'); ?><!-- </p>-->
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                О документе
            </div>
<!--            <div class="panel-body">-->
<!--                <p><b>Время исполнения:</b> --><?//= $description['duration'] ?><!-- </p>-->
<!--            </div>-->
        </div>
    </div>
</div>


