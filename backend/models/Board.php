<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "board".
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property int $visibility_id
 * @property string $created_at
 *
 * @property BoardPost[] $boardPosts
 * @property Post[] $posts
 * @property User $user
 * @property Visibility $visibility
 */
class Board extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'board';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'title', 'visibility_id'], 'required'],
            [['user_id', 'visibility_id'], 'integer'],
            [['created_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['visibility_id'], 'exist', 'skipOnError' => true, 'targetClass' => Visibility::class, 'targetAttribute' => ['visibility_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'title' => 'Title',
            'visibility_id' => 'Visibility ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[BoardPosts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBoardPosts()
    {
        return $this->hasMany(BoardPost::class, ['board_id' => 'id']);
    }

    /**
     * Gets query for [[Posts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::class, ['id' => 'post_id'])->viaTable('board_post', ['board_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Gets query for [[Visibility]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVisibility()
    {
        return $this->hasOne(Visibility::class, ['id' => 'visibility_id']);
    }

}
