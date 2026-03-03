<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $login
 * @property string $password
 * @property string $email
 * @property string|null $phone
 * @property string|null $avatar_path
 * @property string|null $background_path
 * @property int $role_id
 * @property string $auth_key
 *
 * @property Board[] $boards
 * @property Favorites[] $favorites
 * @property Generation[] $generations
 * @property Like[] $likes
 * @property Post[] $posts
 * @property Post[] $posts0
 * @property Post[] $posts1
 * @property Post[] $posts2
 * @property ReasonDelete[] $reasonDeletes
 * @property Role $role
 * @property Wardrobe[] $wardrobes
 */
class User extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['phone', 'avatar_path', 'background_path'], 'default', 'value' => null],
            [['role_id'], 'default', 'value' => 1],
            [['username', 'login', 'password', 'email', 'auth_key'], 'required'],
            [['role_id'], 'integer'],
            [['username', 'login', 'password', 'email', 'phone', 'avatar_path', 'background_path', 'auth_key'], 'string', 'max' => 255],
            [['login'], 'unique'],
            [['email'], 'unique'],
            [['login', 'email'], 'unique', 'targetAttribute' => ['login', 'email']],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Role::class, 'targetAttribute' => ['role_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'login' => 'Login',
            'password' => 'Password',
            'email' => 'Email',
            'phone' => 'Phone',
            'avatar_path' => 'Avatar Path',
            'background_path' => 'Background Path',
            'role_id' => 'Role ID',
            'auth_key' => 'Auth Key',
        ];
    }

    /**
     * Gets query for [[Boards]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBoards()
    {
        return $this->hasMany(Board::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Favorites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavorites()
    {
        return $this->hasMany(Favorites::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Generations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGenerations()
    {
        return $this->hasMany(Generation::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Likes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLikes()
    {
        return $this->hasMany(Like::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Posts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Posts0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosts0()
    {
        return $this->hasMany(Post::class, ['id' => 'post_id'])->viaTable('favorites', ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Posts1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosts1()
    {
        return $this->hasMany(Post::class, ['id' => 'post_id'])->viaTable('like', ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Posts2]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosts2()
    {
        return $this->hasMany(Post::class, ['id' => 'post_id'])->viaTable('wardrobe', ['user_id' => 'id']);
    }

    /**
     * Gets query for [[ReasonDeletes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReasonDeletes()
    {
        return $this->hasMany(ReasonDelete::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Role]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::class, ['id' => 'role_id']);
    }

    /**
     * Gets query for [[Wardrobes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWardrobes()
    {
        return $this->hasMany(Wardrobe::class, ['user_id' => 'id']);
    }

}
