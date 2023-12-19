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
            'title' => 'Название',
            'artist_id' => 'Artist ID',
            'year_release_album' => 'Год релиза альбома',
            'year_release_plate' => 'Год релиза пластинки',
            'price' => 'Цена',
            'logo' => 'Обложка',
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

    public static function getAlbum($id)
    {
        $album = static::findOne($id);

        return $album 
            ? [
                "id" => $album->id,
                "title" => $album->title,
                "artist" => Artist::findOne($album->artist_id),
                "genres" => AlbumGenre::getGenreListForAlbum($album->id),
                "year_release_album" => $album->year_release_album,
                "year_release_plate" => $album->year_release_plate,
                "price" => $album->price,
                "logo" => $album->logo,
            ]
            : [];
    }

    public static function getAlbumList()
    {
        $albumsResult = [];
        $albums = static::find()
            ->innerJoin('artist', 'artist.id = album.artist_id')
            ->innerJoin('album_genre', 'album_genre.album_id = album.id')
            ->innerJoin('genre', 'genre.id = album_genre.genre_id');
        
        $title = Yii::$app->request->get('title', '');
        $artist = Yii::$app->request->get('artist', '');
        $genre = Yii::$app->request->get('genre', '');
        $startPrice = Yii::$app->request->get('startPrice', 0);
        $endPrice = Yii::$app->request->get('endPrice', 999999999);

        if ($title) { $albums->where(['like', 'album.title', $title]); }
        if ($artist) { $albums->andWhere(['like', 'artist.title', $artist]); }
        if ($genre) { $albums->andWhere(['like', 'genre.title', $genre]); }
        $albums->andWhere(['>=', 'price', $startPrice]);
        $albums->andWhere(['<=', 'price', $endPrice]);

        $albums = $albums->all();

        foreach ($albums as $album) {
            $albumsResult[] = static::getAlbum($album->id);
        }

        return $albumsResult;
    }

    public static function getArtistAlbums($artistID)
    {
        $albumsResult = [];
        $albums = static::findAll(['artist_id' => $artistID]);

        foreach ($albums as $album) {
            $albumsResult[] = static::getAlbum($album->id);
        }

        return $albumsResult;
    }
}
