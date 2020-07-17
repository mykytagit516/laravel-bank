<?php
use Illuminate\Support\MessageBag;
class BankController extends Controller{

	//START THE addBank Method
	public function addBank() {
		$bankName = Input::get('bankName');		
		
	    if (Input::server("REQUEST_METHOD") == "POST"){
	    	$rules = array(
				'bankName' => 'required'
   			);
   			$validator = Validator::make(Input::all(), $rules);

	         if ($validator->fails()){		
		       	return Redirect::route('admin/bank_new')->withErrors($validator);
	         } else {
             // validation ok
	            try {
	                //save on db/*
		            $bank = new Bank;
					$bank->bankName = $bankName;		           
		            $bank->save(); 

					$id = DB::getPdo()->lastInsertId();

					Session::flash('status_success', 'Successfully Updated.');
					return Redirect::route('admin/banks');
	            }  catch( Exception $e ) {
					echo $e;
	                Session::flash('status_error', 'An error occurred while creating a new bank - please try again.');
	                //return Redirect::route('admin/bank_new');
	            }
	        }
		}
	}		
	//END THE addBank Method

	//START THE addBankAccount Method
	public function addBankAccount() {
		$user = Input::get('user');
		$bank = Input::get('bank');
		$accountNumber = Input::get('accountNumber');
		$accountName = Input::get('accountName');		
		
	    if (Input::server("REQUEST_METHOD") == "POST"){
	    	$rules = array(     
				'bank' => 'required',
                'accountNumber' => 'required|min:8',
				'accountName' => 'required'				
   			);
   			$validator = Validator::make(Input::all(), $rules);

	         if ($validator->fails()){		
		       	return Redirect::route('admin/account_new')->withErrors($validator);
	         } else {
             // validation ok
	            try {
	                //save on db/*
		            $account = new BankAccount;
					$account->user_id = $user;
					$account->bank_id = $bank;
		            $account->accountNumber = $accountNumber;
					$account->accountName = $accountName;
		            $account->save(); 

					$id = DB::getPdo()->lastInsertId();

					Session::flash('status_success', 'Successfully Updated.');
					return Redirect::route('admin/accounts');
	            }  catch( Exception $e ) {
					echo $e;
	                Session::flash('status_error', 'An error occurred while creating a new account - please try again.');
	                //return Redirect::route('admin/account_new');
	            }
	        }
		}
	}		
	//END THE addBankAccount Method


		//START THE addBankBranch Method
	public function addBankBranch() {
		$bank = Input::get('bank');
		$bankAddress = Input::get('bankAddress');
		$bankPhone = Input::get('bankPhone');
		$bankContactName = Input::get('bankContactName');
		var_dump(Input::all());
	    if (Input::server("REQUEST_METHOD") == "POST"){
	    	$rules = array(     
				'bank' => 'required',
                'bankAddress' => 'required',
				'bankPhone' => 'required|min:8',
				'bankContactName' => 'required'
   			);
   			$validator = Validator::make(Input::all(), $rules);

	         if ($validator->fails()){		
		       	return Redirect::route('admin/branch_new')->withErrors($validator);
	         } else {
             // validation ok
	            try {
	                //save on db/*
		            $branch = new BankBranch;
					$branch->bank_id = $bank;
		            $branch->bankAddress = $bankAddress;
		            $branch->bankPhone = $bankPhone;
		            $branch->bankContactName = $bankContactName;
		            $branch->save(); 

					$id = DB::getPdo()->lastInsertId();

					Session::flash('status_success', 'Successfully Updated.');
					return Redirect::route('admin/branchs');
	            }  catch( Exception $e ) {
					echo $e;
	                Session::flash('status_error', 'An error occurred while creating a new branch - please try again.');
	                //return Redirect::route('admin/branch_new');
	            }
	        }
		}
	}		
	//END THE addBankBranch Method


	//START THE updateBank Method
	public function updateBank(){
		$id = Input::get('id');
		$bankName = Input::get('bankName');		
		
	    if (Input::server("REQUEST_METHOD") == "POST"){
	    	$rules = array(     
				'bankName' => 'required'
   			);
   			$validator = Validator::make(Input::all(), $rules);

	         if ($validator->fails()){		
		       	return Redirect::route('admin/bank_edit', array('id'=>$id))->withErrors($validator);
	         } else {
             // validation ok
	            try {
	                //save on db/*
					$bank = Bank::find($id);
					$bank->bankName = $bankName;
		            $bank->save(); 

					Session::flash('status_success', 'Successfully Updated.');
					return Redirect::route('admin/banks');
	            }  catch( Exception $e ) {
					echo $e;
	                Session::flash('status_error', 'An error occurred while creating a new bank - please try again.');
	                //return Redirect::route('admin/bank_edit', array('id'=>$id));
	            } 	          
	        }
		}
	}
	//END THE updateBank Method.	

