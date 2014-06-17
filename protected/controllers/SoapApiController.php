<?php
/**
 * Api class for handling method calls
 */
class SoapApiController extends CBApiController
{
    public function actions()
    {
        return array(
            'service'=>array(
                'class'=>'CWebServiceAction',
                'classMap'=>array(
                    // 'Post'=>'Post',
                ),
            ),
        );
    }

    /**
     * @param string the symbol of the stock
     * @return float the stock price
     * @soap
     */
    public function getPrice($symbol)
    {
        $prices = array('IBM'=>100, 'GOOGLE'=>350);
        return isset($prices[$symbol]) ? $prices[$symbol] : 0;
        //...return stock price for $symbol
    }

    public function actionIndex()
    {
        $result = new ApiResult(ApiResponse::STATUS_SUCCESS, null, 'Welcome to '.Yii::app()->name.' (SOAP)', null, 200);
        Yii::app()->apiHelper->sendResponse($result);
    }

}