<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property int $type_id
 * @property int $user_id
 * @property string $title
 * @property string $description
 * @property int $visibility_id
 * @property string $created_at
 *
 * @property BoardPost[] $boardPosts
 * @property Board[] $boards
 * @property Favorites[] $favorites
 * @property GenerationItem[] $generationItems
 * @property Generation[] $generations
 * @property Image[] $images
 * @property ItemLink[] $itemLinks
 * @property Post[] $items
 * @property Like[] $likes
 * @property Link[] $links
 * @property OutfitItem[] $outfitItems
 * @property OutfitItem[] $outfitItems0
 * @property Post[] $outfits
 * @property PostCategory $postCategory
 * @property PostImage[] $postImages
 * @property PostTag[] $postTags
 * @property Tag[] $tags
 * @property PostType $type
 * @property User $user
 * @property User[] $users
 * @property User[] $users0
 * @property User[] $users1
 * @property Visibility $visibility
 * @property Wardrobe[] $wardrobes
 */
class Post extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type_id', 'user_id', 'title', 'description', 'visibility_id'], 'required'],
            [['type_id', 'user_id', 'visibility_id'], 'integer'],
            [['description'], 'string'],
            [['created_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => PostType::class, 'targetAttribute' => ['type_id' => 'id']],
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
            'type_id' => 'Type ID',
            'user_id' => 'User ID',
            'title' => 'Title',
            'description' => 'Description',
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
        return $this->hasMany(BoardPost::class, ['post_id' => 'id']);
    }

    /**
     * Gets query for [[Boards]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBoards()
    {
        return $this->hasMany(Board::class, ['id' => 'board_id'])->viaTable('board_post', ['post_id' => 'id']);
    }

    /**
     * Gets query for [[Favorites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavorites()
    {
        return $this->hasMany(Favorites::class, ['post_id' => 'id']);
    }

    /**
     * Gets query for [[GenerationItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGenerationItems()
    {
        return $this->hasMany(GenerationItem::class, ['post_id' => 'id']);
    }

    /**
     * Gets query for [[Generations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGenerations()
    {
        return $this->hasMany(Generation::class, ['id' => 'generation_id'])->viaTable('generation_item', ['post_id' => 'id']);
    }

    /**
     * Gets query for [[Images]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(Image::class, ['id' => 'image_id'])->viaTable('post_image', ['post_id' => 'id']);
    }

    /**
     * Gets query for [[ItemLinks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getItemLinks()
    {
        return $this->hasMany(ItemLink::class, ['post_id' => 'id']);
    }

    /**
     * Gets query for [[Items]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(Post::class, ['id' => 'item_id'])->viaTable('outfit_item', ['outfit_id' => 'id']);
    }

    /**
     * Gets query for [[Likes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLikes()
    {
        return $this->hasMany(Like::class, ['post_id' => 'id']);
    }

    /**
     * Gets query for [[Links]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinks()
    {
        return $this->hasMany(Link::class, ['id' => 'link_id'])->viaTable('item_link', ['post_id' => 'id']);
    }

    /**
     * Gets query for [[OutfitItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOutfitItems()
    {
        return $this->hasMany(OutfitItem::class, ['item_id' => 'id']);
    }

    /**
     * Gets query for [[OutfitItems0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOutfitItems0()
    {
        return $this->hasMany(OutfitItem::class, ['outfit_id' => 'id']);
    }

    /**
     * Gets query for [[Outfits]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOutfits()
    {
        return $this->hasMany(Post::class, ['id' => 'outfit_id'])->viaTable('outfit_item', ['item_id' => 'id']);
    }

    /**
     * Gets query for [[PostCategory]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPostCategory()
    {
        return $this->hasOne(PostCategory::class, ['post_id' => 'id']);
    }

    /**
     * Gets query for [[PostImages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPostImages()
    {
        return $this->hasMany(PostImage::class, ['post_id' => 'id']);
    }

    /**
     * Gets query for [[PostTags]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPostTags()
    {
        return $this->hasMany(PostTag::class, ['post_id' => 'id']);
    }

    /**
     * Gets query for [[Tags]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])->viaTable('post_tag', ['post_id' => 'id']);
    }

    /**
     * Gets query for [[Type]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(PostType::class, ['id' => 'type_id']);
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
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['id' => 'user_id'])->viaTable('favorites', ['post_id' => 'id']);
    }

    /**
     * Gets query for [[Users0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers0()
    {
        return $this->hasMany(User::class, ['id' => 'user_id'])->viaTable('like', ['post_id' => 'id']);
    }

    /**
     * Gets query for [[Users1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers1()
    {
        return $this->hasMany(User::class, ['id' => 'user_id'])->viaTable('wardrobe', ['post_id' => 'id']);
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

    /**
     * Gets query for [[Wardrobes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWardrobes()
    {
        return $this->hasMany(Wardrobe::class, ['post_id' => 'id']);
    }

}
