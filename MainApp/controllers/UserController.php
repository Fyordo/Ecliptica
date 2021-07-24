<?php

namespace app\controllers;

use app\models\DbModels\Users;

class UserController extends \yii\web\Controller
{
    public function actionPage($id)
    {
        $pageOwner = null;

        $UserFromDB = Users::findOne($id);

        if (isset($UserFromDB)){
            $pageOwner = [
                'id' => $UserFromDB->attributes["id"],
                'username' => $UserFromDB->attributes["name"],
                'link' => $UserFromDB->attributes["link"],
                'password' => $UserFromDB->attributes["password"],
            ];
        }

        return $this->render('page', [
            'page_owner' => $pageOwner
        ]);
    }

}
