<?php
/**
 * Created by PhpStorm.
 * User: kuratovevgenij
 * Date: 10/04/2019
 * Time: 17:54
 */

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

class RegistrationForm extends Model
{
    //Регэксп взят из недр yii
    const VALID_EMAIL = '/^[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/';
    public $username;
    public $password;
    public $name;
    public $surname;
    public $patronymic;
    public $role_id;
    public $status;
    public $password_repeat;
    public $berry;

    public function rules()
    {
        return [
            [['username', 'password', 'name', 'surname', 'berry'], 'required', 'message' => "Это поле не может быть пустым"],
            ['username', 'unique', 'targetClass' => User::class, 'message' => 'Этот логин уже занят, используйте другой'],
            ['berry', 'unique', 'targetClass' => User::class, 'message' => 'Эта ягода уже занята, используйте другую'],
            //['email','unique','targetClass'=>User::class,'message' => 'Пользователь с таким адресом уже зарегистрирован'],
            ['username', 'string', 'max' => 64],
            ['berry', 'string', 'max' => 64],
            ['password', 'string', 'min' => 6, 'max' => 128],
            [['name', 'surname', 'patronymic'], 'string', 'max' => 32, 'message' => 'Введенные данные должны содержать меньше 32 символов!'],
            ['username', 'match', 'pattern' => '/^[a-z]\w*$/i', 'message' => 'Имя пользователя не может содержать некоторые символы'],
            //['email', 'match', 'pattern' => self::VALID_EMAIL],
            //['id_itmo', 'integer', 'min' => 100000, 'max' => 9999999],

            // Пока не проверен Админом или менеджером, статус = 0 Непроверенный пользователь
            ['status', 'default', 'value' => User::STATUS_UNAPPROVED],
            ['role_id',  'default', 'value' => User::ROLE_MEMBER],
            [['password', 'password_repeat'], 'required'],
            ['password', 'compare', 'message'=> 'Пароли не совпадают'],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['update'] = ['name', 'surname', 'role_id'];
        $scenarios['register'] = ['username', 'password', 'password_repeat', 'name', 'surname', 'berry', 'role_id', 'status', 'patronymic'];
        return $scenarios;
    }

    public function register()
    {
        if (!$this->validate())
            return false;

        $user = new User;
        $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
        foreach ($this->attributes as $key => $value) {
            if ($key == 'password_repeat') continue;
            $user->$key = $value;
        }
        return $user->save();
    }

    public function update($uid) {
        if (!$this->validate())
            return false;

        $user = User::findOne(['id' => $uid]);
        $user->name = $this->name;
        $user->surname = $this->surname;
        $user->patronymic = $this->patronymic;
        $user->berry = $this->berry;
        $user->role_id = $this->role_id;
        return $user->save();

    }

    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'password' => 'Пароль',
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'patronymic' => 'Отчество',
            'password_repeat' => 'Повторите пароль',
            'berry' => 'Ягодка',
            'role_id' => 'Должность',
        ];
    }

    public function attributeHints()
    {
        return [
            'patronymic' => 'Можно пропустить, если нет',
        ];
    }
}
