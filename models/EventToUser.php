<?php
/**
 * Created by PhpStorm.
 * User: kuratovevgenij
 * Date: 18/06/2019
 * Time: 18:47
 */

namespace app\models;


use yii\db\ActiveRecord;

class EventToUser extends ActiveRecord
{
    public static function tableName()
    {
        return '{{event_to_user}}';
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getEvent()
    {
        return $this->hasOne(Event::class, ['id' => 'event_id']);
    }

}