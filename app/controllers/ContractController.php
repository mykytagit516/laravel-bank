<?php
use Illuminate\Support\MessageBag;
class ContractController extends Controller{

	//START THE addContract Method
	public function addContract() {
		$atm = Input::get('atm');		
		$billingPeriodEnd = Input::get('billingPeriodEnd');
		if (Input::get('fixedPriceContractYN') != null)
			$fixedPriceContractYN = Input::get('fixedPriceContractYN');
		else
			$fixedPriceContractYN = 0;

		$fixedPriceAmount = Input::get('fixedPriceAmount');

		if (Input::get('monthlyTransSummaryYN') != null)
			$monthlyTransSummaryYN = Input::get('monthlyTransSummaryYN');
		else
			$monthlyTransSummaryYN = 0;

		$lowThreshold = Input::get('lowThreshold');
		$highThreshold = Input::get('highThreshold');
		$thresholdRate = Input::get('thresholdRate');
		
	    if (Input::server("REQUEST_METHOD") == "POST"){
	    	$rules = array(     
				'atm' => 'required|min:1',
                'billingPeriodEnd' => 'required|min:2'			
   			);
   			$validator = Validator::make(Input::all(), $rules);

	         if ($validator->fails()){		
		       	return Redirect::route('admin/contract_new')->withErrors($validator);
	         } else {
             // validation ok
	            try {
	                //save on db/*
		            $contract = new Contract;
					$contract->atm_id = $atm;
		            $contract->billingPeriodEnd = $billingPeriodEnd;
		            $contract->fixedPriceContractYN = $fixedPriceContractYN;
		            $contract->fixedPriceAmount = $fixedPriceAmount;
		            $contract->monthlyTransSummaryYN = $monthlyTransSummaryYN;
					$contract->lowThreshold = $lowThreshold;
					$contract->highThreshold = $highThreshold;
					$contract->thresholdRate = $thresholdRate;
		            $contract->save(); 

					$id = DB::getPdo()->lastInsertId();

					Session::flash('status_success', 'Successfully Updated.');
					return Redirect::route('admin/contracts');
	            }  catch( Exception $e ) {
					echo $e;
	                Session::flash('status_error', 'An error occurred while creating a new account - please try again.');
	                return Redirect::route('admin/contract_new');
	            }
	        }
		}
	}		
	//END THE addContract Method

	//START THE updateAction Method
	public function updateAction(){
		$id = Input::get('id');
		$atm = Input::get('atm');
		$billingPeriodEnd = Input::get('billingPeriodEnd');
		$fixedPriceContractYN = Input::get('fixedPriceContractYN');
		$fixedPriceAmount = Input::get('fixedPriceAmount');
		$monthlyTransSummaryYN = Input::get('monthlyTransSummaryYN');
		$lowThreshold = Input::get('lowThreshold');
		$highThreshold = Input::get('highThreshold');
		$thresholdRate = Input::get('thresholdRate');
		
	    if (Input::server("REQUEST_METHOD") == "POST"){
	    	$rules = array(     
				'atm' => 'required|min:1',
                'billingPeriodEnd' => 'required|min:2'
   			);
   			$validator = Validator::make(Input::all(), $rules);

	         if ($validator->fails()){		
		       	return Redirect::route('admin/contract_edit', array('id'=>$id))->withErrors($validator);
	         } else {
             // validation ok
	            try {
	                //save on db/*
					$contract = Contract::find($id);
					$contract->atm_id = $atm;
		            $contract->billingPeriodEnd = $billingPeriodEnd;
		            $contract->fixedPriceContractYN = $fixedPriceContractYN;
		            $contract->fixedPriceAmount = $fixedPriceAmount;
		            $contract->monthlyTransSummaryYN = $monthlyTransSummaryYN;
					$contract->lowThreshold = $lowThreshold;
					$contract->highThreshold = $highThreshold;
					$contract->thresholdRate = $thresholdRate;
		            $contract->save(); 

					Session::flash('status_success', 'Successfully Updated.');
					return Redirect::route('admin/contracts');
	            }  catch( Exception $e ) {
					echo $e;
	                Session::flash('status_error', 'An error occurred while creating a new account - please try again.');
	                return Redirect::route('admin/contract_edit', array('id'=>$id));
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
			$contract = Contract::find($id);
			$status = $contract->delete();

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

