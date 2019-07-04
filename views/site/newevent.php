<?php
/**
 * Created by PhpStorm.
 * User: kuratovevgenij
 * Date: 10/04/2019
 * Time: 18:08
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = "Отчет о мероприятии";
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => 'icons/settings.png']);
?>
<div class="col-md-6 col-md-offset-3">

    <h1 class="mb20">
        <?= Html::encode($this->title) ?>
    </h1>

    <?php
    $form = ActiveForm::begin();

    echo $form->field($model, 'name')->textInput(['autofocus' => true]);
    echo $form->field($model, 'date')->textInput(['placeholder' => 'дд.мм.гггг']);
    echo $form->field($model, 'place')->textInput();
    echo $form->field($model, 'description')->textarea();
    echo $form->field($model, 'program')->textarea();
    echo $form->field($model, 'links')->textarea();
    echo $form->field($model, 'level')->dropDownList(
        $model->event_levels
    );
    echo $form->field($model, 'coverage')->textInput();
    echo $form->field($model, 'org')->textInput();
    echo $form->field($model, 'cluborg')->textInput();

    echo Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary', 'name' => 'register-button']);

    ActiveForm::end();
    ?>
</div>