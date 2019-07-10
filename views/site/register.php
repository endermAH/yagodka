<?php
/**
 * Created by PhpStorm.
 * User: kuratovevgenij
 * Date: 10/04/2019
 * Time: 18:08
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\User;

$this->title = "Регистрация";
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => 'icons/user.png']);
?>
<div class="col-md-6 col-md-offset-3">
    <div class="page-header">
        <h1 class="mb20">
            <?= $model->scenario == 'register' ? Html::encode($this->title): 'Редактировать пользователя' ?>
        </h1>
    </div>

    <?php
    $form = ActiveForm::begin();

    if ($model->scenario == 'register') {
        echo $form->field($model, 'username')->textInput(['autofocus' => true]);
        echo $form->field($model, 'password')->passwordInput();
        echo $form->field($model, 'password_repeat')->passwordInput();
    }
    echo $form->field($model, 'name')->textInput();
    echo $form->field($model, 'surname')->textInput();
    echo $form->field($model, 'patronymic')->textInput();
    echo $form->field($model, 'berry')->textInput();
    if (($model->scenario == 'update') && (User::findOne(['id' => $uid])->role_id <= User::ROLE_MANAGER)) {
        echo $form->field($model, 'role_id')->dropDownList([
            User::ROLE_MANAGER => 'Руководитель клуба',
            User::ROLE_SECRETORY => 'Секретарь',
            User::ROLE_MEMBER => 'Участник'
        ]);
    }
    echo Html::submitButton($model->scenario == 'register' ? 'Зарегистрироваться' : 'Изменить', ['class' => 'btn btn-primary', 'name' => 'register-button']);

    ActiveForm::end();
    ?>
</div>