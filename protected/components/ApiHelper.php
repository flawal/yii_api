<?php
/**
 * Api helper class
 */
class ApiHelper extends CApplicationComponent
{
    /**
     * Get params from request, depending on request type(REST or SOAP)
     */
    public function getRequestParams()
    {
        $requestClassName = $this->getRequestClassName();
        $params = $requestClassName::getParamsFromRequest();
        return $params;
    }

    /**
     * Generate response
     * @param ApiResult $result
     */
    public function sendResponse(ApiResult $result)
    {
        $responseClassName = $this->getResponseClassName();
        $responseClassName::generateOutput($result);
    }

    /**
     * Get request class name
     * @return string
     */
    protected function getRequestClassName()
    {
        $requestType = Yii::app()->apiRequest->getRequestType();
        if ($requestType == ApiRequest::REST) {
            return 'ApiRestRequest';
        } elseif ($requestType == ApiRequest::SOAP) {
            return 'ApiSoapRequest';
        } else {
            throw new CException('Invalid API request type.');
        }
    }

    /**
     * Get response class name
     * @return string
     */
    protected function getResponseClassName()
    {
        $responseType = Yii::app()->apiRequest->getResponseFormat();
        if ($responseType == ApiRequest::JSON_FORMAT) {
            return 'ApiJsonResponse';
        } elseif ($responseType == ApiRequest::XML_FORMAT) {
            return 'ApiXmlResponse';
        } else {
            throw new CException('Invalid response type.');
        }
    }
}