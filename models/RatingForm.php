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

    public function rules()
    {
        return [
            ['count', 'required', 'message' => 'Это поле не может быть пустым'],
            ['count', 'integer', 'message' => 'Неверный формат числа']
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
            $user = User::findIdentity($uid);
            $user->rating = $user->rating + $this->count;
            $user->cash = $user->cash + $this->count;
            return $user->save();
        }
    }
}