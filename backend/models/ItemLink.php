<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "item_link".
 *
 * @property int $post_id
 * @property int $link_id
 *
 * @property Link $link
 * @property Post $post
 */
class ItemLink extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'item_link';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id', 'link_id'], 'required'],
            [['post_id', 'link_id'], 'integer'],
            [['post_id', 'link_id'], 'unique', 'targetAttribute' => ['post_id', 'link_id']],
            [['link_id'], 'exist', 'skipOnError' => true, 'targetClass' => Link::class, 'targetAttribute' => ['link_id' => 'id']],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::class, 'targetAttribute' => ['post_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'post_id' => 'Post ID',
            'link_id' => 'Link ID',
        ];
    }

    /**
     * Gets query for [[Link]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLink()
    {
        return $this->hasOne(Link::class, ['id' => 'link_id']);
    }

    /**
     * Gets query for [[Post]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::class, ['id' => 'post_id']);
    }

}
