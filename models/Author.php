<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Модель для таблицы "author".
 *
 * @property int $id
 * @property string $full_name
 *
 * @property BookAuthor[] $bookAuthors
 * @property Book[] $books
 */
class Author extends ActiveRecord
{
    public $book_count;

    public static function tableName()
    {
        return 'author';
    }

    public function rules()
    {
        return [
            [['full_name'], 'required'],
            [['full_name'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'full_name' => 'Автор',
        ];
    }

    /**
     * Gets query for [[BookAuthors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBookAuthors()
    {
        return $this->hasMany(BookAuthor::class, ['author_id' => 'id']);
    }

    /**
     * Gets query for [[Books]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBooks()
    {
        return $this->hasMany(Book::class, ['id' => 'book_id'])->viaTable('book_author', ['author_id' => 'id']);
    }
}
