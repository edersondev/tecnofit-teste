<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Exception;
use Throwable;

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
    'current_password',
    'password',
    'password_confirmation',
  ];

  /**
   * Register the exception handling callbacks for the application.
   *
   * @return void
   */
  public function register()
  {
    $this->reportable(function (Throwable $e) {
      //
    });
  }

  /**
   * Render an exception into an HTTP response.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Exception  $exception
   * @return \Illuminate\Http\Response
   */
  public function render($request, Throwable $exception)
  {
    if($exception instanceof ValidationException){
      return parent::render($request, $exception);
    }
    if($exception instanceof ModelNotFoundException){
      return response()->json(['message' => __('messages.no_results')],404);
    }
    if($exception instanceof NotFoundHttpException){
      $code = ( (100 <= $exception->getStatusCode()) && ($exception->getStatusCode() < 600) ? $exception->getStatusCode() : 500 );
    } else {
      $code = ( (100 <= $exception->getCode()) && ($exception->getCode() < 600) ? $exception->getCode() : 500 );
    }

    $message = ['message' => $exception->getMessage()];
    if(!config('app.debug') && $code === 500){
      $message['message'] = __('messages.error_exception');
    }
    if(config('app.debug')){
      $message['trace'] = $exception->getTrace();
    }
    return response()->json($message,$code);
  }
}
