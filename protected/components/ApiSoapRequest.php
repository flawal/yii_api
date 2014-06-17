<?php
/**
 * Server-side Api Soap Request handler
 */
class ApiSoapRequest extends ApiRequest
{
    /**
    * Return service type.
    * @see ApiRequest::getServiceType()
    */
    public function getServiceType()
    {
        return ApiRequest::SOAP;
    }

    /**
    * Parse params from request.
    * @return array
    */
    public static function getParamsFromRequest()
    {
        //@TODO: utilize CWebService to encapsulate wsdl-based SOAP calls

        // return $params;
    }

    private function _call()
    {

    }
}