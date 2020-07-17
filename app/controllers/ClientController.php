<?php
use Illuminate\Support\MessageBag;
class ClientController extends Controller{

	//START THE addClient Method
	public function addClient() {
		$name = Input::get('name');
		$address = Input::get('address');
		$ABN = Input::get('abn');
		$email = Input::get('email');
		$phone = Input::get('phone');
		$region = Input::get('region');
		$publish = Input::get('publish');
		
	    if (Input::server("REQUEST_METHOD") == "POST"){
	    	$rules = array(     
                'name' => 'required|min:1',
				'address' => 'required|min:2',
				'abn' => 'required|min:2',				
				'phone' => 'required|min:6',
				'region' => 'required|min:2',
                'email' => 'required|email|unique:clients,email'
   			);
   			$validator = Validator::make(Input::all(), $rules);

	         if ($validator->fails()){		
		       	return Redirect::route('admin/client_new')->withErrors($validator);
	         } else {
             // validation ok
	            try {
	                //save on db/*
		            $client = new Client;
		            $client->name = $name;
		            $client->address = $address;
		            $client->email = $email;
		            $client->phone = $phone;
		            $client->ABN = $ABN;
					$client->region = $region;
		            $client->published = $publish;
		            $client->save(); 

					$id = DB::getPdo()->lastInsertId();

					Session::flash('status_success', 'Successfully Updated.');
					return Redirect::route('admin/clients', array('id'=>$id));
	            }  catch( Exception $e ) {
					echo $e;
	                Session::flash('status_error', 'An error occurred while creating a new account - please try again.');
	                //return Redirect::route('admin/client_new');
	            } 	          
	        }
		}
	}		
	//END THE addClient Method

	//START THE updateAction Method
	public function updateAction(){
		$id = Input::get('id');
		$name = Input::get('name');
		$address = Input::get('address');
		$ABN = Input::get('abn');
		$phone = Input::get('phone');
		$region = Input::get('region');
		$publish = Input::get('publish');
		
	    if (Input::server("REQUEST_METHOD") == "POST"){
	    	$rules = array(     
                'name' => 'required|min:1',
				'address' => 'required|min:2',
				'abn' => 'required|min:2',				
				'phone' => 'required|min:6',
				'region' => 'required|min:2',
   			);
   			$validator = Validator::make(Input::all(), $rules);

	         if ($validator->fails()){		
		       	return Redirect::route('admin/client_edit', array('id'=>$id))->withErrors($validator);
	         } else {
             // validation ok
	            try {
	                //save on db/*
					$client = Client::find($id);
		            $client->name = $name;
		            $client->address = $address;
		            $client->phone = $phone;
		            $client->ABN = $ABN;
					$client->region = $region;
		            $client->published = $publish;
		            $client->save(); 

					Session::flash('status_success', 'Successfully Updated.');
					return Redirect::route('admin/clients', array('id'=>$id));
	            }  catch( Exception $e ) {
	                Session::flash('status_error', 'An error occurred while creating a new account - please try again.');
	                return Redirect::route('admin/client_edit', array('id'=>$id));
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
			DB::table('userclients')->where('client_id', $id)
				->delete();
			$client = Client::find($id);
			$status = $client->delete();			

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

