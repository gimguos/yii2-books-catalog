<?php

use yii\db\Migration;

class m250203_102735_test_book_author_data extends Migration
{
    public function safeUp()
    {
        // Добавляем авторов
        $authors = [];
        for ($i = 1; $i <= 10; $i++) {
            $authors[] = ["Author {$i}"];
        }
        $this->batchInsert('author', ['full_name'], $authors);

        // Добавляем книги
        $books = [];
        for ($i = 1; $i <= 100; $i++) {
            $books[] = [
                "Book Title {$i}",
                rand(2010, 2025),
                "Description of Book {$i}",
                "ISBN{$i}",
                "cover{$i}.jpg",
            ];
        }
        $this->batchInsert('book', ['title', 'year', 'description', 'isbn', 'cover_image'], $books);

        // Связываем книги с авторами
        $bookAuthor = [];
        for ($i = 1; $i <= 100; $i++) {
            $bookAuthor[] = [$i, rand(1, 10)]; // Каждая книга связана с одним случайным автором
        }
        $this->batchInsert('book_author', ['book_id', 'author_id'], $bookAuthor);
    }

    public function safeDown()
    {
        $this->delete('book_author');
        $this->delete('book');
        $this->delete('author');
    }
}
