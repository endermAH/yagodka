<?php
/**
 * Created by PhpStorm.
 * User: kuratovevgenij
 * Date: 01/07/2019
 * Time: 21:21
 */

namespace app\models;


use yii\db\ActiveRecord;

class Rating extends ActiveRecord
{
    public static $role_rating = [
      1 => 15,
      2 => 10,
      3 => 7,
      4 => 5,
    ];

    public static $role_names = [
        1 => 'Главный организатор',
        2 => 'Организатор',
        3 => 'Ответственный исполнитель',
        4 => 'Волонтер',
    ];

    public static function tableName()
    {
        return '{{rating}}';
    }

    public static function findByUID($uid) {
        return self::findOne(['user_id' => $uid]);
    }
}