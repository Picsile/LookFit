<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "visibility".
 *
 * @property int $id
 * @property string $title
 *
 * @property Board[] $boards
 * @property Post[] $posts
 */
class Visibility extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'visibility';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
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
        ];
    }

    /**
     * Gets query for [[Boards]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBoards()
    {
        return $this->hasMany(Board::class, ['visibility_id' => 'id']);
    }

    /**
     * Gets query for [[Posts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::class, ['visibility_id' => 'id']);
    }

}
