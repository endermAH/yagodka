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
    public $orgs;
    public $done = 0;
    public $responsible;
    public $volunteer;
    public $linksmedia;

    public function rules()
    {
        return [
            [['name', 'date', 'place', 'description', 'program', 'links', 'level', 'coverage', 'org', 'cluborg', 'linksmedia'], 'required', 'message' => "Это поле не может быть пустым"],
            //['name', 'unique', 'targetClass' => Event::class, 'message' => 'Этот название уже используется'],
            [['volunteer', 'orgs', 'responsible'], 'safe'],
            [['coverage', 'org', 'cluborg'], 'integer'],
            ['level', 'integer', 'min' => 1, 'max' => 7],
        ];
    }

    public function register()
    {
        if (!$this->validate())
            return false;

        $event = new Event();
        $dep = new EventToUser();

        foreach ($this->attributes as $key => $value) {
            if ($key == 'orgs' || $key == 'responsible' || $key == 'volunteer') continue;
            $event->$key = $value;
        }

        $event->status = 0;
        $event->save();

        $event = Event::find()->where(['name' => $this->name])->one();

        $dep->user_id = Yii::$app->user->getId();
        $dep->event_id = $event->id;
        $dep->role = Event::ROLE_MANAGER;
        $dep->save();

        if ($this->orgs) {
            foreach ($this->orgs as $org) {
                $dep = new EventToUser();
                $dep->user_id = $org;
                $dep->event_id = $event->id;
                $dep->role = Event::ROLE_ORGANIZER;
                $dep->save();
            }
        }

        if ($this->volunteer) {
            foreach ($this->volunteer as $org) {
                $dep = new EventToUser();
                $dep->user_id = $org;
                $dep->event_id = $event->id;
                $dep->role = Event::ROLE_VOLUNTEER;
                $dep->save();
            }
        }

        if ($this->responsible) {
            foreach ($this->responsible as $org) {
                $dep = new EventToUser();
                $dep->user_id = $org;
                $dep->event_id = $event->id;
                $dep->role = Event::ROLE_WORKER;
                $dep->save();
            }
        }

        return true;
    }

    public function change($eid) {
        if (!$this->validate())
            return false;

        $event = Event::findIdentity($eid);
        foreach ($this->attributes as $key => $value) {
            if ($key == 'orgs' || $key == 'responsible' || $key == 'volunteer') continue;
            $event->$key = $value;
        }

        $todel = EventToUser::find()->where(['event_id' => $eid])->andWhere(['<>', 'role', Event::ROLE_MANAGER])->all();
        foreach ($todel as $del) {
            $del -> delete();
        }

        if ($this->orgs) {
            foreach ($this->orgs as $org) {
                $dep = new EventToUser();
                $dep->user_id = $org;
                $dep->event_id = $event->id;
                $dep->role = Event::ROLE_ORGANIZER;
                $dep->save();
            }
        }

        if ($this->volunteer) {
            foreach ($this->volunteer as $org) {
                $dep = new EventToUser();
                $dep->user_id = $org;
                $dep->event_id = $event->id;
                $dep->role = Event::ROLE_VOLUNTEER;
                $dep->save();
            }
        }

        if ($this->responsible) {
            foreach ($this->responsible as $org) {
                $dep = new EventToUser();
                $dep->user_id = $org;
                $dep->event_id = $event->id;
                $dep->role = Event::ROLE_WORKER;
                $dep->save();
            }
        }

        $event->status = 0;
        $event->save();

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
            'cluborg' => 'Количество организаторов от клуба',
            'orgs' => 'Выберите организаторов мероприятия',
            'volunteer' => 'Выберите волонтеров мероприятия',
            'responsible' => 'Выберите ответственных исполнителей мероприятия',
            'linksmedia' => 'Ссылки на медиа ресурсы',
        ];
    }

    public function attributeHints()
    {
        return [
            'date' => 'Формат: дд.мм.гггг-дд.мм.гггг, если больше одного дня',
            'links' => 'Посты в IS, Ягодном, ссылки на группы мероприятий',
            'orgs' => 'Себя выбирать НЕ нужно!',
            'linksmedia' => 'Ссылки на фото и видео',
        ];
    }

    public function attributePlaceholders() {
        return [
            'date' => 'дд.мм.гггг'
        ];
    }
}