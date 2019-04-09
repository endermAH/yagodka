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
            <?php if($user->id === Yii::$app->user->identity->id):?>
                <a href="<?= Url::to(['user/edit']) ?>"><sup><i class="glyphicon glyphicon-pencil btn-edit"></i></sup></a>
            <?php endif; ?>
            <small class="header-role"><?= $user->getRoleName() ?></small>
        </h1>
    </div>
</div>


<div class="row">

    <!-- Левая колонка -->
    <div class="col-md-3">

        <!-- Блок с аватаркой -->
        <div class="panel panel-default">
            <div class="panel-body null-panel" >
                <a href="<?= Url::to(['user/upload']) ?>">
                    <img class="avatar" src="<?= User::userAvatar($user) ?>">
                </a>
            </div>
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
                                'label' => 'Рейтинг'
                            ],
                        ],

                    ])
                ?>
                <?php
                //var_dump($userattributes);
                foreach ($userattributes as $attribute) {
                    echo $attribute->attribute_name.' - '.$attribute->attribute_value;
                }
                ?>
            </div>
        </div>

