<?php

namespace App\Support;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

trait ThrowException
{
    /**
     * 重複即拋出(可搭配findNotInclude，需注意取出all()的陣列結果再傳入)
     *
     * @param  String $message
     * @param  Array $result
     * @return void
     */
    protected function throwRepeat($message, $result)
    {
        if ($result != []) {
            $this->throwJobFailed($message);
        }
    }

    /**
     * throwJobFailed 400
     *
     * @param  String $message
     * @param  mixed $result
     */
    protected function throwJobFailed($message, $result = false)
    {
        if (!$result || $result == []) {
            throw new BadRequestHttpException($message);
        }
    }

    /**
     * throwNonAuth 401
     *
     * @param  String $message
     * @param  mixed $result
     */
    protected function throwNonAuth($message, $result = false)
    {
        if (!$result) {
            throw new UnauthorizedHttpException($message);
        }
    }

    /**
     * throwAuthError 403
     *
     * @param  String $message
     * @param  mixed $result
     */
    protected function throwAuthError($message, $result = false)
    {
        if (!$result) {
            throw new AccessDeniedHttpException($message);
        }
    }

    /**
     * throwNotFound 404
     *
     * @param  String $message
     * @param  mixed $result
     *
     */
    protected function throwNotFound($message = '', $result = false)
    {
        if (!$result || $result == []) {
            throw new NotFoundHttpException($message);
        }
    }

    /**
     * throwIsEnabled 409
     *
     * @param  String $message
     * @param  mixed $isEnabled
     */
    protected function throwIsEnabled($message, $isEnabled = false)
    {
        if ($isEnabled) {
            throw new ConflictHttpException($message);
        }
    }
}
