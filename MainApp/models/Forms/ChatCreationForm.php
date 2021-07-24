<?php

namespace app\models\Forms;

use yii\base\Model;

class ChatCreationForm extends Model
{
    public $title;
    public $link;

    public function rules()
    {
        return [
            [['title', 'link'], 'required']
        ];
    }
}