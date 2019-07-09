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
    const ROLE_MANAGER = 1;
    const ROLE_ORGANIZER = 2;
    const ROLE_WORKER = 3;
    const ROLE_VOLUNTEER = 4;

    public static $event_levels = [
        '1' => 'Факультетское',
        '2' => 'Внутривузовское',
        '3' => 'Межвузовское',
        '4' => 'Городское',
        '5' => 'Региональное',
        '6' => 'Всеросийское',
        '7' => 'Международное'
    ];

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