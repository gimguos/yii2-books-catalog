<?php

use yii\db\Migration;

/**
 * Миграция для создания данных, связанных с RBAC.
 */
class m250203_080658_init_rbac_roles extends Migration
{
    /**
     * Применяет миграцию.
     * Создает роли и разрешения для RBAC: auth_rule, auth_item, auth_item_child, auth_assignment.
     * На базе комплекта миграций @yii/rbac/migrations
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        // Создаем разрешение "viewBooks"
        $viewBooks = $auth->createPermission('viewBooks');
        $viewBooks->description = 'Просмотр книг';
        $auth->add($viewBooks);

        // Создаем разрешение "manageBooks"
        $manageBooks = $auth->createPermission('manageBooks');
        $manageBooks->description = 'Управление книгами';
        $auth->add($manageBooks);

        // Создаем роль "user" и даем ей разрешение "viewBooks" и "manageBooks"
        $user = $auth->createRole('user');
        $auth->add($user);
        $auth->addChild($user, $viewBooks);
        $auth->addChild($user, $manageBooks);

        // Создаем роль "admin"
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $user); // Админ также имеет права пользователя
    }

    /**
     * Откатывает миграцию.
     * Удаляет все роли и разрешения, созданные в safeUp().
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;

        // Удаляем все роли и разрешения
        $auth->removeAll();
    }
}
