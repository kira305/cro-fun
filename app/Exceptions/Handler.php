<?php

namespace App\Exceptions;

use Exception;
use Redirect;
use Auth;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {   
       
        if ($exception instanceof \Illuminate\Session\TokenMismatchException) {
               
           return Redirect::back()->with('message', trans('message.expired'));

        }
         
        if($exception instanceof \Illuminate\Auth\Access\AuthorizationException) {
              
              return redirect('/user/logout');
        }
        if ($this->isHttpException($exception)) {
               
             return response()->view('errors.500', []);

        }
        if($exception instanceof Exception && Auth::check()) {
              
             return response()->view('errors.500', []);
        }

        // if ($this->isHttpException($exception)) {
               
        //     switch ($exception->getStatusCode()) {

        //         case 404:               
        //             return response()->view('errors.404', []);
        //             break;

        //         case 500:
                
        //             return response()->view('errors.500', []);
        //             break;

        //         default:
                  
        //             break;
        //     }

        // }else {

        // return response()->view('errors.common', [

        //     'message' => $exception->getMessage(),
        //     'file'    => $exception->getFile(),
        //     'line'    => $exception->getLine(),
        //     'trace'   => $exception->getTrace()[0]]);

        // }
        
        return parent::render($request, $exception);


       
    }

    public function renderForConsole($output, Exception $e)
    {
       throw $e;
    }
}
