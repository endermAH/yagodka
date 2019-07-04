<?php
/**
 * Created by PhpStorm.
 * User: kuratovevgenij
 * Date: 10/04/2019
 * Time: 18:08
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = "Регистрация";
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => 'icons/user.png']);
?>
<div class="col-md-6 col-md-offset-3">

    <h1 class="mb20">
        <?= Html::encode($this->title) ?>
    </h1>

    <?php
    $form = ActiveForm::begin();

    echo $form->field($model, 'username')->textInput(['autofocus' => true]);
    echo $form->field($model, 'password')->passwordInput();
    echo $form->field($model, 'password_repeat')->passwordInput();
    echo $form->field($model, 'name')->textInput();
    echo $form->field($model, 'surname')->textInput();
    echo $form->field($model, 'patronymic')->textInput();
    echo $form->field($model, 'berry')->textInput();
    echo Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary', 'name' => 'register-button']);

    ActiveForm::end();
    ?>
</div>