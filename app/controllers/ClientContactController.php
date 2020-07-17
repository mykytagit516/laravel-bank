<?php
use Illuminate\Support\MessageBag;
class ClientContactController extends Controller{

	//START THE addClient Method
	public function addContact() {
		$client = Input::get('client');
		$name = Input::get('name');
		$mobile = Input::get('mobile');
		$email = Input::get('email');
		$phone = Input::get('phone');
		
	    if (Input::server("REQUEST_METHOD") == "POST"){
	    	$rules = array(     
				'client' => 'required|min:1',
                'name' => 'required|min:1',
				'mobile' => 'required|min:6',
                'email' => 'required|email|unique:clients,email'   
   			);
   			$validator = Validator::make(Input::all(), $rules);

	         if ($validator->fails()){		
		       	return Redirect::route('admin/clientcontact_new')->withErrors($validator);
	         } else {
             // validation ok
	            try {
	                //save on db/*
		            $contact = new ClientContact;
					$contact->clients_id = $client;
		            $contact->name = $name;
		            $contact->mobile = $mobile;
		            $contact->email = $email;
		            $contact->phone = $phone;
		            $contact->save(); 

					$id = DB::getPdo()->lastInsertId();

					Session::flash('status_success', 'Successfully Updated.');
					return Redirect::route('admin/clientcontacts', array('id'=>$id));
	            }  catch( Exception $e ) {
					echo $e;
	                Session::flash('status_error', 'An error occurred while creating a new account - please try again.');
	                //return Redirect::route('admin/clientcontact_new');
	            } 	          
	        }
		}
	}		
	//END THE addClient Method

	//START THE updateAction Method
	public function updateAction(){
		$id = Input::get('id');
		$name = Input::get('name');
		$mobile = Input::get('mobile');
		$phone = Input::get('phone');
		
	    if (Input::server("REQUEST_METHOD") == "POST"){
	    	$rules = array(     
				'client' => 'required|min:1',
                'name' => 'required|min:1',
				'mobile' => 'required|min:6'
   			);
   			$validator = Validator::make(Input::all(), $rules);

	         if ($validator->fails()){		
		       	return Redirect::route('admin/clientcontact_edit', array('id'=>$id))->withErrors($validator);
	         } else {
             // validation ok
	            try {
	                //save on db/*
					$contact = ClientContact::find($id);
		            $contact->name = $name;
		            $contact->mobile = $mobile;
		            $contact->phone = $phone;
		            $contact->save(); 

					Session::flash('status_success', 'Successfully Updated.');
					return Redirect::route('admin/clientcontacts', array('id'=>$id));
	            }  catch( Exception $e ) {
	                Session::flash('status_error', 'An error occurred while creating a new account - please try again.');
	                return Redirect::route('admin/clientcontact_edit', array('id'=>$id));
	            } 	          
	        }
		}
	}
	//END THE updateAction Method.	

	//START the deleteAction Method
	public function deleteAction(){

		$input = Input::all();
		$id = $input["id"];
		$status = false;

		try {
			$contact = ClientContact::find($id);
			$status = $contact->delete();

			$message = "";

		} catch(Exception $ex) {
			$message = "I'm sorry, You cannot delete this client.";
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

