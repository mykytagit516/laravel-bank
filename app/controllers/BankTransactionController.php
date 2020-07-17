<?php
use Illuminate\Support\MessageBag;

class BankTransactionController extends Controller{

	//START the assetAction Method
	public function asssetAction(){
		if (Input::server("REQUEST_METHOD") == "POST") {
			try {
				$file = Input::get('assetFile');
				$type = Input::get('assetType');
	
				$orignal_path = str_replace("thumbnail/", "", $file);

				$orignal_file = str_replace("100crop.jpg", ".jpg", $orignal_path);
				$orignal264Image_file = str_replace("100crop.jpg", "264crop.jpg", $file);				
				
				if (file_exists(public_path() . $orignal_file)) {
					unlink(public_path() . $orignal_file);
				}

				if (file_exists(public_path() . $orignal264Image_file)) {
					unlink(public_path() . $orignal264Image_file);
				}

				if (file_exists(public_path() . $file)) {
					unlink(public_path() . $file);
				}	
				$status = true;
			} catch (Exception $ex) {
				echo $ex;
				$status = false;
			}

			$responses = array(
				'status' => $status,
			);

			return Response::json( $responses );			
		}
	}
	//END the assetAction Method

	//START THE addDeposit Method
	public function addDeposit() {
		$account = Input::get('account');
		$branch = Input::get('branch');
		$atm = Input::get('atm');
		$evidence = Input::get('evidence');
		$TotalAmountDeposited = Input::get('TotalAmountDeposited');
		
	    if (Input::server("REQUEST_METHOD") == "POST"){
	    	$rules = array(     
				'account' => 'required',
                'branch' => 'required',
				'atm' => 'required',
				'evidence' => 'image'
   			);
   			$validator = Validator::make(Input::all(), $rules);

	         if ($validator->fails()){		
		       	return Redirect::route('admin/deposit_new')->withErrors($validator);
	         } else {
             // validation ok
	            try {
	                //save on db/*
		            $deposit = new BankTransaction;
					$depositdepositdeposit->bankAccount_id = $account;
		            $depositdeposit->bankBranch_id = $branch;
		            $deposit->atm_id = $atm;

					$interactionByATM = DB::table('atm_interactions')
										->where('atm_id', $atm)
										->select('totalRebankAmount')
										->orderBy('created_at', 'desc')
										->first();
					
		            $deposit->TotalAmountDeposited = $TotalAmountDeposited;
		            $deposit->type = 'deposit';

					$image_pos = strripos($evidence, "/");
					$image_path = substr($evidence, 0, $image_pos + 1);
					$image_file = substr($evidence, $image_pos + 1);
					$deposit->filename = $image_file;
					$deposit->filepath = $image_path;
					$deposit->created_at = date("Y-m-d H:i:s");
					$deposit->updated_at = date("Y-m-d H:i:s");
		            $deposit->save();

					$id = DB::getPdo()->lastInsertId();

					Session::flash('status_success', 'Successfully Updated.');
					return Redirect::route('admin/deposits');
	            }  catch( Exception $e ) {
					echo $e;
	                Session::flash('status_error', 'An error occurred while creating a new deposit - please try again.');
	                //return Redirect::route('admin/deposit_new');
	            }
	        }
		}
	}		
	//END THE addDeposit Method

	//START THE updateDeposit Method
	public function updateDeposit(){
		$id = Input::get('id');
		$account = Input::get('account');
		$branch = Input::get('branch');
		$atm = Input::get('atm');
		$evidence = Input::get('evidence');
		$TotalAmountDeposited = Input::get('TotalAmountDeposited');
		
	    if (Input::server("REQUEST_METHOD") == "POST"){
	    	$rules = array(     
				'account' => 'required',
                'branch' => 'required',
				'atm' => 'required'
   			);
   			$validator = Validator::make(Input::all(), $rules);

	         if ($validator->fails()){		
		       	return Redirect::route('admin/withdraw_edit', array('id'=>$id))->withErrors($validator);
	         } else {
             // validation ok
	            try {
	                //save on db/*
					$deposit = BankTransaction::find($id);
					$deposit->bankAccount_id = $account;
		            $deposit->bankBranch_id = $branch;
		            $deposit->atm_id = $atm;
		           
					$interactionByATM = DB::table('atm_interactions')
										->where('atm_id', $atm)
										->select('totalRebankAmount')
										->orderBy('created_at', 'desc')
										->first();					

					$image_pos = strripos($evidence, "/");
					$image_path = substr($evidence, 0, $image_pos + 1);
					$image_file = substr($evidence, $image_pos + 1);
					$deposit->filename = $image_file;
					$deposit->filepath = $image_path;						
		            $deposit->TotalAmountDeposited = $TotalAmountDeposited;
		            $deposit->type = 'deposit';
		            $deposit->updated_at = date("Y-m-d H:i:s");
		            $deposit->save();

					Session::flash('status_success', 'Successfully Updated.');
					return Redirect::route('admin/deposits');
	            }  catch( Exception $e ) {
					echo $e;
	                Session::flash('status_error', 'An error occurred while updating the deposit - please try again.');
	                //return Redirect::route('admin/withdraw_edit', array('id'=>$id));
	            } 	          
	        }
		}
	}
	//END THE updateDeposit Method.

