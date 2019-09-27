<?php
/**
 * Created by PhpStorm.
 * User: kuratovevgenij
 * Date: 26/06/2019
 * Time: 01:51
 */

use app\models\User;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = $user->berry;
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => 'icons/settings.png']);

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
            <small class="header-role"><?= $user->getRoleName() ?></small>
        </h1>
    </div>


    <?php $form = ActiveForm::begin([
        'id' => 'contact-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'labelOptions' => ['class' => 'col-lg-3 ', 'encode' => true],
            'template' => "{label}<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-6\">{error}</div>",
        ],
    ]); ?>

    <?= $form->field($model, 'phone')->textInput(['autofocus' => true])->label("<i class='fas fa-phone'></i> Номер телефона") ?>
    <?= $form->field($model, 'email')->textInput()->label("<i class='fas fa-envelope'></i> Адрес электронной почты") ?>
    <?= $form->field($model, 'isu')->textInput()->label("<i class=\"far fa-address-card\"></i> Табельный номер ИСУ") ?>
    <?= $form->field($model, 'vk')->textInput()->label("<i class=\"fab fa-vk\"></i> Ссылка ВК") ?>


    <div class="form-group">
        <div class="col-lg-11">
            <?= Html::submitButton('Применить' ,['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>


