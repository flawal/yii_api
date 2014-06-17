<?php
/**
* Render JSON Response.
*/
class ApiJsonResponse extends ApiResponse
{
    /**
     * Generate service output json format
     * @param ApiResult $result
     */
    public static function generateOutput($result)
    {
        if (!$result instanceof ApiResult) {
            throw new CExeption('Bad result format returned');
        }

        $output = $result->convertToArray();

        header('Content-Type: application/json');
        header('HTTP/1.1: ' . $result->httpCode);
        header('Status: ' . $result->httpCode);
        header('Content-Length: ' . strlen((string) $output));

        echo json_encode($output);
        return;
    }
}