<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\Url;
use app\models\Event;

AppAsset::register($this);

use app\models\User;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

    <!-- Шрифт -->
<!--    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans" rel="stylesheet">-->
<!--    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">-->

</head>
<body>
<?php
    $userinfo = !Yii::$app->user->isGuest ?' 
        <img class="very-small-avatar" src="' .
        User::userAvatar(Yii::$app->user->identity) .
        '">'.
        Yii::$app->user->identity->berry: "";

    $newUsers = User::find()->where(['status' => 0])->count();
    $newEvents = Event::find()->where(['status' => 0])->count();
    $newEvents = !Yii::$app->user->isGuest && Yii::$app->user->identity->role_id >= User::ROLE_MANAGER && $newEvents != 0 ? "<sup><span class='new'> {$newEvents} </span></sup>" : '';
?>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Ягодка',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'encodeLabels' => false,
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Рейтинг', 'url' => ['/site/rating']],
            !Yii::$app->user->isGuest&&Yii::$app->user->identity->role_id >= User::ROLE_MANAGER ?
                ['label' => "Участники". ($newUsers > 0 ?" <sup><span class='new'> {$newUsers} </span></sup>":""), 'url' => ['/site/members']]:"",
            !Yii::$app->user->isGuest&&Yii::$app->user->identity->role_id >= User::ROLE_MANAGER ?
                ['label' => "Баллы",
                    'items' => [
                        ['label' => 'Выезд', 'url' => ['/site/journey']],
                        //['label' => 'Собрание', 'url' => ['/site/profile', 'uid' => Yii::$app->user->identity->id]],
                        ['label' => 'SMM', 'url' => ['/site/smm']],
                ]]:"",
            ['label' => 'Мероприятия '.$newEvents, 'url' => ['/site/events']],
            !Yii::$app->user->isGuest ? (
            [
                'label' => $userinfo,
                'items' => [
                    ['label' => 'Профиль', 'url' => ['/site/profile', 'uid' => Yii::$app->user->identity->id]],
                    '<li>' . Html::a('Выход', ['/site/logout'], ['data' => ['method' => 'post']]) . '</li>',
                ]
            ]
            ) : (
                ['label' => 'Вход', 'url' => ['/site/login']]
            ),
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
