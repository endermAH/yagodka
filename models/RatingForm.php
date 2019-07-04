<?php
/**
 * Created by PhpStorm.
 * User: kuratovevgenij
 * Date: 21/04/2019
 * Time: 10:49
 */

namespace app\models;


use yii\base\Model;
use app\models\User;

class RatingForm extends Model
{
    public $count;
    public $comment;

    public function rules()
    {
        return [
            ['count', 'required', 'message' => 'Это поле не может быть пустым'],
            ['count', 'integer', 'message' => 'Неверный формат числа'],
            ['comment', 'required', 'message' => 'Введите комментарий'],
            ['comment', 'string', 'message' => 'Неверный формат комментария'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'count' => 'Изменить баллы',
        ];
    }

    public function changeRating($uid){
        if ($this->validate()){
            $record = new Rating();
            foreach ($this->attributes as $key => $value) {
                $record->$key = $value;
            }
            $record->user_id = $uid;
            return $record->save();
        }
    }


}