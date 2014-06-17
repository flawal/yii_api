<?php
/**
 * ApiResponse
 */
abstract class ApiResponse
{
    const STATUS_SUCCESS           = 'SUCCESS';
    const STATUS_FAILURE           = 'FAILURE';

    /**
     * Generate output.
     * This should be overridden in children classes, else an exception is thrown.
     * @param ApiResult $result
     * @throws NotImplementedException
     */
    public static function generateOutput($result)
    {
        throw new CException("Method not implemented in children classes.");
    }
}