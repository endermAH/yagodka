<?php
/**
 * Created by PhpStorm.
 * User: kuratovevgenij
 * Date: 03/07/2019
 * Time: 21:14
 */

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;
use yii\helpers\Html;

class EventForm extends Model
{
    //Регэксп взят из недр yii
    public $name;
    public $date;
    public $place;
    public $description;
    public $program;
    public $links;
    public $level;
    public $coverage;
    public $org;
    public $cluborg;
    public $orgFlag = false;
    public $orgs;

    public $event_levels = [
        '1' => 'Факультетское',
        '2' => 'Внутривузовское',
        '3' => 'Межвузовское',
        '4' => 'Городское',
        '5' => 'Региональное',
        '6' => 'Всеросийское',
        '7' => 'Международное'
    ];

    public function rules()
    {
        return [
            [['name', 'date', 'place', 'description', 'program', 'links', 'level', 'coverage', 'org', 'cluborg', 'orgFlag', 'orgs'], 'required', 'message' => "Это поле не может быть пустым"],
            [['coverage', 'org', 'cluborg'], 'integer'],
            ['level', 'integer', 'min' => 1, 'max' => 7],
        ];
    }

    public function register()
    {
        var_dump($this->orgs);
        die;

        if (!$this->validate())
            return false;

        $event = new Event();
        foreach ($this->attributes as $key => $value) {
            $event->$key = $value;
        }
        return true;
    }


    public function attributeLabels()
    {
        return [
            'name' => 'Название мероприятия',
            'date' => 'Даты проведения',
            'place' => 'Место проведения',
            'description' => 'Описание мероприятия',
            'program' => 'Программа мероприятия',
            'links' => 'Ссылки на внешние ресурсы',
            'level' => 'Уровень мероприятия',
            'coverage' => 'Охват мероприятия',
            'org' => 'Количество организаторов',
            'cluborg' => 'Количество организаторов от клуба'
        ];
    }

    public function attributeHints()
    {
        return [
            'date' => 'Формат: дд.мм.гггг-дд.мм.гггг, если больше одного дня',
            'links' => 'Посты в IS, Ягодном, ссылки на группы мероприятий'
        ];
    }

    public function attributePlaceholders() {
        return [
            'date' => 'дд.мм.гггг'
        ];
    }
}