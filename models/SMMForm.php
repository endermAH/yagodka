<?php
/**
 * Created by PhpStorm.
 * User: kuratovevgenij
 * Date: 10/09/2019
 * Time: 12:40
 */

namespace app\models;


use yii\base\Model;
use app\models\User;
use yii\helpers\Html;

class SMMForm extends Model
{

    public static $post_costs = [
        'Пост в инстаграмм' => 5,
        'Пост в ВК' => 10,
        'Статья в ВК' => 20
    ];

    public static $post_types = [
        'Пост в инстаграмм',
        'Пост в ВК',
        'Статья в ВК'
    ];

    public $name;
    public $type;
    public $link;
    public $user_id;

    public function rules()
    {
        return [
            ['name', 'required', 'message' => 'Введите описание поста'],
            ['type', 'required', 'message' => 'Выберите тип поста'],
            ['link', 'required', 'message' => 'Введите ссылку на пост'],
            ['user_id', 'required', 'message' => 'Выберите автора поста']
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Опишите пост',
            'type' => 'Тип поста',
            'link' => 'Ссылка на пост',
            'user_id' => 'Автор поста'
        ];
    }

    public function attributeHints()
    {
        return [
            'name' => 'Очень кратко - например "пост про собрания от 32.13.1945"',
        ];
    }

    public function addPost() {
        if ($this->validate()) {
            $post = new Post();
            $post->name = $this->name;
            $post->type = $this->type;
            $post->link = $this->link;
            $post->save();

//            echo '<pre>';
//            var_dump($this);
//            echo '</pre>';

            $rating = new Rating();
            $rating->user_id = $this->user_id;
            $rating->count = self::$post_costs[self::$post_types[$this->type]];
            $rating->comment = Html::a(self::$post_types[$this->type],$this->link);
            $rating->service = 1000000 + $post->id;

            $user = User::findIdentity($this->user_id);
            $user->cash += self::$post_costs[self::$post_types[$this->type]];

            return $user->save() && $rating->save();
        }
    }
}