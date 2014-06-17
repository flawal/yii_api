<?php
/**
 * Main Api Controller
 * All Api controller classes should extend from this base class.
 */
abstract class ApiController extends CController
{
    public function filters()
    {
        $filters = array(
            'apiRequest'
        );
        return array_merge($filters, parent::filters());
    }

    public function filterApiRequest($filterChain)
    {
        try {
        	// implement Api Access Rights here, before running the application...

            $filterChain->run();
        } catch (Exception $e) {
            $result = new ApiResult(ApiResponse::STATUS_FAILURE, null, $e->getMessage(), null, 400);
            Yii::app()->apiHelper->sendResponse($result);
        }
    }

    /**
     * This is just a sample use case
     * Get model and send response
     */
    public function actionRead()
    {
        $params = Yii::app()->apiHelper->getRequestParams();
        if (!isset($params['id'])) {
            throw new CException('The ID specified was invalid.');
        }
        $result    =  $this->processRead((int)$params['id']);
        Yii::app()->apiHelper->sendResponse($result);
    }

}