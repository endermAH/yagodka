<?php
/**
 * Created by PhpStorm.
 * User: kuratovevgenij
 * Date: 18/06/2019
 * Time: 17:53
 */

namespace app\models;


use yii\db\ActiveRecord;

class Event extends ActiveRecord
{
    public static function tableName()
    {
        return '{{event}}';
    }

    public static function findIdentity($id)
    {
        return self::findOne(['id' => $id]);
    }

    public function getUsers()
    {
        return $this->hasMany(User::class, ['id' => 'user_id'])
            ->viaTable(EventToUser::tableName(), ['event_id' => 'id']);
    }
}