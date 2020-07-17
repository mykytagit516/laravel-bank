<?php
use Illuminate\Support\MessageBag;
class ATMController extends Controller{

	//START THE addClient Method
	public function addATM() {
		$client = Input::get('client');
		$terminalID = Input::get('terminalID');
		$name = Input::get('name');
		$transaction = "0";
		$modem = Input::get('modem');
		$startdate = Input::get('startdate');
		$serial = Input::get('serial');
		$address = Input::get('address');
		$site = Input::get('site');
		
	    if (Input::server("REQUEST_METHOD") == "POST"){
	    	$rules = array(     
				'client' => 'required|min:1',
                'terminalID' => 'required|min:10',
				'name' => 'required|min:2',
				'modem' => 'required|min:2',
				'startdate' => 'required|min:8',
				'serial' => 'required|min:2',
				'address' => 'required|min:2',
				'site' => 'required|min:2'
   			);
   			$validator = Validator::make(Input::all(), $rules);

	         if ($validator->fails()){		
		       	return Redirect::route('admin/atm_new')->withErrors($validator);
	         } else {
             // validation ok
	            try {
	                //save on db/*
		            $atm = new ATM;
					$atm->clients_id = $client;
		            $atm->terminalID = $terminalID;
		            $atm->name = $name;
		            $atm->totalTransactions = $transaction;
		            $atm->modem = $modem;
					$atm->startDate = $startdate;
					$atm->serial = $serial;
					$atm->address = $address;
					$atm->site = $site;
		            $atm->save(); 

					$id = DB::getPdo()->lastInsertId();

					Session::flash('status_success', 'Successfully Updated.');
					return Redirect::route('admin/atm');
	            }  catch( Exception $e ) {
					echo $e;
	                Session::flash('status_error', 'An error occurred while creating a new account - please try again.');
	                return Redirect::route('admin/atm_new');
	            }
	        }
		}
	}		
	//END THE addClient Method

