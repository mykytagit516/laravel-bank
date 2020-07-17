<?php
use Illuminate\Support\MessageBag;
class UserController extends Controller{
 
 //Method for logging user in   
    public function loginAction(){
        if (Input::server("REQUEST_METHOD") == "POST"){
            $rules = array(
            	'email' => 'required',
                'password' => 'required'
            );
            $validator = Validator::make(Input::all(), $rules);
			
            if ($validator->fails()){
            //validation failed
				if (!Input::has('email') || !Input::has('password')) {
						Session::flash('status_error', 'Sorry enter the email or password please');						
						return Redirect::route('user/login');
				} 				
            } else {
            //validation passed
	            $credentials = array(
	                "email" => Input::get('email'),
	                "password" => Input::get('password'), 
	            );
	            //remeber check
	            $remeber = false;
	            if(Input::get('remember')){
	            	$remeber = true;
	            } 

	            if (Auth::attempt($credentials, $remeber)){	
	            	if(Auth::user()->published > 0 && Auth::user()->token == ""){            	
	            		
						if (strcmp(strtolower(Auth::user()->permission), "administrator") == 0 ) {
							return Redirect::route("admin/home");
						} else if (strcmp(strtolower(Auth::user()->permission), "master") == 0 ) {
	                		return Redirect::route("master/home");
						} else if (strcmp(strtolower(Auth::user()->permission), "manager") == 0 ) {
							return Redirect::route("manager/home");
						} else if (strcmp(strtolower(Auth::user()->permission), "contractor") == 0 ) {
							return Redirect::route("contractor/home");
						} else if (strcmp(strtolower(Auth::user()->permission), "client") == 0 ) {
							return Redirect::route("client/home");
						}						
	            	}
					Session::flash('status_error', 'Sorry your account does not have sufficient priviledges to log in ');
					return Redirect::route('user/login');
	            } else {	            	
		           Session::flash('status_error', 'Sorry account with provided email and password does not exist');
		           return Redirect::route('user/login');
			    }//end auth attempt 
			}//end validation 
        }
    }// end loginAction

	//Method for requesting a new password
    public function requestAction(){
	    if (Input::server("REQUEST_METHOD") == "POST"){
	        $rules = array(
	            "email" => "required"
	        );
	        $validator = Validator::make(Input::all(), $rules);
	        
	        if ($validator->fails()){
	        //validation failed
	        	Session::flash('status_error', 'Sorry, you entered an incorrect email.');
	            return Redirect::route("user/request");
	        } else {
	        //validation passed
	            $email = Input::get("email");
	            try{
		           	$userEmail = User::where('email', $email)->firstOrFail();
					$credentials = array('email' => $userEmail->email);						

		            Password::remind($credentials, function($message){
		                    $message->subject("The App password reset form");
		            });
					
		            Session::flash('status_success', 'Email has been sent to ' . Input::get('email') .'.');
	            	return Redirect::route("user/request");
		        } catch( Exception $e ) {
	                Session::flash('status_error', 'Sorry, you entered an incorrect email or user with such email does not exist.12');
	                return Redirect::route("user/request");
	            }  
	            
	        }//end validation
	    }
	}//end requestAction


//Method for reseting the password    
	public function resetAction(){
	    $token = "?token=" . Input::get("token");
	    $errors = new MessageBag();
	    if ($old = Input::old("errors")){
	        $errors = $old;
	    }
	    $data = array(
	        "token"  => $token,
	        "errors" => $errors
	    );
	    if (Input::server("REQUEST_METHOD") == "POST"){
	        $validator = Validator::make(Input::all(), array(
	            "email"                 => "required|email",
	            "password"              => "required|min:6",
	            "password_confirmation" => "same:password",
	            "token"                 => "exists:token,token"
	        ));
	        if ($validator->passes()){
	            $credentials = array(
	                "email" => Input::get("email"),
	                "password" => Input::get("password"),
	                "password_confirmation" => Input::get("password_confirmation"),
	                "token" => Input::get("token")
	            );
	            Password::reset($credentials, function($user, $password){
	                    $user->password = Hash::make($password);
	                    $user->save();
	                    Auth::login($user);
						
	            });

				if (strcmp(strtolower(Auth::user()->permission), "student") == 0 ) {
					return Redirect::route("user/home");
				} else if (strcmp(strtolower(Auth::user()->permission), "teacher") == 0 ) {
					return Redirect::route("teacher/home");
				} else if (strcmp(strtolower(Auth::user()->permission), "administrator") == 0 ) {
					return Redirect::route("admin/dashboard");
				}
	        }
	        $data["email"] = Input::get("email");
	        $data["errors"] = $validator->errors();
	        return Redirect::to(URL::route("user/reset") . $token)
	            ->withInput($data);
	    }
	    return View::make("user/reset", $data);
	}

