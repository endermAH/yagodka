<?php
/**
 * Created by PhpStorm.
 * User: kuratovevgenij
 * Date: 18/06/2019
 * Time: 17:52
 */


use yii\helpers\Html;
use app\models\User;
use app\models\Event;

$this->title = 'Наши мероприятия';
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => 'icons/logo.png']);
?>

<div class="row">
    <div class='page-header clearfix' style="margin-top: 0;">
        <div class="col-md-6">
            <h1><?= $this->title ?></h1>
        </div>
        <div class="col-md-6">
            <h1><?= Html::a('Добавить отчет', ['site/newevent'], ['class' => 'btn btn-success pull-right']) ?></h1>
        </div>
    </div>
</div>

<?php
if (!Yii::$app->user->isGuest&&Yii::$app->user->identity->role_id >= User::ROLE_MANAGER): ?>
    <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading">Неутвержденные мероприятия</div>

        <!-- Table -->
        <table class="table">
            <tbody>
            <?php foreach ($ucEvents as $record): ?>
                <tr>
                    <td style="vertical-align: middle"><?= Html::a($record->name, ['site/editevent', 'eid' => $record->id]) ?></td>
                    <td style="vertical-align: middle"><?= $record->date ?></td>
                    <td style="vertical-align: middle"><?= Event::$event_levels[$record->level] ?></td>
                    <td style="vertical-align: middle"><?= Html::a('Утвердить', ['site/confirmevent', 'eid' => $record->id], ['class' => 'btn btn-success']); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading">Мероприятия</div>

    <!-- Table -->
    <table class="table">
        <tbody>
        <?php foreach ($trueEvents as $record): ?>
            <tr>
                <td style="vertical-align: middle"><?= Html::a($record->name, ['site/event', 'id' => $record->id]) ?></td>
                <td style="vertical-align: middle"><?= $record->date ?></td>
                <td style="vertical-align: middle"><?= Event::$event_levels[$record->level] ?></td>
                <?php if(!Yii::$app->user->isGuest&&Yii::$app->user->identity->role_id >= User::ROLE_MANAGER): ?>
                    <td style="vertical-align: middle"><?= Html::a('Снять', ['site/confirmevent', 'eid' => $record->id], ['class' => 'btn btn-danger']); ?></td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
