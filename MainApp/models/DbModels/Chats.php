<?php

namespace app\models\DbModels;

use Yii;

/**
 * This is the model class for table "chats".
 *
 * @property int $id
 * @property string $title
 * @property string $link
 */
class Chats extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chats';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'title', 'link'], 'required'],
            [['id'], 'integer'],
            [['title', 'link'], 'string'],
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
            'title' => 'Title',
            'link' => 'Link',
        ];
    }
}
