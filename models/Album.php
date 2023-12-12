<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "album".
 *
 * @property int $id
 * @property string $title
 * @property int $artist_id
 * @property int $year_release_album
 * @property int $year_release_plate
 * @property int $price
 * @property string $logo
 *
 * @property AlbumGenre[] $albumGenres
 * @property Artist $artist
 */
class Album extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'album';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'artist_id', 'year_release_album', 'year_release_plate', 'price', 'logo'], 'required'],
            [['artist_id', 'year_release_album', 'year_release_plate', 'price'], 'integer'],
            [['title', 'logo'], 'string', 'max' => 255],
            [['artist_id'], 'exist', 'skipOnError' => true, 'targetClass' => Artist::class, 'targetAttribute' => ['artist_id' => 'id']],
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
            'artist_id' => 'Artist ID',
            'year_release_album' => 'Year Release Album',
            'year_release_plate' => 'Year Release Plate',
            'price' => 'Price',
            'logo' => 'Logo',
        ];
    }

    /**
     * Gets query for [[AlbumGenres]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAlbumGenres()
    {
        return $this->hasMany(AlbumGenre::class, ['album_id' => 'id']);
    }

    /**
     * Gets query for [[Artist]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArtist()
    {
        return $this->hasOne(Artist::class, ['id' => 'artist_id']);
    }

    public static function getAlbumList()
    {
        $albums = [];

        foreach (static::find()->all() as $album) {
            $albums[] = [
                "id" => $album->id,
                "title" => $album->title,
                "artist" => Artist::findOne($album->artist_id),
                "genres" => AlbumGenre::getGenreList($album->id),
                "year_release_album" => $album->year_release_album,
                "year_release_plate" => $album->year_release_plate,
                "price" => $album->price,
                "logo" => $album->logo,
            ];
        }

        return $albums 
            ? $albums 
            : null;
    }

    public static function getAlbum($id)
    {
        $album = static::findOne($id);

        return $album 
            ? [
                "id" => $album->id,
                "title" => $album->title,
                "artist" => Artist::findOne($album->artist_id),
                "genres" => AlbumGenre::getGenreList($album->id),
                "year_release_album" => $album->year_release_album,
                "year_release_plate" => $album->year_release_plate,
                "price" => $album->price,
                "logo" => $album->logo,
            ]
            : null;
    }
}
