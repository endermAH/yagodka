<?php
/**
 * Created by PhpStorm.
 * User: kuratovevgenij
 * Date: 10/09/2019
 * Time: 12:51
 */

namespace app\models;


use yii\db\ActiveRecord;

class Post extends ActiveRecord
{
    public static function tableName()
    {
        return '{{post}}';
    }
}