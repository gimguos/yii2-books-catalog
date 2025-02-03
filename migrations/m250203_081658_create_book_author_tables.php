<?php

use yii\db\Migration;

/**
 * Миграция для создания таблиц `book`, `author`, `book_author`.
 */
class m250203_081658_create_book_author_tables extends Migration
{
    public function safeUp()
    {
        // Таблица book
        $this->createTable('{{%book}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'year' => $this->integer()->notNull(),
            'description' => $this->text(),
            'isbn' => $this->string()->notNull(),
            'cover_image' => $this->string(),
        ]);

        // Таблица author
        $this->createTable('{{%author}}', [
            'id' => $this->primaryKey(),
            'full_name' => $this->string()->notNull(),
        ]);

        // Таблица book_author (связь многие-ко-многим)
        $this->createTable('{{%book_author}}', [
            'book_id' => $this->integer()->notNull(),
            'author_id' => $this->integer()->notNull(),
            'PRIMARY KEY(book_id, author_id)',
        ]);

        // Внешние ключи
        $this->addForeignKey(
            'fk-book_author-book_id',
            '{{%book_author}}',
            'book_id',
            'book',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-book_author-author_id',
            '{{%book_author}}',
            'author_id',
            'author',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%book_author}}');
        $this->dropTable('{{%book}}');
        $this->dropTable('{{%author}}');
    }
}
