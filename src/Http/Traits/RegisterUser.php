<?php

namespace Aiomlm\Auth\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Aiomlm\Auth\Models\User;
use Aiomlm\Auth\Models\Profile;
use Aiomlm\Auth\Notifications\RegistrationNotification;
 /**
 *
 */
trait RegisterUser {
	/**
	 * use the public variables to complete the register user
	 */
	public $position = 0;
	public $sponsor = 1001;
	public $leg;
	public $profileFields=[];
	/**
	 * Use RegisterUser trait use for complete the registration for aiomlm system
	 *
	 * Declare a method called submit(which will call from the form)
	 *
	 * then inside the submit call and return the register method with passing the request data
	 *
	 * The data can only be the form
	 */
	use RedirectsUsers;
	/**
	 * Handle a registration request for the application.
	 *
	 * @param  arrey $data
	 * @return \Illuminate\Http\Response
	 */

	public function register($data)
	{
		 /**
		  * Validate the inputs
		  */
 			$this->validator($data)->validate();
 			/**
			 * here the validation process is completed and success
			 * Now it's time to enter the data into the database
			 */
			 event(new Registered($user = $this->create($data)));

			 /**
			  * Now we have the newly registered user
			  * handle the user data as per the plan
			  */
			 /**
			  * check the position and update the position user
			  * @param $user
			  * check if the position id available or not
			  * if not then update user position as 0
			  */
			 if ($position = User::find($user->position)) {
			 	  /**
			 	   * update the position leg id
			 	   */
			 	$position->update([
					 $user->leg = $user->id,
				]);
			}else {
				$user->position = 0;
				$user->save();
			}
			/**
			 * Now check if the registration was not free and had seleceted registration package
			 * Check the package has imcomes
			 * If has pay accordingly
			 */
		  ///will do it later
		 //now the registration has been completed
		  /**
		   * send notification to the with his newly created user details
		   * @return Aiomlm\Auth\Notifications\RegistrationNotification
		   * @param $user
		   */
		  /**
		   * add the user's entered password into data and send via notification
		   */
		   $user->original_password = $data['password'];
			 \Notification::send($user, new RegistrationNotification($user));
			 /**
			  * Now we have completed the register process, return the user details back
			  */
 			 return $user;
	}

	/**
	 * Validate the input
	 * @param  array  $data
	 * @return $validator
	 */
	public function validator(array $data) {
 		$validables = ['name' => 'required|string'];
		/**
		 *Use package config for the validation
 		 */
		if (config('aiomlm.register.require_email') == 'yes') {
			$validables['email'] = 'required|email';
		}
		if (config('aiomlm.register.require_phone') == 'yes') {
			$validables['phone'] = 'required|string|min:10';
		}
		if (config('aiomlm.register.require_sponsor') == 'yes') {
			$validables['sponsor'] = 'required|integer';
		}
		if (config('aiomlm.register.password') == 'yes') {
			$validables['password'] = 'required|string|confirmed';
		}

		/**
		 * validation for profile fields
		 * @var arrey $profileFields
		 */

		 $profileFields = config('profile.fields');

		 foreach ($profileFields as $key => $field) {

				 if (isset($field['enabled'])) { //check if the property exists or not
						if ($field['enabled']) { //if enabled
								if (isset($field['required'])) {
									 if ($field['required']) {
										 $validables[$key] = 'required';
									 }
								}
							 $this->profileFields[$key] = $field;
						}
				 }
		 }


		$validator = Validator::make($data, $validables);
		/**
		* Check if the entered email can use or not
		*/
		if (config('aiomlm.register.email_use') > 0) {
			if ($user = User::where('email', $data['email'])->count() >= config('aiomlm.register.email_use')) {
				$validator->after(function($validator){
								 $validator->errors()->add('email', 'Email is already taken');
			 });
			}
		}
		/**
		* Check if the entered phone can use or not
		*/
		if (config('aiomlm.register.phone_use') > 0) {
			if ($user = User::where('phone', $data['phone'])->count() >= config('aiomlm.register.phone_use')) {
				$validator->after(function($validator){
									$validator->errors()->add('phone', 'Phone is already taken');
				});
			}
		}
		/**
		 * check for the sponsor user
 		 */
 	  if ($data['sponsor']) {
 	      if (!$sponsor = User::find($data['sponsor'])) {
					$validator->after(function($validator){
									 $validator->errors()->add('sponsor', 'Sponsor user not found by the entered Id');
				 });
 	     }else {
				 //set the final sponsor
 			  	$this->sponsor = $sponsor->id;
 	     }
 	  }
		/**
		 * check for the position user
		 */
		if ($data['position']) {
				if (!$position = User::find($data['position'])) {
					$validator->after(function($validator){
									 $validator->errors()->add('position', 'Position user not found by the entered Id');
				 });
			 }else {
 				//set the final position
				$this->position = $position->id;
			 }
		}
		/**
		 * Check for positions and leg if the register user status should not be temporary
		 * if the register user status should temporary then skip for topup later
		 */
		 if (config('aiomlm.register.status') != 'temporary') {
		 	// code...
		 }

		 /**
		  * check if registration process is free or not
		  * if not the user should enter epin or payment gateway
		  * and check if the epin and payment gateway systems are enabled
		  */
		 if (config('aiomlm.register.free') == 'no') {
		 	   if (config('aiomlm.business.epin') =='yes') {
		 	   	  /**
		 	   	   * validate the epin
		 	   	   */
		 	   }
				 elseif (config('aiomlm.business.pg') == 'yes') {
				 	  /**
				 	   * the payment process should be completed by the payment package provider and all
				 	   * just need to pass a confirmation to this method id the payment process success else don't call this regiister method
				 	   * check if the payment process is completed or not
				 	   * if not return with error and abort('unprocessable')
				 	   */
				 }
		 }

		 /**
		  * Now the validation process has been set
		  * @var $validator to validate for any error
		  */

		return $validator;
	}

	public function create(array $data)
	{
		  /**
		   * create user
		   */
		  $user = User::create([
				  // 'id' => 'auto inscrement > 1001'
				  'name' => $data['name'],
					'email' => $data['email'],
					'phone' => $data['phone'],
					'sponsor' => $this->sponsor,
					'position' => $this->position,
					'leg' => $this->leg,
					'ref_link' => \Str::random(5),
					'password' => \Hash::make($data['password']),
 			]);
			$user->assignRole('member');
			if ($status = config('aiomlm.register.status')) {
				  $user->status = $status;
					$user->save();
			}
			/**
			 * create profile, wallet , and level for the registered user
			 */
			if (config('aiomlm.business.wallet') == 'yes') {
			 	$wallet = Wallet::create([ 'user_id' => $user->id ]);
			}

			if (config('aiomlm.business.level') == 'yes') {
				$level = Level::create([ 'user_id' => $user->id ]);
			}
			$profile = Profile::create([ 'user_id' => $user->id ]);

			foreach ($this->profileFields as $key => $field) {
				  if (isset($data[$key])) {
				  	 $profile->update([ trim($key) => $data[$key] ]);
				  }
			}

			return $user;

	}

}
