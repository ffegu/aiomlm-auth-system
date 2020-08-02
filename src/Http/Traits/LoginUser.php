<?php

namespace Aiomlm\Auth\Http\Traits;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

/**
 * this trait uses for many types user's login
 */
trait LoginUser
{
  /**
   * for login in user using default guard web
   * @param  $data arrey
   * @return response boolean
   */
   public function attemptLogin($data)
   {
     /**
      * Validate the input
      * @param $data
      */
     $this->validator($data)->validate();
     /**
      * Attempt to login with the inputs for members
      * filter the input
      */
      $credentials = [ 'id' => $data['id'], 'password' => $data['password'] ];

      return Auth::attempt($credentials, $data['remember']);
   }

   public function validator($data)
   {
       return Validator::make($data, [
           'id' => 'required | numeric | min: 1000',
           'password' => 'required | string',
        ]);
   }
}
