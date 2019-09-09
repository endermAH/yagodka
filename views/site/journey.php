<?php
/**
 * Created by PhpStorm.
 * User: kuratovevgenij
 * Date: 09/09/2019
 * Time: 22:00
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;

$this->title = "Добавить баллы за выезд";
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => 'icons/settings.png']);
?>

<div class="col-md-6 col-md-offset-3">

    <h1 class="mb20">
        <?= Html::encode($this->title) ?>
    </h1>

    <?php
    $form = ActiveForm::begin();

    echo $form->field($model, 'name')->textInput(['autofocus' => true]);

    echo $form->field($model, 'members')->widget(Select2::classname(), [
        'data' => $users,
        'options' => ['placeholder' => 'Выберите участников', 'multiple' => true],
        'pluginOptions' => [
            'allowClear' => false,
        ],
    ]);

    echo Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'register-button']);

    ActiveForm::end();
    ?>
</div>