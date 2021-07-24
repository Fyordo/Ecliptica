<?php

namespace app\models\DbModels;

use Yii;

/**
 * This is the model class for table "messages".
 *
 * @property int $id
 * @property string $userlink
 * @property string $username
 * @property string $text
 * @property string $time
 * @property string $chatlink
 */
class Messages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'messages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'userlink', 'username', 'text', 'time', 'chatlink'], 'required'],
            [['id'], 'integer'],
            [['userlink', 'username', 'text', 'time', 'chatlink'], 'string'],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userlink' => 'Userlink',
            'username' => 'Username',
            'text' => 'Text',
            'time' => 'Time',
            'chatlink' => 'Chatlink',
        ];
    }
}
