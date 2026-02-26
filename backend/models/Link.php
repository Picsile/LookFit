<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "link".
 *
 * @property int $id
 * @property string $url
 *
 * @property ItemLink[] $itemLinks
 * @property Post[] $posts
 */
class Link extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'link';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['url'], 'required'],
            [['url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Url',
        ];
    }

    /**
     * Gets query for [[ItemLinks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getItemLinks()
    {
        return $this->hasMany(ItemLink::class, ['link_id' => 'id']);
    }

    /**
     * Gets query for [[Posts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::class, ['id' => 'post_id'])->viaTable('item_link', ['link_id' => 'id']);
    }

}
