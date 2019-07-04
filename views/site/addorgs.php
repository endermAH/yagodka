<?php
/**
 * Created by PhpStorm.
 * User: kuratovevgenij
 * Date: 04/07/2019
 * Time: 00:49
 */

//echo $model->org;
//var_dump($users);

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$model->orgFlag = true;

echo '<pre>';
var_dump($model);
echo '</pre>';

$form = ActiveForm::begin();

for ($i = 1; $i <= $model->org; $i++) {
    echo $form->field($model, 'orgs['.$i.']')->textInput();
}

echo Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'save-button']);

ActiveForm::end();
