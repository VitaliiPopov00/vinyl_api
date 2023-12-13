<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "artist".
 *
 * @property int $id
 * @property string $title
 *
 * @property Album[] $albums
 */
class Artist extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'artist';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
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
        ];
    }

    public static function getArtistInfo($id)
    {
        if (($artist = static::findOne($id))) {
            return [
                'id' => $artist->id,
                'title' => $artist->title,
                'albums' => Album::getArtistAlbums($artist->id),
            ];
        } else {
            return [];
        }
    }

    public static function getArtistList()
    {
        if (($artists = static::find()->all())) {
            $artistsResult = [];

            foreach ($artists as $artist) {
                $artistsResult[] = static::getArtistInfo($artist->id);
            }

            return $artistsResult;
        } else {
            return [];
        }
    }

    /**
     * Gets query for [[Albums]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAlbums()
    {
        return $this->hasMany(Album::class, ['artist_id' => 'id']);
    }
}
