<?php
/**
 * Created by PhpStorm.
 * User: kuratovevgenij
 * Date: 25/07/2019
 * Time: 12:52
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Сменить аватарку';
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => 'icons/settings.png']);
?>

    <div class="row">
        <div class="page-header">
            <h1>
                <?='Сменить аватар: '.$user->berry ?>
            </h1>
        </div>
    </div>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
    <?= $form->field($model, 'image')->fileInput() ?>
    <?= Html::submitButton('Изменить', ['class' => 'btn btn-success', ]) ?>
<?php ActiveForm::end() ?>
