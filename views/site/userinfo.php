<?php
/**
 * Created by PhpStorm.
 * User: kuratovevgenij
 * Date: 09/04/2019
 * Time: 14:10
 */

use app\models\User;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = $user->berry;
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => 'icons/user.png']);

//TODO переместить CSS
?>
<style xmlns="http://www.w3.org/1999/html">
    .test-panel {

        margin:  10px;
    }

    .glyphicon {
        font-size: 30px;
    }

    .glyphicon-ok-circle {
        color: lawngreen;
    }

    .glyphicon-remove-circle {
        color: red;
    }

    .glyphicon-ban-circle {
        color: orange;
    }

    .header-role{
        text-transform: uppercase;
    }

    .avatar{
        width: 100%;
        padding-bottom: 15px;
    }

    .null-panel{
        padding: 0;
    }

    .small-avatar{
        width: 48px;
        height: 48px;
        border-radius: 50%;
    }

    .groupmate-well{
        margin: 5px;
    }

    .helper{
        color: #777;
    }

    .btn-edit{
        font-size: small;
        color: #777777;
    }

    #col {
        vertical-align: middle;
        width: 30%;
    }
</style>

<div class="row">
    <div class="page-header">
        <h1>
            <?=$user->surname.' '.$user->name.' '.$user->patronymic ?>
            <?php if (!Yii::$app->user->isGuest&&Yii::$app->user->identity->role_id >= User::ROLE_MANAGER):?>
                <a href="<?= Url::to(['site/edit-user', 'uid' => $user->id]) ?>"><sup><i class="glyphicon glyphicon-pencil btn-edit"></i></sup></a>
            <?php endif; ?>
            <small class="header-role"><?= $user->getRoleName() ?></small>
        </h1>
    </div>
</div>


<div class="row">

    <!-- Левая колонка -->
    <div class="col-md-3">

        <!-- Блок с аватаркой -->
        <div>
            <?php
            $userAvatar = User::userAvatar($user);
            $img = "<img class='avatar' src='{$userAvatar}'/>";
            if (!Yii::$app->user->isGuest&&Yii::$app->user->identity->role_id >= User::ROLE_MANAGER) {
                echo Html::a($img, ['site/upload-avatar', 'uid' =>$user->id]);
            } else {
                echo $img;
            }
            ?>
        </div>

        <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading">
                <b>
                    Контакты&ensp;
                    <?php if(!Yii::$app->user->isGuest&&$user->id === Yii::$app->user->identity->id):?>
                        <a href="<?= Url::to(['site/contact']) ?>"><small><i class="glyphicon glyphicon-pencil btn-edit"></i></small></a>
                    <?php endif; ?>
                </b>
            </div>

            <!-- Table -->
            <table class="table">
                <?php foreach ($userattributes as $attribute): ?>
                    <tr>
                        <td>
                            <?php switch($attribute->attribute_name){
                                case "phone":
                                    echo "<i class=\"fas fa-phone\"></i> :<a href='callto:".$attribute->attribute_value."'>";
                                    break;
                                case "email":
                                    echo "<i class=\"fas fa-envelope\"></i> :<a href='mailto:".$attribute->attribute_value."'>";
                                    break;
                                case "vk":
                                    echo "<i class=\"fab fa-vk\"></i> :<a href='".$attribute->attribute_value."'>";
                                    break;
                                case "isu":
                                    echo "<i class=\"far fa-address-card\"></i> :<a href='https://isu.ifmo.ru/pls/apex/f?p=2143:PERSON:102529604385000::NO::PID:".$attribute->attribute_value."'>";
                                    break;
                                default:
                                    echo $attribute->attribute_name;
                            }
                            ?>
                            <?= $attribute->attribute_value ?></td>
                        </td>
                        <td></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

    </div>

    <!-- Правая колонка -->
    <div class="col-md-9">

        <!-- Блок с информацией -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Информация:</h3>
            </div>
            <div class="panel-body">
                <?=
                    DetailView::widget([
                        'model' => $user,
                        'attributes' => [
                            [
                                'attribute' => 'berry',
                                'label' => 'Ягодка'
                            ],
                            [
                                'attribute' => 'rating',
                                'label' => 'Рейтинг',
                                'value' => $user->rating()?Html::a($user->rating(), ['site/userrating', 'uid' => $user->id]):0,
                                'format' => 'raw'
                            ],
                            [
                                'attribute' => 'cash',
                                'label' => 'Ягодки'
                            ],
                        ],

                    ])
                ?>

                <div class="events" style="margin-bottom: 20px">
                    <?php foreach ($events as $event){
                        if($event->status){
                            echo Html::a($event->name, ['site/event', 'id' => $event->id], ['class' => 'btn btn-warning']).' ';
                        }
                    }?>
                </div>

                <?php if(!Yii::$app->user->isGuest&&((Yii::$app->user->identity->role_id == User::ROLE_ADMIN) || (Yii::$app->user->identity->role_id == User::ROLE_MANAGER) )): ?>
                    <?php $form = ActiveForm::begin([
                        'id' => 'rating-form',
                        'layout' => 'horizontal',
                        'fieldConfig' => [
                            'template' => "
                                <div class='row'><div class=\"col-md-12\">{input}</div></div>
                                <div class='row'><div class=\"col-md-12\">{error}</div></div> ",
                            'labelOptions' => ['class' => 'col-md-12'],
                        ],
                    ]); ?>
                    <?php
                    $button = Html::submitButton('Изменить', ['class' => 'btn btn-success', ]);
                    $form = "
                    <div class='row' style='padding: 15px'>
                        <div class='col-md-5'>
                            {$form->field($ratingModel, 'count')->textInput(['autofocus' => false, 'placeholder' => 'Количество баллов'])}
                        </div>
                        <div class='col-md-5'>
                            {$form->field($ratingModel, 'comment')->textInput(['autofocus' => false, 'placeholder' => 'Комментарий'])}
                        </div>
                        <div class='col-md-2'>
                            {$button}
                        </div>
                    </div>"; ?>
                    <?= $form ?>
                    <?php ActiveForm::end(); ?>
                <?php endif;?>


            </div>
        </div>

