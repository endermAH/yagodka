<?php
/**
 * Created by PhpStorm.
 * User: kuratovevgenij
 * Date: 09/09/2019
 * Time: 21:22
 */

namespace app\models;


use yii\base\Model;

class JourneyForm extends Model
{
    public $members;
    public $name;

    public function rules()
    {
        return [
            ['name', 'required', 'message' => 'Введите название выезда'],
            ['members', 'required', 'message' => 'Выберите хотябы одного участника выезда']
        ];
    }

    public function add() {
        if (!$this->validate())
            return false;

        foreach ($this->members as $member){
            $rating = new Rating();
            $rating->user_id = $member;
            $rating->count = 1;
            $rating->comment = "Единение с Ягодным: \"{$this->name}\"";
            $rating->service = 0;
            $rating->save();
        }

        return true;
    }

    public function attributeLabels()
    {
        return [
          'name' => 'Название выезда',
          'members' => 'Участники выезда'
        ];
    }
}