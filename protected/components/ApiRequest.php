<?php
/**
* Handle API requests.
*/
class ApiRequest
{
    const REST           = 'REST';
    const SOAP           = 'SOAP';
    const JSON_FORMAT    = 'json';
    const XML_FORMAT     = 'xml';

    /**
     * Params format for response.
     * @var string
     */
    protected $paramsFormat;

    /**
     * Store params from request.
     * @var array
     */
    protected $params = array();

    /**
     * To be redeclard in children classes.
     */
    public function getServiceType()
    {
    }

    /**
     * To be redeclard in children classes.
     */
    public static function getParamsFromRequest()
    {
    }

    /**
     * Init class.
     */
    public function init()
    {
        $this->parseResponseFormat();
    }

    public function getParams()
    {
        return $this->params;
    }

    public function setParams($params)
    {
        $this->params = $params;
    }

    public function getResponseFormat()
    {
        return $this->paramsFormat;
    }

    public function setResponseFormat($paramsFormat)
    {
        $this->paramsFormat = $paramsFormat;
    }

    /**
     * Get requested response format (json or xml)
     * First check the ?format=json url parameter, if not set, then check the HTTP_ACCEPT header
     */
    protected function parseResponseFormat()
    {
        if (!empty($_GET['format']) && (strtolower($_GET['format']) === self::JSON_FORMAT || strtolower($_GET['format']) === self::XML_FORMAT) ) {
            $this->paramsFormat = strtolower($_GET['format']);
        } else {
            $this->paramsFormat = (strpos($_SERVER['HTTP_ACCEPT'], self::JSON_FORMAT)) ? self::JSON_FORMAT : self::XML_FORMAT;
        }
    }

    /**
     * Get sessionId from HTTP headers
     */
    public function getSessionId()
    {
        if (isset($_SERVER['HTTP_SESSION_ID'])) {
            return $_SERVER['HTTP_SESSION_ID'];
        } else {
            return false;
        }
    }

    /**
    * Get token from HTTP headers
    */
    public function getSessionToken()
    {
        if (isset($_SERVER['HTTP_TOKEN'])) {
            return $_SERVER['HTTP_TOKEN'];
        } else {
            return false;
        }
    }

    /**
    * Get api key from HTTP headers
    * This is tentative till we flush out prefered auth mechanism, i.e. apiKey, Oauth, etc
    */
    public function getApiKey()
    {
        if (!empty($_SERVER['CB-API-KEY'])) {
            return $_SERVER['CB-API-KEY'];
        } else {
            return false;
        }
    }

    /**
    * Get username from HTTP headers
    * This is tentative till we flush out prefered auth mechanism, i.e. apiKey, Oauth, etc
    */
    public function getUsername()
    {
        if (isset($_SERVER['HTTP_AUTH_USERNAME'])) {
            return $_SERVER['HTTP_AUTH_USERNAME'];
        } else {
            return false;
        }
    }

    /**
    * Get password from HTTP headers
    * This is tentative till we flush out prefered auth mechanism, i.e. apiKey, Oauth, etc
    */
    public function getPassword()
    {
        if (isset($_SERVER['HTTP_AUTH_PASSWORD'])) {
            return $_SERVER['HTTP_AUTH_PASSWORD'];
        } else {
            return false;
        }
    }

    /**
    * Get language from HTTP headers
    */
    public function getLanguage()
    {
        if (isset($_SERVER['HTTP_LANG'])) {
            return $_SERVER['HTTP_LANG'];
        } else {
            return false;
        }
    }

    /**
    * Get request type from HTTP headers
    */
    public function getRequestType()
    {
        if (isset($_SERVER['HTTP_API_REQUEST_TYPE'])) {
            if (strtolower($_SERVER['HTTP_API_REQUEST_TYPE']) == 'rest') {
                return self::REST;
            } elseif (strtolower($_SERVER['HTTP_API_REQUEST_TYPE']) == 'soap') {
                return self::SOAP;
            }
        } else {
            return false;
        }
    }

    /**
    * Parse params from request.
    */
    public function parseParams()
    {
        if ($this->getRequestType() == self::REST) {
            $params = ApiRestRequest::getParamsFromRequest();
        } elseif ($this->getRequestType() == self::SOAP) {
            $params = ApiSoapRequest::getParamsFromRequest();
        } else {
            echo "Invalid request";
            Yii::app()->end();
        }
        $this->setParams($params);
    }

    /**
     * Check if request is api request.
     * @return boolean
     */
    public function isApiRequest()
    {
        try {
            $url = Yii::app()->getRequest()->getUrl();
        } catch (CException $e) {
            $url = '';
        }

        if (strpos($url, '/api/') !== false) {
            return true;
        } else {
            return false;
        }
    }
}
