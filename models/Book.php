<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Модель для таблицы "book".
 *
 * @property int $id
 * @property string $title
 * @property int $year
 * @property string|null $description
 * @property string $isbn
 * @property string|null $cover_image
 *
 * @property Author[] $authors
 * @property BookAuthor[] $bookAuthors
 */
class Book extends ActiveRecord
{
    public $authorIds; // Временное свойство для хранения выбранных авторов

    public static function tableName()
    {
        return 'book';
    }

    public function rules()
    {
        return [
            [['title', 'year', 'description', 'isbn'], 'required'],
            [['year'], 'integer'],
            [['description'], 'string'],
            [['title', 'isbn'], 'string', 'max' => 255],
            [['cover_image'], 'file', 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'year' => 'Год выпуска',
            'description' => 'Описание',
            'isbn' => 'ISBN',
            'cover_image' => 'Фото обложки',
        ];
    }

    /**
     * Сохранение фотографии книги
     *
     * @return bool
     */
    public function savePhoto()
    {
        $uploadPath = Yii::getAlias('@webroot/img/uploads');

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0775, true); // Создаем директорию, если её нет
        }

        if ($this->validate(['cover_image'])) {
            $path = Yii::getAlias('@webroot/img/uploads/' . $this->id . '.' . $this->cover_image->extension);
            $this->cover_image->saveAs(basename($path));
            $this->cover_image = basename($path);

            return true;
        }
        return false;
    }

    /**
     * Получение полного пути к фотографии книги
     *
     * @return string|null
     */
    public function getPhotoUrl()
    {
        if ($this->cover_image) {

            $uploadPath = Yii::getAlias('@webroot/img/uploads/');
            $filePath = $uploadPath . $this->cover_image;

            if (is_file($filePath))
                return Yii::getAlias('@web/img/uploads/' . $this->cover_image);
        }
        return Yii::getAlias('@web/img/default-image.jpg');
    }

    public function saveAuthors($authorIds)
    {
        if (!empty($authorIds)) {
            foreach ($authorIds as $authorId) {
                $this->link('authors', Author::findOne($authorId));
            }
        }
    }

    public function getAuthors()
    {
        return $this->hasMany(Author::class, ['id' => 'author_id'])
            ->viaTable('book_author', ['book_id' => 'id']);
    }


    /**
     * Gets query for [[BookAuthors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBookAuthors()
    {
        return $this->hasMany(BookAuthor::class, ['book_id' => 'id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if ($insert) { // Если книга добавлена
            $this->notifySubscribers();
        }
    }

    protected function notifySubscribers()
    {
        $authorIds = $this->getAuthors()->select('id')->column();
        $subscriptions = Subscription::find()->where(['author_id' => $authorIds])->all();

        foreach ($subscriptions as $subscription) {
            $message = "Новая книга автора {$this->authors[0]->name}: {$this->title}";
            $this->sendSms($subscription->phone, $message);
        }
    }

    protected function sendSms($phone, $message)
    {
        // todo Реализовать массовую отправку массива, логирование
        $apiKey = 'XXXXXXXXXXXXYYYYYYYYYYYYZZZZZZZZXXXXXXXXXXXXYYYYYYYYYYYYZZZZZZZZ'; // Ключ эмулятора
        $url = "https://smspilot.ru/api.php?send={$message}&to={$phone}&apikey={$apiKey}";

        $response = file_get_contents($url);

        return $response;
    }
}