	//START THE verifyAction Method
	public function verifyAction() {
		$token = Input::get("token");
		$user = User::where('token', '=', $token)->first();
		if ($user != null) {
			$user->token = "";
			$user->active = 1;
			$user->save();
			Auth::login($user);
			return Redirect::route('user/verified');
		} else {
			return Redirect::route('user/error');
		}	
	}
	//END THE verifyAction Method

	//Method for registering the user
	public function registerAction(){
		
		$password = Input::get('password');
		$first = Input::get('firstname');
		$last = Input::get('lastname');
		$email = Input::get('email');
		$mobile = Input::get('mobile');
		$title = Input::get('title');

	    if (Input::server("REQUEST_METHOD") == "POST"){
	    	$rules = array(     
                'password' => 'required|min:5|different:email',
                'rpassword' => 'required|same:password',
                'firstname' => 'required|min:2',
                'lastname' => 'required|min:2',
				'mobile' => 'required|min:2',
                'email' => 'required|email|unique:users,email',
   			);
		
   			$validator = Validator::make(Input::all(), $rules);
	         if ($validator->fails()){
		       	return Redirect::route('user/login')->withErrors($validator);
	         } else {
             // validation ok	         	
	            $data = Input::get();				
	            try {
	                //save on db
					$token = hash('sha256',Str::random(10), false);
		            $user = new User;
		            $user->password = Hash::make($password);
		            $user->fname = $first;
		            $user->lname = $last;
		            $user->email = $email;
		            $user->title = $title;
		            $user->mobile = $mobile;
					$user->permission = 'client';
					$user->published = 1;
					$user->save();
					$id = DB::getPdo()->lastInsertId();
					/*
					$data = array(
						'firstname' => $first,
						'lastname' => $last,
						'email' => $email,
						'password' => $password,
						'token' => $token
					);					
					Mail::send('emails.welcome', $data, function($message){
						$message->to(Input::get('email'))->subject('Welcome to you!');
					});
		            */
	                return Redirect::route('user/login');
	            }  catch( Exception $ex ) {
	                Session::flash('status_error', 'An error occurred while creating a new account - please try again.');
	                return Redirect::route('user/login');
	            } 	          
	        }
		}
	 }

	public function addUser() {
		$first = Input::get('firstname');
		$last = Input::get('lastname');
		$password = Input::get('password');
		$email = Input::get('email');
		$mobile = Input::get('mobile');
		$title = Input::get('title');
		$permission = Input::get('permission');
		$publish = Input::get('publish');
		
	    if (Input::server("REQUEST_METHOD") == "POST"){
	    	$rules = array(     
                'password' => 'required|min:5|different:email',
                'rpassword' => 'required|same:password',	    		
                'firstname' => 'required|min:2',
                'lastname' => 'required|min:2',
				'mobile' => 'required|min:2',
                'email' => 'required|email|unique:users,email'          
   			);
   			$validator = Validator::make(Input::all(), $rules);

	         if ($validator->fails()){		
		       	return Redirect::route('admin/user_new')->withErrors($validator);
	         } else {
             // validation ok
	            try {
	                //save on db/*
					//$token = hash('sha256',Str::random(10),false);					
		            $user = new User;
		            $user->password = Hash::make($password);
		            $user->fname = $first;
		            $user->lname = $last;
		            $user->email = $email;
		            $user->mobile = $mobile;
		            $user->title = $title;
					$user->permission = $permission;
		            $user->published = $publish;
					//$user->token = $token;
		            $user->save(); 
					$id = DB::getPdo()->lastInsertId();
					/*
					$data = array(     
						'firstname' => $first,
						'lastname' => $last,
						'email' => $email,
						'password' => $password,
						'token' => $token
					);
					
					Mail::send('emails.welcome', $data, function($message){
						$message->to(Input::get('email'))->subject('Welcome to you!');
					});
					*/
					Session::flash('status_success', 'Successfully Updated.');
					return Redirect::route('admin/user_edit', array('id'=>$id));
	            }  catch( Exception $e ) {
					echo $e;
	                Session::flash('status_error', 'An error occurred while creating a new account - please try again.');
	                //return Redirect::route('users/user');
	            } 	          
	        }
		}
	}	
	