	//START THE addWithdraw Method
	public function addWithdraw() {
		$account = Input::get('account');
		$branch = Input::get('branch');
		$atm = Input::get('atm');
		$evidence = Input::get('evidence');

		if (Input::get('sourceDestination') == null)
			$sourceDestination = "atm";
		else
			$sourceDestination = "spare";

		$C1 = Input::get('C1');
		$C2 = Input::get('C2');
		
		$TotalAmountWithdrawn = Input::get('TotalAmountWithdrawn');
		
	    if (Input::server("REQUEST_METHOD") == "POST"){
	    	$rules = array(     
				'account' => 'required',
                'branch' => 'required',
				'atm' => 'required',
				'evidence' => 'image'
   			);
   			$validator = Validator::make(Input::all(), $rules);

	         if ($validator->fails()){		
		       		return Redirect::route('admin/withdraw_new')->withErrors($validator);
	         } else {
             // validation ok
	            try {
	                //save on db/*
		            $withdraw = new BankTransaction;
					$withdraw->bankAccount_id = $account;
		            $withdraw->bankBranch_id = $branch;
		            $withdraw->atm_id = $atm;
					$withdraw->sourceDestination = $sourceDestination;
					$withdraw->C2 = $C2;
					$withdraw->C1 = $C1;
		            $withdraw->TotalAmountWithdrawn = $TotalAmountWithdrawn;
					$image_pos = strripos($evidence, "/");
					$image_path = substr($evidence, 0, $image_pos + 1);
					$image_file = substr($evidence, $image_pos + 1);
					$withdraw->filename = $image_file;
					$withdraw->filepath = $image_path;			            
		            $withdraw->type = 'withdraw';

					$withdraw->created_at = date("Y-m-d H:i:s");
					$withdraw->updated_at = date("Y-m-d H:i:s");

		            $transaction->save();

					$id = DB::getPdo()->lastInsertId();

					Session::flash('status_success', 'Successfully Updated.');
					//return Redirect::route('admin/withdraws');
	            }  catch( Exception $e ) {
					echo $e;
	                Session::flash('status_error', 'An error occurred while creating a new withdraw transaction - please try again.');
	                //return Redirect::route('admin/withdraw_new');
	            }
	        }
		}
	}		
	//END THE addWithdraw Method

	//START THE updateWithdraw Method
	public function updateWithdraw(){
		$id = Input::get('id');
		$account = Input::get('account');
		$branch = Input::get('branch');
		$atm = Input::get('atm');
		$evidence = Input::get('evidence');
		if (Input::get('sourceDestination') == null)
			$sourceDestination = "atm";
		else
			$sourceDestination = "spare";

		$C1 = Input::get('C1');
		$C2 = Input::get('C2');
		
		$TotalAmountWithdrawn = Input::get('TotalAmountWithdrawn');

	    if (Input::server("REQUEST_METHOD") == "POST"){
	    	$rules = array(     
				'account' => 'required',
                'branch' => 'required',
				'atm' => 'required'
   			);
   			$validator = Validator::make(Input::all(), $rules);

	         if ($validator->fails()){		
		       	return Redirect::route('admin/withdraw_new', array('id'=>$id))->withErrors($validator);
	         } else {
             // validation ok
	            try {
	                //save on db/*
					$withdraw = BankTransaction::find($id);
					$withdraw->bankAccount_id = $account;
		            $withdraw->bankBranch_id = $branch;
		            $withdraw->atm_id = $atm;
					$withdraw->sourceDestination = $sourceDestination;
					$withdraw->C2 = $C2;
					$withdraw->C1 = $C1;
		            $withdraw->TotalAmountWithdrawn = $TotalAmountWithdrawn;
					$image_pos = strripos($evidence, "/");
					$image_path = substr($evidence, 0, $image_pos + 1);
					$image_file = substr($evidence, $image_pos + 1);
					$withdraw->filename = $image_file;
					$withdraw->filepath = $image_path;			            
		            $withdraw->type = 'withdraw';

					$withdraw->updated_at = date("Y-m-d H:i:s");
		            $withdraw->save();

					Session::flash('status_success', 'Successfully Updated.');
					return Redirect::route('admin/withdraws');
	            }  catch( Exception $e ) {
					echo $e;
	                Session::flash('status_error', 'An error occurred while updating the withdraw transaction - please try again.');
	                //return Redirect::route('admin/withdraw_new', array('id'=>$id));
	            } 	          
	        }
		}
	}
	//END THE updateWithdraw Method.

	//START the deleteBankTransaction Method
	public function deleteBankTransaction(){

		$input = Input::all();
		$id = $input["id"];
		$status = false;

		try {
			$transaction = BankTransaction::find($id);
			$status = $transaction->delete();

			$message = "";

		} catch(Exception $ex) {
			$message = "I'm sorry, You cannot delete this bank transaction.";
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

