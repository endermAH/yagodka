<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;
use yii\helpers\Html;

class ContactForm extends Model
{
    //Регэксп взят из недр yii
    const VALID_EMAIL = '/^[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/';
    public $phone;
    public $email;
    public $isu;
    public $vk;


    public function rules()
    {
        return [
            [['phone', 'email', 'isu', 'vk'], 'required', 'message' => "Это поле не может быть пустым"],
            ['email', 'match', 'pattern' => self::VALID_EMAIL],
            //['isu', 'integer', 'min' => 100000, 'max' => 9999999],

        ];
    }

    public function register()
    {
        if (!$this->validate())
            return false;

        $user = Yii::$app->user->identity;
        foreach ($this->attributes as $key => $value) {
            $attr = UserAttributes::find()->where(['user_id' => Yii::$app->user->identity->getId(), 'attribute_name' => $key])->one();
            $attr = $attr ? $attr : new UserAttributes();
            $attr->user_id = $user->id;
            $attr->attribute_name = $key;
            $attr->attribute_value = $value;
            $attr->save();
        }
        return true;
    }


    public function attributeLabels()
    {
        return [
            'encodeLabel' => false,
            'phone' => "Номер телефона",
            'email' => 'email',
            'isu' => 'Номер в ИСУ',
            'vk' => 'Ссылка ВК',
        ];
    }

    public function attributeHints()
    {
        return [
        ];
    }
}