	public function accountInfo(){
		$password = Input::get('password');
		$first = Input::get('firstname');
		$last = Input::get('lastname');

		if (Input::server("REQUEST_METHOD") == "POST"){
	    	$rules = array(     
                'password' => 'required|min:5|different:email',
                'rpassword' => 'required|same:password',
                'firstname' => 'required|min:2',
                'lastname' => 'required|min:2',
				'mobile' => 'required|min:2',
                'email' => 'required|email|unique:users,email'  
   			);

   			$validator = Validator::make(Input::all(), $rules);

	        if ($validator->fails()){
		       Session::flash('status_error', 'An error occurred while updating your account - Please try again.');
	           return Redirect::route('student/account')->withErrors($validator);
	        } else {
             // validation ok
	            try {
	                //save on db
		            $user = Auth::user();
		            if(!empty($password)){
						$user->password = Hash::make($password);
		        	}
		            $user->first = $first;
		            $user->last = $last;	
		            $user->save(); 

		            Session::flash('status_success', 'Successfully saved.');
					return Redirect::route('student/account');
	            }  catch( Exception $e ) {
	               Session::flash('status_error', 'An error occurred while creating a new account - please try again.');
	               return Redirect::route('student/account');
	            }	          
	        }//end validator
		}
	}//end accountInfo

	//START THE updateAction Method
	public function updateAction(){
		$first = Input::get('firstname');
		$last = Input::get('lastname');
		$password = Input::get('password');
		$mobile = Input::get('mobile');
		$title = Input::get('title');
		$permission = Input::get('permission');
		$publish = Input::get('publish');

        $user = User::find(Input::get('id'));

		$user->password = Hash::make($password);
		$user->fname = $first;
		$user->lname = $last;
		$user->mobile = $mobile;
		$user->title = $title;
		$user->permission = $permission;
		$user->published = $publish;

        $user->save();
		
        Session::flash('status_success', 'Successfully updated.');
        return Redirect::route('admin/user_edit', array('id'=>$user->id));
	}
	//END THE updateAction Method.

	//START the classesAction Method
	public function clientsAction() {
		try {

			$user = Input::get('user');
			$clients = Input::get('clients');

			$clients_info = substr($clients, 0, strlen($clients) - 1);
			$clients_array = explode(',', $clients_info);
			
			DB::table('userclients')->where('user_id', $user)
				->delete();
		
			for ($i = 0; $i < count($clients_array); $i ++) { 
				if ($clients_array[$i] != "") {
					$usersClient = new UsersClients;
					$usersClient->user_id = $user;
					$usersClient->client_id = $clients_array[$i];
					$usersClient->save();
				}
			}
			return Redirect::route('admin/user_edit', array('id' => $user));
		} catch(Exception $ex) {
			echo $ex;
			Session::flash('status_error', '');			
		}
	}
	//END the classesAction Method.

	//START the deleteAction Method
	public function deleteAction(){

		$input = Input::all();
		$id = $input["id"];
		$status = false;
		try {
			$user = User::find($id);
			if ($user->permission == "administrator") {
				$message = "I'm sorry, you cannot remove the user with Super user permission.";
			} else {
				$status = $user->delete();		
				$message = "";
			}
		} catch(Exception $ex) {
			$message = "I'm sorry, You cannot delete this user.";
		}

		$responses = array(
			'idx'	  => $id,	
			'message' => $message,
			'status'  => $status,
		);

		return Response::json( $responses );

	}
	//END the deleteAction Method.
}