	//START THE updateBankAccount Method
	public function updateBankAccount(){
		$id = Input::get('id');
		$user = Input::get('user');
		$bank = Input::get('bank');
		$accountNumber = Input::get('accountNumber');
		$accountName = Input::get('accountName');		
		
	    if (Input::server("REQUEST_METHOD") == "POST"){
	    	$rules = array(
				'user' => 'required',
				'bank' => 'required',
				'accountNumber' => 'required|min:8',
				'accountName' => 'required'
   			);
   			$validator = Validator::make(Input::all(), $rules);

	         if ($validator->fails()){		
		       	return Redirect::route('admin/account_edit', array('id'=>$id))->withErrors($validator);
	         } else {
             // validation ok
	            try {
	                //save on db/*
					$account = BankAccount::find($id);
					$account->user_id = $user;
		            $account->bank_id = $bank;
		            $account->accountNumber = $accountNumber;
		            $account->accountName = $accountName;		          
		            $account->save(); 

					Session::flash('status_success', 'Successfully Updated.');
					return Redirect::route('admin/accounts');
	            }  catch( Exception $e ) {
					echo $e;
	                Session::flash('status_error', 'An error occurred while creating a new account - please try again.');
	                //return Redirect::route('admin/account_edit', array('id'=>$id));
	            } 	          
	        }
		}
	}
	//END THE updateBankAccount Method.

		//START THE updateBankBranch Method
	public function updateBankBranch(){
		$id = Input::get('id');
		$bank = Input::get('bank');
		$bankAddress = Input::get('bankAddress');
		$bankPhone = Input::get('bankPhone');
		$bankContactName = Input::get('bankContactName');
		
	    if (Input::server("REQUEST_METHOD") == "POST"){
	    	$rules = array(     
				'bank' => 'required',
                'bankAddress' => 'required',
				'bankPhone' => 'required|min:8',
				'bankContactName' => 'required'			
   			);
   			$validator = Validator::make(Input::all(), $rules);

	         if ($validator->fails()){		
		       	return Redirect::route('admin/branch_edit', array('id'=>$id))->withErrors($validator);
	         } else {
             // validation ok
	            try {
	                //save on db/*
					$branch = BankBranch::find($id);
					$branch->bank_id = $bank;
		            $branch->bankAddress = $bankAddress;
		            $branch->bankPhone = $bankPhone;
		            $branch->bankContactName = $bankContactName;		            
		            $branch->save(); 

					Session::flash('status_success', 'Successfully Updated.');
					return Redirect::route('admin/branch');
	            }  catch( Exception $e ) {
					echo $e;
	                Session::flash('status_error', 'An error occurred while creating a new branch - please try again.');
	                //return Redirect::route('admin/branch_edit', array('id'=>$id));
	            } 	          
	        }
		}
	}
	//END THE updateBankBranch Method.

	//START the deleteBank Method
	public function deleteBank(){

		$input = Input::all();
		$id = $input["id"];
		$status = false;

		try {
			$contact = Bank::find($id);
			$status = $contact->delete();

			$message = "";

		} catch(Exception $ex) {
			$message = "I'm sorry, You cannot delete this bank.";
		}

		$responses = array(
			'idx'	  => $id,	
			'message' => $message,
			'status'  => $status,
		);

		return Response::json( $responses );

	}
	//END the deleteBank Method.

		//START the deleteBankAccount Method
	public function deleteBankAccount(){

		$input = Input::all();
		$id = $input["id"];
		$status = false;

		try {
			$contact = BankAccount::find($id);
			$status = $contact->delete();

			$message = "";

		} catch(Exception $ex) {
			$message = "I'm sorry, You cannot delete this bank account.";
		}

		$responses = array(
			'idx'	  => $id,	
			'message' => $message,
			'status'  => $status,
		);

		return Response::json( $responses );

	}
	//END the deleteBankAccount Method.

		//START the deleteBankBranch Method
	public function deleteBankBranch(){

		$input = Input::all();
		$id = $input["id"];
		$status = false;

		try {
			$contact = BankBranch::find($id);
			$status = $contact->delete();

			$message = "";

		} catch(Exception $ex) {
			$message = "I'm sorry, You cannot delete this bank branch.";
		}

		$responses = array(
			'idx'	  => $id,	
			'message' => $message,
			'status'  => $status,
		);

		return Response::json( $responses );

	}
	//END the deleteBankBranch Method.
}

