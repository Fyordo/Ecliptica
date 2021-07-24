<?php


namespace app\models\Forms;


use yii\base\Model;

class AddAdminForm extends Model
{
    public $userLink;

    public function rules()
    {
        return [
            [['userLink'], 'required']
        ];
    }
}