<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "image".
 *
 * @property int $id
 * @property string $path
 * @property string $created_at
 *
 * @property GenerationImage[] $generationImages
 * @property Generation[] $generations
 * @property PostImage[] $postImages
 * @property Post[] $posts
 */
class Image extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'image';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['path'], 'required'],
            [['created_at'], 'safe'],
            [['path'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'path' => 'Path',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[GenerationImages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGenerationImages()
    {
        return $this->hasMany(GenerationImage::class, ['image_id' => 'id']);
    }

    /**
     * Gets query for [[Generations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGenerations()
    {
        return $this->hasMany(Generation::class, ['id' => 'generation_id'])->viaTable('generation_image', ['image_id' => 'id']);
    }

    /**
     * Gets query for [[PostImages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPostImages()
    {
        return $this->hasMany(PostImage::class, ['image_id' => 'id']);
    }

    /**
     * Gets query for [[Posts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::class, ['id' => 'post_id'])->viaTable('post_image', ['image_id' => 'id']);
    }

}
