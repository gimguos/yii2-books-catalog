<?php

use yii\db\Migration;

/**
 * Миграция для создания таблицы `subscription`.
 */
class m250203_082348_create_subscription_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%subscription}}', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer(),
            'phone' => $this->string()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-subscription-author_id',
            '{{%subscription}}',
            'author_id',
            'author',
            'id',
            'CASCADE'
        );
    }
    
    public function safeDown()
    {
        $this->dropTable('{{%subscription}}');
    }
}
