<?php


namespace app\models\Forms;

use yii\base\Model;

class ChatSearchForm extends Model
{
    public $link;

    public function rules()
    {
        return [
            [['link'], 'required']
        ];
    }
}