	//START THE updateAction Method
	public function updateAction(){
		$id = Input::get('id');
		$client = Input::get('client');
		$terminalID = Input::get('terminalID');
		$name = Input::get('name');
		$transaction = "0";
		$modem = Input::get('modem');
		$startdate = Input::get('startdate');
		$serial = Input::get('serial');
		$address = Input::get('address');
		$site = Input::get('site');
		
	    if (Input::server("REQUEST_METHOD") == "POST"){
	    	$rules = array(     
				'client' => 'required|min:1',
                'terminalID' => 'required|min:10',
				'name' => 'required|min:2',
				'modem' => 'required|min:2',
				'serial' => 'required|min:2',
				'address' => 'required|min:2',
				'site' => 'required|min:2'
   			);
   			$validator = Validator::make(Input::all(), $rules);

	         if ($validator->fails()){		
		       	return Redirect::route('admin/atm_edit', array('id'=>$id))->withErrors($validator);
	         } else {
             // validation ok
	            try {
	                //save on db/*
					$atm = ATM::find($id);
					$atm->clients_id = $client;
		            $atm->terminalID = $terminalID;
		            $atm->name = $name;
		            $atm->totalTransactions = $transaction;
		            $atm->modem = $modem;
					$atm->startDate = $startdate;
					$atm->serial = $serial;
					$atm->address = $address;
					$atm->site = $site;
		            $atm->save(); 

					Session::flash('status_success', 'Successfully Updated.');
					return Redirect::route('admin/atm');
	            }  catch( Exception $e ) {
					echo $e;
	                Session::flash('status_error', 'An error occurred while creating a new account - please try again.');
	                return Redirect::route('admin/atm_edit', array('id'=>$id));
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
			$contact = ATM::find($id);
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

	//START the addRebank Method
	public function addRebank() {
		$id = Input::get('id');
		$atm = Input::get('atm');
		$cash = Input::get('cash');		
		$cashSourceID = Input::get('CashSourceID');
		$pre_loaded = Input::get('pre_loaded');
		$c1_loaded = Input::get('c1_loaded');
		$c2_loaded = Input::get('c2_loaded');
		$c1_dispensed = Input::get('c1_dispensed');
		$c2_dispensed = Input::get('c2_dispensed');
		$c1_remaining = Input::get('c1_remaining');
		$c2_remaining = Input::get('c2_remaining');
		$c1_rejects = Input::get('c1_rejects');
		$c2_rejects = Input::get('c2_rejects');
		$c1_test = Input::get('c1_test');
		$c2_test = Input::get('c2_test');
		$c1_rebank_amount = Input::get('c1_rebank_amount');
		$c2_rebank_amount = Input::get('c2_rebank_amount');

		$totalRebankAmount = Input::get('totalRebankAmount');
		$totalDeposited = Input::get('totalDeposited');
		$day_total = Input::get('day_total');
		$terminal_total_amount = Input::get('terminal_total_amount');
		$host_total_amount = Input::get('host_total_amount');

		$evidence = Input::get('evidence');
		
	    if (Input::server("REQUEST_METHOD") == "POST"){
	    	$rules = array(     
				'atm' => 'required|min:1',
                'cash' => 'required|min:1',
				'CashSourceID' => 'required|min:1',
				'c1_loaded' => 'required|min:1',
				'c2_loaded' => 'required|min:1',
				'c1_dispensed' => 'required|min:1',
				'c2_dispensed' => 'required|min:1',
				'c1_remaining' => 'required|min:1',
				'c2_remaining' => 'required|min:1',
				'c1_rejects' => 'required|min:1',
				'c2_rejects' => 'required|min:1',
				'c1_test' => 'required|min:1',
				'c2_test' => 'required|min:1',
				'c1_rebank_amount' => 'required|min:1',
				'c2_rebank_amount' => 'required|min:1',
				'totalRebankAmount' => 'required|min:1',
				'day_total' => 'required|min:1',
				'terminal_total_amount' => 'required|min:1',
				'host_total_amount' => 'required|min:1',
				'evidence' => 'required|min:1'
   			);

   			$validator = Validator::make(Input::all(), $rules);

	         if ($validator->fails()){
		       	return Redirect::route('admin/rebank_new')->withErrors($validator);
	         } else {
             // validation ok				
	            try {
					$user = Auth::user();
	                //save on db/*
					
					if (isset($id) && $id != "") {
						$interaction = ATMinteraction::find($id);
					} else {
						$interaction = new ATMinteraction;
					}
					$interaction->user_id = $user->id;
		            $interaction->atm_id = $atm;
		            $interaction->totalDeposited = $totalDeposited;		            
					$interaction->SourceMoney = $cash;
					$interaction->C1loaded = $c1_loaded;
		            $interaction->C2loaded = $c2_loaded;
					$interaction->CashSourceID = $cashSourceID;
					$interaction->type = 'rebank';

					$interaction->C1dispensed = $c1_dispensed;
		            $interaction->C2dispensed = $c2_dispensed;
					$interaction->C1remaining = $c1_remaining;
		            $interaction->C2remaining = $c2_remaining;
					$interaction->C1rejects = $c1_rejects;
		            $interaction->C2rejects = $c2_rejects;
					$interaction->C1tests = $c1_test;
					$interaction->C2tests = $c2_test;
		            $interaction->totalRebankAmount = $totalRebankAmount;

					$image_pos = strripos($evidence, "/");
					$image_path = substr($evidence, 0, $image_pos + 1);
					$image_file = substr($evidence, $image_pos + 1);
					$interaction->filename = $image_file;
					$interaction->filepath = $image_path;	
		            $interaction->save(); 

					$id = DB::getPdo()->lastInsertId();

					Session::flash('status_success', 'Successfully Updated.');
					return Redirect::route('admin/interactions');
					
	            }  catch( Exception $e ) {
					echo $e;
	                Session::flash('status_error', 'An error occurred while creating a new account - please try again.');
	                return Redirect::route('admin/rebank_new');
	            }				
	        }
		}		
	}
	//END the addRebank Method.

	//START the addCash Method
	//START THE addClient Method
	public function addCash() {
		$id = Input::get('id');
		$atm = Input::get('atm');
		$cash = Input::get('cash');		
		$cashSourceID = Input::get('CashSourceID');
		$pre_loaded = Input::get('pre_loaded');
		$c1_loaded = Input::get('c1_loaded');
		$c2_loaded = Input::get('c2_loaded');
		$totalDeposited = Input::get('totalDeposited');
		$evidence = Input::get('evidence');
		
	    if (Input::server("REQUEST_METHOD") == "POST"){
	    	$rules = array(     
				'atm' => 'required|min:1',
                'cash' => 'required|min:1',
				'CashSourceID' => 'required|min:1',
				'c1_loaded' => 'required|min:1',
				'c2_loaded' => 'required|min:1',
				'evidence' => 'required|min:1'
   			);

   			$validator = Validator::make(Input::all(), $rules);

	         if ($validator->fails()){
		       	return Redirect::route('admin/cash_new')->withErrors($validator);
	         } else {
             // validation ok
				
	            try {
					$user = Auth::user();
	                //save on db/*
					
					if (isset($id) && $id != "") {
						$interaction = ATMinteraction::find($id);
					} else {
						$interaction = new ATMinteraction;
					}
		           
					$interaction->user_id = $user->id;
		            $interaction->atm_id = $atm;
		            $interaction->totalDeposited = $totalDeposited;
		            $interaction->C1loaded = $c1_loaded;
					$interaction->SourceMoney = $cash;
		            $interaction->C2loaded = $c2_loaded;
					$interaction->CashSourceID = $cashSourceID;
					$interaction->type = 'cash';

					$image_pos = strripos($evidence, "/");
					$image_path = substr($evidence, 0, $image_pos + 1);
					$image_file = substr($evidence, $image_pos + 1);
					$interaction->filename = $image_file;
					$interaction->filepath = $image_path;	
		            $interaction->save(); 

					$id = DB::getPdo()->lastInsertId();

					Session::flash('status_success', 'Successfully Updated.');
					return Redirect::route('admin/interactions');
					
	            }  catch( Exception $e ) {
					echo $e;
	                Session::flash('status_error', 'An error occurred while creating a new account - please try again.');
	                return Redirect::route('admin/cash_new');
	            }				
	        }
		}			
	}
	//END the addCash Method.
	
	//START the deleteBankTransaction Method
	public function deleteInteraction(){

		$input = Input::all();
		$id = $input["id"];
		$status = false;

		try {
			$transaction = ATMInteraction::find($id);
			$status = $transaction->delete();

			$message = "";

		} catch(Exception $ex) {
			$message = "I'm sorry, You cannot delete this interaction.";
		}

		$responses = array(
			'idx'	  => $id,	
			'message' => $message,
			'status'  => $status,
		);

		return Response::json( $responses );

	}
	//END the deleteBankTransaction Method.
}

