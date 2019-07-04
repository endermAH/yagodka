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
    public static function tableName()
    {
        return '{{rating}}';
    }
}