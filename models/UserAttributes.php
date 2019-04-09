<?php
/**
 * Created by PhpStorm.
 * User: kuratovevgenij
 * Date: 09/04/2019
 * Time: 14:56
 */

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class UserAttributes extends ActiveRecord
{
    public static function tableName()
    {
        return '{{user_attribute}}';
    }

    public static function getUserAttributes($uid){
        $attributes = self::findAll(['id' => $uid]);
        return $attributes;
    }
}