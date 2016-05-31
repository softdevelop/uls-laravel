<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        // if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException)
        // {
        //     if ($request->ajax())
        //     {
        //         return response()->toJson([
        //             'message' => 'Record not found',
        //         ], 404);
        //     }else {
        //         abort(404);
        //     }
        // } else if ($e instanceof \MongoConnectionException  ) {
        //     $message = trans('exception.connect_mongo_fail', ['message' => $e->getMessage()]);

        //     if ($request->wantsJson())
        //     {
        //         return response()->json([
        //             'message' => $message,
        //         ], 555);
        //     }else {
        //         return response()->view('errors.custom', compact('message'));

        //     }
        // } else if ($e instanceof \PDOException) {
        //     $message = trans('exception.connect_mysql_fail', ['message' => $e->getMessage()]);
        //     if ($request->wantsJson())
        //     {
        //         return response()->json([
        //             'message' => $message,
        //         ], 555);
        //     }else {

        //         return response()->view('errors.custom', compact('message'));

        //     }
        // }else if ($e instanceof \Predis\Connection\ConnectionException) {
        //     $message = trans('exception.connect_redis_fail', ['message' => $e->getMessage()]);
        //     if ($request->wantsJson())
        //     {
        //         return response()->json([
        //             'message' => $message,
        //         ], 555);
        //     }else {
        //         return response()->view('errors.custom', compact('message'));


        //     }
        // }else if ($e instanceof \Symfony\Component\Debug\Exception\FatalErrorException) {
        //     $message = trans('exception.fatal_error', ['message' => $e->getMessage()]);
        //     if ($request->wantsJson())
        //     {
        //         return response()->json([
        //             'message' => $message,
        //         ], 555);
        //     }else {
        //         return response()->view('errors.custom', compact('message'));


        //     }
        // }

        return parent::render($request, $e);
    }
}
