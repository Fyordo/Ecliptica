<?php

namespace app\models\DbModels;

use Yii;

/**
 * This is the model class for table "chat_binds".
 *
 * @property int $record_id
 * @property int $user_id
 * @property string $chat_link
 * @property int $isadmin
 */
class ChatBinds extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chat_binds';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'chat_link', 'isadmin'], 'required'],
            [['record_id', 'user_id', 'isadmin'], 'integer'],
            [['chat_link'], 'string', 'max' => 255],
            [['record_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'record_id' => 'Record ID',
            'user_id' => 'User ID',
            'chat_link' => 'Chat Link',
            'isadmin' => 'Isadmin',
        ];
    }
}
