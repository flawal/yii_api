<?php
/**
 * Render Xml Response
 */
class ApiXmlResponse extends ApiResponse
{
    /**
    * Generate service output Xml format
    * @param ApiResult $result
    */
    public static function generateOutput($result)
    {
        if (!$result instanceof ApiResult) {
            throw new CExeption('Bad result format returned');
        }

        $data = $result->convertToArray();

        header('Content-Type: application/xml');
        header('HTTP/1.1: ' . $result->httpCode);
        header('Status: ' . $result->httpCode);
        header('Content-Length: ' . strlen((string) $data));

        echo ApiXmlParser::arrayToXml($data);
        return;
    }
}