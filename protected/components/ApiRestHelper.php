<?php
/**
 * REST API helper class.
 * This helps initiate client-side Api request
 */
class ApiRestHelper
{
    public static function createApiCall($url, $method, $headers, $data = array())
    {
        if ($method == 'put') {
            $headers[] = 'HTTP_X_HTTP_METHOD_OVERRIDE: put';
        }

        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);

        switch($method) {
            case 'get':
                break;
            case 'post':
                curl_setopt($handle, CURLOPT_POST, true);
                curl_setopt($handle, CURLOPT_POSTFIELDS, http_build_query($data));
                break;
            case 'put':
                curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'put');
                curl_setopt($handle, CURLOPT_POSTFIELDS, http_build_query($data));
                break;
            case 'delete':
                // curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'delete');
                // break;
            default:
                throw new CException("Requested method is not supported in our Api call.");
                break;
        }
        $response = curl_exec($handle);
        return $response;
    }
}