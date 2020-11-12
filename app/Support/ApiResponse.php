<?php

namespace App\Support;

use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as FoundationResponse;
use Illuminate\Http\Request;

trait ApiResponse
{
    /**
     * statusCode
     *
     * @var Integer
     */
    protected $statusCode = FoundationResponse::HTTP_OK;

    /**
     * headers
     *
     * @var array
     */
    protected $headers = [];

    protected $message;

    // protected $request;

    /**
     * getStatusCode
     *
     * @return Integer
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * setStatusCode
     *
     * @param  Integer $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * setHeaders
     *
     * @param  mixed $headers
     * @return $this
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * success
     *
     * Respond message by http method, only GET method would get return message.
     *
     * @param  mixed $data
     * @return void
     */
    public function success($message = null)
    {
        $this->message = $message;

        
        switch ((new Request)->getMethod()) {
            case 'POST':
                return (new Response())->setStatusCode(201);
                break;
            case 'PUT':
            case 'PATCH':
            case 'DELETE':
                return (new Response())->setStatusCode(204);
                break;
            case 'GET':
            default:
                break;
        }

        return $this->respond();
    }

    /**
     * successWithResponse
     *
     * Some method would still have return message,
     * like Login api may use POST method, and you need to return token.
     *
     * @param  mixed $message
     * @return void
     */
    public function successWithResponse($message, $code = 201)
    {
        $this->message = $message;
        $this->setStatusCode($code);
        return $this->respond();
    }

    /**
     * failed
     *
     * @param  mixed $message
     * @param  Integer $code
     * @return void
     */
    public function failed($message, $code = FoundationResponse::HTTP_BAD_REQUEST)
    {
        $this->message = $message;

        // You can view message if you're developing.
        if (env('APP_DEBUG', false)) {
            return $this->setStatusCode($code)
                ->respond();
        }

        return $this->setStatusCode($code)
            ->errorPackage()
            ->respond();
    }

    /**
     * errorPackage
     *
     * Package your error message by status code.
     *
     * @return $this
     */
    private function errorPackage()
    {
        switch ($this->statusCode) {
            case 304:
                $this->message = trans('message.http_304');
            case 400:
                $this->message = [
                    'error' => [
                        'code' => $this->statusCode,
                        'message' => $this->message,
                    ],
                ];
                break;
            case 401:
                $this->message = trans('message.http_401');
                break;
            case 403:
                $this->message = trans('message.http_403');
                break;
            case 404:
                $this->message = ($this->message == '') ? trans('message.http_404') : $this->message;
                break;
            case 409:
                $this->message = ($this->message == '') ? trans('message.http_409') : $this->message;
                break;
            case 500:
            default:
                $this->message = trans('message.http_500');
                break;
        }

        return $this;
    }

    /**
     * respond
     *
     * @return void
     */
    private function respond()
    {
        return response()->json($this->message, $this->statusCode, $this->headers, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

}
