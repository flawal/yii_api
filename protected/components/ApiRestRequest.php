<?php
/*
 * Api Rest Request Handler
 * Handles Server-side Api Rest Requests
 */
class ApiRestRequest extends ApiRequest
{
    /**
     * Return service type.
     * @see ApiRequest::getServiceType()
     */
    public function getServiceType()
    {
        return ApiRequest::REST;
    }

    /**
     * Parse params from request.
     * @return array
     */
    public static function getParamsFromRequest()
    {
        $requestMethod = strtolower($_SERVER['REQUEST_METHOD']);
        switch ($requestMethod) {
            case 'get':

                // Grab uri-segmeted GET variables
                parse_str(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY), $getParams);

                // Merge both the URI segements and actual GET params
                $params = array_merge($_GET, $getParams);

                break;
            case 'post':
                $params = $_POST;
                break;
            case 'put':
                parse_str(file_get_contents('php://input'), $params);
                $params['id'] = $_GET['id'];
                break;
            case 'delete':
                throw new CException('Requested method is not supported.');
                break;
        }
        return $params;
    }
}