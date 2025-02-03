<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Subscription;
use app\models\Author;

class SubscriptionController extends Controller
{
    /**
     * Подписка на автора.
     */
    public function actionSubscribe($author_id)
    {
        $model = new Subscription();
        $model->author_id = $author_id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Вы успешно подписались!');
            return $this->redirect(['author/view', 'id' => $author_id]);
        }

        return $this->render('subscribe', [
            'model' => $model,
        ]);
    }
}