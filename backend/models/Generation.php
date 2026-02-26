<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "generation".
 *
 * @property int $id
 * @property int $user_id
 * @property string $prompt
 * @property int $resolution_id
 * @property int $ratio_id
 * @property int $created_at
 *
 * @property GenerationImage[] $generationImages
 * @property GenerationItem[] $generationItems
 * @property Image[] $images
 * @property Post[] $posts
 * @property Ratio $ratio
 * @property Resolution $resolution
 * @property User $user
 */
class Generation extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'generation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'prompt', 'resolution_id', 'ratio_id', 'created_at'], 'required'],
            [['user_id', 'resolution_id', 'ratio_id', 'created_at'], 'integer'],
            [['prompt'], 'string'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['ratio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ratio::class, 'targetAttribute' => ['ratio_id' => 'id']],
            [['resolution_id'], 'exist', 'skipOnError' => true, 'targetClass' => Resolution::class, 'targetAttribute' => ['resolution_id' => 'id']],
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
            'prompt' => 'Prompt',
            'resolution_id' => 'Resolution ID',
            'ratio_id' => 'Ratio ID',
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
        return $this->hasMany(GenerationImage::class, ['generation_id' => 'id']);
    }

    /**
     * Gets query for [[GenerationItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGenerationItems()
    {
        return $this->hasMany(GenerationItem::class, ['generation_id' => 'id']);
    }

    /**
     * Gets query for [[Images]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(Image::class, ['id' => 'image_id'])->viaTable('generation_image', ['generation_id' => 'id']);
    }

    /**
     * Gets query for [[Posts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::class, ['id' => 'post_id'])->viaTable('generation_item', ['generation_id' => 'id']);
    }

    /**
     * Gets query for [[Ratio]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRatio()
    {
        return $this->hasOne(Ratio::class, ['id' => 'ratio_id']);
    }

    /**
     * Gets query for [[Resolution]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResolution()
    {
        return $this->hasOne(Resolution::class, ['id' => 'resolution_id']);
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

}
