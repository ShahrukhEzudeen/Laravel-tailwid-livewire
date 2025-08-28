<?php

namespace App;

trait ApiResponse
{
    //


protected function success($data, $message = 'Success', $code = 200)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function error($message = 'Error', $code = 500, $errors = [])
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'errors' => $errors
        ], $code);
    }

       protected function forbident($message = 'Unauthorized', $code = 401, $errors = [])
    {
        return response()->json([
            'status' => 'Unauthorized',
            'message' => $message,
            'errors' => $errors
        ], $code);
    }

}
