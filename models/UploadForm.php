<?php
/**
 * Created by PhpStorm.
 * User: kuratovevgenij
 * Date: 10/07/2019
 * Time: 14:09
 */

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;
use Yii;
use app\models\User;

class UploadForm extends Model {

    public $image;

    public function rules(){
        return[
            [['image'], 'file', 'extensions' => 'png, jpg'],
            [['image'], 'file', 'maxSize' => 20000000]
        ];
    }

    public function upload($uid){
        if(!$this->validate()) return false;

        $filename = $this->formFileName();
        $this->image->saveAs("files/avatars/".$filename);

        $user = User::findIdentity($uid);

        unlink("files/avatars/".$user->img_url);

        $user->img_url = $filename;
        $user->save();
    }

    private function formFileName()
        {
            $timestamp = new \DateTime();
            $timestamp = $timestamp->getTimestamp();
            $filename =  $timestamp . '.' . $this->image->extension;
            return $filename;
        }

}