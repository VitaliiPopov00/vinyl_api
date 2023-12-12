<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "album_genre".
 *
 * @property int $album_id
 * @property int $genre_id
 *
 * @property Album $album
 * @property Genre $genre
 */
class AlbumGenre extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'album_genre';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['album_id', 'genre_id'], 'required'],
            [['album_id', 'genre_id'], 'integer'],
            [['genre_id'], 'exist', 'skipOnError' => true, 'targetClass' => Genre::class, 'targetAttribute' => ['genre_id' => 'id']],
            [['album_id'], 'exist', 'skipOnError' => true, 'targetClass' => Album::class, 'targetAttribute' => ['album_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'album_id' => 'Album ID',
            'genre_id' => 'Genre ID',
        ];
    }

    /**
     * Gets query for [[Album]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAlbum()
    {
        return $this->hasOne(Album::class, ['id' => 'album_id']);
    }

    /**
     * Gets query for [[Genre]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGenre()
    {
        return $this->hasOne(Genre::class, ['id' => 'genre_id']);
    }
}
