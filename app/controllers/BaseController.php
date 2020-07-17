<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	static public function checkClient($user_id, $client_id) {
		$client = DB::table('userclients')
							->where('user_id', $user_id)
							->where('client_id', $client_id)
							->first();
		if ($client != null)
			return true;
		else
			return false;
	}

	static public function getRegion($client_id) {
		$client = Client::find($client_id);
		if ($client != null)
			return $client->region;
		else 
			return "";
	}

	static public function getBank($bank_id) {
		$bank = Bank::find($bank_id);
		if ($bank != null)
			return $bank->bankName;
		else 
			return "";
	} 

	static public function getBankByAccount($account_id) {

		$bank = DB::table('banks')
					->leftJoin('bank_accounts', 'banks.id', '=', 'bank_accounts.bank_id')
					->where('bank_accounts.id', '=', $account_id)
					->select('banks.bankName')
					->first();

		if ($bank != null)
			return $bank->bankName;
		else 
			return "";
	} 

	static public function getTerminalID($atm_id) {
		$atm = ATM::find($atm_id);
		if ($atm != null)
			return $atm->terminalID;
		else 
			return "";
	}

	static public function getBankAccount($accout_id) {
		$account = BankAccount::find($accout_id);
		if ($account != null)
			return $account->accountNumber;
		else 
			return "";
	}

	static public function getBankBranch($branch_id) {

		$branch = BankBranch::find($branch_id);
		if ($branch != null) {
			return $branch->bankAddress;
		}
		else 
			return "";
	}

	static public function getUser($user_id) {
		$user = User::find($user_id);
		if ($user != null)
			return $user->fname . " " . $user->lname;
		else 
			return "";
	}	
}
