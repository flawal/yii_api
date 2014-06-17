<?php
/**
 * Api class for handling method calls
 */
class RestApiController extends CBApiController
{
    public function actionIndex()
    {
        $result = new ApiResult(ApiResponse::STATUS_SUCCESS, null, 'Welcome to '.Yii::app()->name.' (REST)', null, 200);
        Yii::app()->apiHelper->sendResponse($result);
    }

    /**
     * Just a sample server-side Api login implementation
     * @return void
     */
    public function actionLogin()
    {
        //@TODO: //Scrap this inlieu of actual implementation
        try {
            $identity = new UserIdentity(Yii::app()->apiRequest->getUsername(), Yii::app()->apiRequest->getPassword());
            $identity->authenticate();
        } catch (Exception $e) {
            throw new CException('An error occured during login. Please try again.');
        }

        if ($identity->errorCode == UserIdentity::ERROR_NONE) {
            Yii::app()->user->login($identity);
            $data['sessionId'] = Yii::app()->getSession()->getSessionID();
            $data['token'] = Yii::app()->session['token'];
            $session = Yii::app()->getSession();

            $result = new ApiResult(ApiResponse::STATUS_SUCCESS, $data, null, null, 200);
            Yii::app()->apiHelper->sendResponse($result);
        } else {
            throw new CException('Invalid username or password.');
        }
    }

    /**
     * Sample server-side Api logout implementation
     * @return void
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        if (Yii::app()->user->isGuest) {
            $result = new ApiResult(ApiResponse::STATUS_SUCCESS, null, null, null, 200);
            Yii::app()->apiHelper->sendResponse($result);
        } else {
            throw new CException('Sign out failed.');
        }
    }

    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            throw new CException($error);
        }
    }
}