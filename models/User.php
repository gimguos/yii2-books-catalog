<?php


namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Модель пользователя.
 */
class User extends ActiveRecord implements IdentityInterface
{
    public function behaviors()
    {
        return [
            TimestampBehavior::class, // Автоматически заполняет created_at и updated_at
        ];
    }
    /**
     * Название таблицы в базе данных.
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * Правила валидации.
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password_hash'], 'required'],
            ['username', 'string', 'max' => 255],
            ['email', 'email'],
            ['email', 'unique'],
        ];
    }


    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * Проверка пароля.
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Хеширует пароль.
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Генерирует ключ аутентификации.
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Методы интерфейса IdentityInterface.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
}