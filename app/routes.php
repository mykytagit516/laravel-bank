<?php
/*
//Get Routes
*/

Route::get('/', function()
{	
	return Redirect::route("base/login");
});

Route::get('/page', function() {
   return 'Hello world!';
});

Route::get('/admin', function()
{	
	return Redirect::route("base/login");
});

//Route to login page
Route::get("login", array(
	"as" => "user/login", function(){
		return View::make("base/signin");
}));

//Route to welcome page
Route::get("welcome", array(
	"as" => "user/welcome", function(){
    return View::make("user/welcome");
}));

//Route to welcome page
Route::get("verified", array(
	"as" => "user/verified", function(){
    return View::make("user/verified");
}));

//Route to password reset request form
Route::get("request", array("as" => "user/request", function(){
    return View::make("base/request");
}));

//Route to password reset form
Route::get("reset", array(
    "as"   => "user/reset",
    "uses" => "UserController@resetAction"
));

Route::get("verify", array(
    "as"   => "user/verify",
    "uses" => "UserController@verifyAction"
));

//Route to registration page
Route::get ("signup", array(
	"as" => "user/signup", function() {
	return View::make("user/signup");
}));

/* 
//Authorized BY Administrator
*/

Route::group(array("before" => "auth|auth.admin"), function(){
	//Route to admin dashboard
	Route::get("admin", array(
		"as" => "admin/home", function(){
		$user = Auth::user();

		return View::make("admin/home")
				->with("title", "Dashboard")
				->with("sub_title", "")
				->with("user", $user);	
	}));

	//Route to admin Users
	Route::get("admin_users", array(
		"as" => "admin/users", function(){
		$user = Auth::user();
		$users = DB::table('users')->get();	
		return View::make("admin/users")
				->with("title", "Users")
				->with("sub_title", "All Users")
				->with("users", $users)
				->with("user", $user);	
	}));	

	//Route to admin New user
	Route::get("admin_user/new", array(
		"as" => "admin/user_new", function(){
		$user = Auth::user();

		return View::make("admin/user_new")
				->with("title","Users")
				->with("sub_title", "Add User")
				->with("userByID", null)
				->with("user", $user);
	}));	

	//Route to admin New user
	Route::get("admin_user/edit/{id}", array(
		"as" => "admin/user_edit", function($id){
		$user = Auth::user();
		$userByID = User::find($id);
		$clients = DB::table('clients')->get();
		return View::make("admin/user_edit")
				->with("title","Users")
				->with("sub_title", "Edit User")
				->with("userByID", $userByID)
				->with("clients", $clients)
				->with("user", $user);	
	}));


	/* Clients Event START */
	//Route for clients list
	Route::get("admin_clients", array(
		"as" => "admin/clients", function(){
		$user = Auth::user();
		$clients = DB::table('clients')->get();	
		return View::make("admin/clients")
				->with("title", "Clients")
				->with("sub_title", "All Clients")
				->with("clients", $clients)
				->with("user", $user);	
	}));	

	//Route for adding the client
	Route::get("admin_client/new", array(
		"as" => "admin/client_new", function(){
		$user = Auth::user();

		return View::make("admin/client_new")
				->with("title","Clients")
				->with("sub_title", "Add Client")
				->with("clientByID", null)
				->with("user", $user);
	}));	

	//Route for editing the client
	Route::get("admin_client/edit/{id}", array(
		"as" => "admin/client_edit", function($id){
		$user = Auth::user();
		$clientByID = Client::find($id);
		return View::make("admin/client_new")
				->with("title","Clients")
				->with("sub_title", "Edit Client")
				->with("clientByID", $clientByID)
				->with("user", $user);	
	}));
	/* Clients Event END */

	/* ClientContacts Event START */	
	//Route for clientcontacts list
	Route::get("admin_clientcontacts", array(
		"as" => "admin/clientcontacts", function(){
		$user = Auth::user();
		$clientcontacts = DB::table('clientcontacts')->get();	
		
		return View::make("admin/clientcontacts")
				->with("title", "Clients")
				->with("sub_title", "All ClientContacts")
				->with("clientcontacts", $clientcontacts)
				->with("user", $user);	
	}));	

	//Route for adding the clientcontact
	Route::get("admin_clientcontact/new", array(
		"as" => "admin/clientcontact_new", function(){
		$user = Auth::user();
		$clients = DB::table('clients')
							->where('published', 1)
							->get();
		
		return View::make("admin/clientcontact_new")
				->with("title","Clients")
				->with("sub_title", "Add ClientContact")
				->with("clientContactByID", null)
				->with("clients", $clients)
				->with("user", $user);	
	}));	

	//Route for editing the clientcontact
	Route::get("admin_clientcontact/edit/{id}", array(
		"as" => "admin/clientcontact_edit", function($id){
		$user = Auth::user();

		$clientContactByID = ClientContact::find($id);
		$clients = DB::table('clients')
							->where('published', 1)
							->get();

		return View::make("admin/clientcontact_new")
				->with("title", "Clients")
				->with("sub_title", "Edit ClientContact")
				->with("clientContactByID", $clientContactByID)
				->with("clients", $clients)
				->with("user", $user);	
	}));
	/* ClientContacts Event END */	

	/* ATM Event START */	
	//Route for atm list
	Route::get("admin_atm", array(
		"as" => "admin/atm", function(){
		$user = Auth::user();
		$atm = DB::table('atm')->get();	

		return View::make("admin/atm")
				->with("title", "ATM")
				->with("sub_title", "All ATM")
				->with("atm", $atm)
				->with("user", $user);	
	}));	

	//Route for adding the atm
	Route::get("admin_atm/new", array(
		"as" => "admin/atm_new", function(){
		$user = Auth::user();
		$clients = DB::table('clients')
							->where('published', 1)
							->get();		
		return View::make("admin/atm_new")
				->with("title","ATM")
				->with("sub_title", "Add ATM")
				->with("atmByID", null)
				->with("clients", $clients)
				->with("user", $user);	
	}));	

	//Route for editing the atm
	Route::get("admin_atm/edit/{id}", array(
		"as" => "admin/atm_edit", function($id){
		$user = Auth::user();
		$atmByID = ATM::find($id);
		$clients = DB::table('clients')
							->where('published', 1)
							->get();	
		return View::make("admin/atm_new")
				->with("sub_title", "Edit ATM")
				->with("title","ATM")
				->with("atmByID", $atmByID)
				->with("clients", $clients)
				->with("user", $user);	
	}));

	//Route for adding the cash 
	Route::get("admin_cash/new", array(
		"as" => "admin/cash_new", function(){
		$user = Auth::user();
		
		$accounts = DB::table('bank_accounts')
							->where('user_id', $user->id)
							->get();
		
		$atm = DB::table('atm')
						->leftJoin('userclients', 'userclients.client_id', '=', 'atm.clients_id')
						->leftJoin('users', 'users.id', '=', 'userclients.user_id')
						->where('users.id', '=', $user->id)
						->select('atm.terminalID', 'atm.id')
						->get();

		return View::make("admin/atm_cash_new")
				->with("title","ATM")
				->with("sub_title", "Add Cash")
				->with("interactionByID", null)
				->with("atm", $atm)
				->with("user", $user);	
	}));
	
	//Route for editing the cash
	Route::get("admin_interaction/edit/{id}", array(
		"as" => "admin/interaction_edit", function($id){
		$user = Auth::user();
		$interactionByID = ATMinteraction::find($id);		
		
		$atm = DB::table('atm')
						->leftJoin('userclients', 'userclients.client_id', '=', 'atm.clients_id')
						->leftJoin('users', 'users.id', '=', 'userclients.user_id')
						->where('users.id', '=', $user->id)
						->select('atm.terminalID', 'atm.id')
						->get();
		if ($interactionByID->sourceMoney == 'atm') {
			$sources = DB::table('atm')
							->leftJoin('userclients', 'userclients.client_id', '=', 'atm.clients_id')
							->leftJoin('users', 'users.id', '=', 'userclients.user_id')
							->where('users.id', '=', $user->id)
							->select('atm.terminalID', 'atm.id')
							->get();
		} else if ($interactionByID->sourceMoney == 'bank') {
			$sources = DB::table('bank_accounts')
								->where('user_id', $user->id)
								->select('id', 'accountNumber')
								->get();
		} else {
		}

		if ($interactionByID->type == 'cash') {
			return View::make("admin/atm_cash_new")
					->with("sub_title", "Edit Cash")
					->with("title","ATM")
					->with("interactionByID", $interactionByID)
					->with("atm", $atm)
					->with("sources", $sources)
					->with("user", $user);			
		} else {
			return View::make("admin/atm_rebank_new")
					->with("title","ATM")
					->with("sub_title", "Edit Rebank")
					->with("interactionByID", $interactionByID)
					->with("atm", $atm)
					->with("sources", $sources)
					->with("user", $user);
		}
	}));

	//Route for adding the rebank
	Route::get("admin_rebank/new", array(
		"as" => "admin/rebank_new", function(){
		$user = Auth::user();

		
		$accounts = DB::table('bank_accounts')
							->where('user_id', $user->id)
							->get();
		
		$atm = DB::table('atm')
						->leftJoin('userclients', 'userclients.client_id', '=', 'atm.clients_id')
						->leftJoin('users', 'users.id', '=', 'userclients.user_id')
						->where('users.id', '=', $user->id)
						->select('atm.terminalID', 'atm.id')
						->get();
		
		return View::make("admin/atm_rebank_new")
				->with("title","ATM")
				->with("sub_title", "Add Rebank")
				->with("interactionByID", null)
				->with("atm", $atm)
				->with("user", $user);	
	}));

	//Route for adding the atm
	Route::get("admin_interactions", array(
		"as" => "admin/interactions", function(){
		$user = Auth::user();

		$interactions = DB::table('atm_interactions')
									->where('user_id', $user->id)
									->get();

		return View::make("admin/atm_interactions")
				->with("title", "ATM")
				->with("sub_title", "ATM Interactions")
				->with("interactions", $interactions)
				->with("user", $user);	
	}));	
	/* ATM Event END */	

	/* Contracts Event START */	
	//Route for Contracts list
	Route::get("admin_contracts", array(
		"as" => "admin/contracts", function(){
		$user = Auth::user();
		$contracts = DB::table('contracts')->get();	

		return View::make("admin/contracts")
				->with("title", "Contracts")
				->with("sub_title", "All Contracts")
				->with("contracts", $contracts)
				->with("user", $user);	
	}));	

	//Route for adding the atm
	Route::get("admin_contract/new", array(
		"as" => "admin/contract_new", function(){
		$user = Auth::user();
		$atm = DB::table('atm')
							->get();

		return View::make("admin/contract_new")
				->with("title","Contracts")
				->with("sub_title", "Add Contract")
				->with("contractByID", null)
				->with("atm", $atm)
				->with("user", $user);	
	}));	

	//Route for editing the atm
	Route::get("admin_contract/edit/{id}", array(
		"as" => "admin/contract_edit", function($id){
		$user = Auth::user();
		
		$contractByID = Contract::find($id);
		return View::make("admin/contract_edit")
				->with("sub_title", "Edit Contract")
				->with("title","Contracts")
				->with("contractByID", $contractByID)
				->with("user", $user);	
	}));
	/* Contracts Event END */	

	/* Banks Event START */	
	//Route for bank list
	Route::get("admin_banks", array(
		"as" => "admin/banks", function(){
		$user = Auth::user();
		$banks = DB::table('banks')->get();	

		return View::make("admin/banks")
				->with("title", "Bank")
				->with("sub_title", "All Banks")
				->with("banks", $banks)
				->with("user", $user);	
	}));	

	//Route for adding the atm
	Route::get("admin_bank/new", array(
		"as" => "admin/bank_new", function(){
		$user = Auth::user();
		$clients = DB::table('clients')
							->where('published', 1)
							->get();	
		
		return View::make("admin/bank_new")
				->with("title","Bank")
				->with("sub_title", "Add Bank")
				->with("bankByID", null)
				->with("clients", $clients)
				->with("user", $user);	
	}));	

	//Route for editing the atm
	Route::get("admin_bank/edit/{id}", array(
		"as" => "admin/bank_edit", function($id){
		$user = Auth::user();
		$bankByID = Bank::find($id);
		$clients = DB::table('clients')
							->where('published', 1)
							->get();	
		return View::make("admin/bank_new")				
				->with("title", "Bank")
				->with("sub_title", "Edit Bank")
				->with("bankByID", $bankByID)
				->with("clients", $clients)
				->with("user", $user);	
	}));
	/* Banks Event END */
	
	/* Bank Account Event START */	
	//Route for bank account list
	Route::get("admin_accounts", array(
		"as" => "admin/accounts", function(){
		$user = Auth::user();
		$accounts = DB::table('bank_accounts')->get();	

		return View::make("admin/bank_accounts")
				->with("title", "Bank")
				->with("sub_title", "All Accounts")
				->with("accounts", $accounts)
				->with("user", $user);	
	}));	

	//Route for adding the atm
	Route::get("admin_account/new", array(
		"as" => "admin/account_new", function(){
		$user = Auth::user();
		$users = DB::table('users')
							->where('published', 1)
							->get();	
		$banks = DB::table('banks')
							->get();
		$accounts = array(
		    "account_a" => "Account A",
		    "account_b" => "Account B",
		    "account_c" => "Account C",
		    "account_d" => "Account D",
		    "account_e" => "Account E"
		); 

		return View::make("admin/bank_account_new")
				->with("title","Bank")
				->with("sub_title", "Add Account")
				->with("accountByID", null)
				->with("users", $users)
				->with("banks", $banks)
				->with("accounts", $accounts)
				->with("user", $user);	
	}));	

	//Route for editing the atm
	Route::get("admin_account/edit/{id}", array(
		"as" => "admin/account_edit", function($id){
		$user = Auth::user();
		$accountByID = BankAccount::find($id);
		$users = DB::table('users')
							->where('published', 1)
							->get();
		$banks = DB::table('banks')
							->get();

		$accounts = array(
		    "account_a" => "Account A",
		    "account_b" => "Account B",
		    "account_c" => "Account C",
		    "account_d" => "Account D",
		    "account_e" => "Account E"
		); 

		return View::make("admin/bank_account_new")
				->with("title", "Bank")
				->with("sub_title", "Edit Account")				
				->with("accountByID", $accountByID)
				->with("users", $users)
				->with("banks", $banks)
				->with("accounts", $accounts)
				->with("user", $user);	
	}));
	/* Bank Account Event END */

	/* Bank Branch Event START */	
	//Route for bank branch list
	Route::get("admin_branchs", array(
		"as" => "admin/branchs", function(){
		$user = Auth::user();
		$branchs = DB::table('bank_branchs')->get();	

		return View::make("admin/bank_branchs")
				->with("title", "Bank")
				->with("sub_title", "All Branches")
				->with("branchs", $branchs)
				->with("user", $user);	
	}));	

	//Route for adding the atm
	Route::get("admin_branch/new", array(
		"as" => "admin/branch_new", function(){
		$user = Auth::user();
		$banks = DB::table('banks')
							->get();	
		
		return View::make("admin/bank_branch_new")
				->with("title","Bank")
				->with("sub_title", "Add Branch")
				->with("branchByID", null)
				->with("banks", $banks)
				->with("user", $user);	
	}));	

	//Route for editing the atm
	Route::get("admin_branch/edit/{id}", array(
		"as" => "admin/branch_edit", function($id){
		$user = Auth::user();
		$branchByID = BankBranch::find($id);
		$banks = DB::table('banks')
							->get();

		return View::make("admin/bank_branch_new")
				->with("title", "Bank")
				->with("sub_title", "Edit Branch")				
				->with("branchByID", $branchByID)
				->with("banks", $banks)
				->with("user", $user);	
	}));
	/* Bank Branch Event END */

	/* Bank Withdraw Transaction Event START */	
	// List Route for bank transaction of withdraw
	Route::get("admin_withdraws", array(
		"as" => "admin/withdraws", function(){
		$user = Auth::user();
		//$withdraw_transactions = DB::table('bank_transactions')
		//							->where('type', 'withdraw')
		//							->get();	

		$withdraw_transactions = DB::table('bank_transactions')
									->leftJoin('bank_accounts', 'bank_accounts.id', '=', 'bank_transactions.bankAccount_id')
									->where('bank_transactions.type', '=', 'withdraw')
									->where('bank_accounts.user_id', $user->id)
									->get();

		return View::make("admin/bank_transactions")
				->with("title", "Transaction")
				->with("sub_title", "All Withdraws")
				->with("transactions", $withdraw_transactions)
				->with("transaction", "withdraw")
				->with("user", $user);	
	}));	

	//Route for adding the withdraw
	Route::get("admin_withdraw/new", array(
		"as" => "admin/withdraw_new", function(){
		$user = Auth::user();
		$accounts = DB::table('bank_accounts')
							->where('user_id', $user->id)
							->get();

		$branchs = DB::table('bank_branchs')
							->get();	
		
		$atm = DB::table('atm')
						->leftJoin('userclients', 'userclients.client_id', '=', 'atm.clients_id')
						->leftJoin('users', 'users.id', '=', 'userclients.user_id')
						->where('users.id', '=', $user->id)
						->select('atm.terminalID', 'atm.id')
						->get();

		return View::make("admin/bank_withdraw_new")
				->with("title","Transaction")
				->with("sub_title", "Add Withdraw")
				->with("transactionByID", null)
				->with("accounts", $accounts)
				->with("branchs", $branchs)
				->with("atm", $atm)
				->with("user", $user);	
	}));

	//Route for editing the withdraw
	Route::get("admin_withdraw/edit/{id}", array(
		"as" => "admin/withdraw_edit", function($id){
		$user = Auth::user();
		$accounts = DB::table('bank_accounts')		
							->get();	

		$atm = DB::table('atm')
						->leftJoin('userclients', 'userclients.client_id', '=', 'atm.clients_id')
						->leftJoin('users', 'users.id', '=', 'userclients.user_id')
						->where('users.id', '=', $user->id)
						->select('atm.terminalID', 'atm.id')
						->get();

		$transactionByID = BankTransaction::find($id);

		$branchs = DB::table('banks')
						->leftJoin('bank_accounts', 'banks.id', '=', 'bank_accounts.bank_id')
						->leftJoin('bank_branchs', 'bank_branchs.bank_id', '=', 'banks.id')
						->where('bank_accounts.id', '=', $transactionByID->bankAccount_id)
						->select('bank_branchs.id', 'bank_branchs.bankAddress')
						->get();	

		return View::make("admin/bank_withdraw_new")
				->with("title","Transaction")
				->with("sub_title", "Add Withdraw")
				->with("transactionByID", $transactionByID)
				->with("accounts", $accounts)
				->with("branchs", $branchs)
				->with("atm", $atm)
				->with("user", $user);	
	}));
	/* Bank Withdraw Transaction Event END */

	/* Bank Deposit Transaction Event START */	
	// List Route for bank transaction of deposit
	Route::get("admin_deposits", array(
		"as" => "admin/deposits", function(){
		$user = Auth::user();
		//$deposite_transactions = DB::table('bank_transactions')
		//									->where('type', 'deposit')
		//									->get();	
		$deposite_transactions = DB::table('bank_transactions')
									->leftJoin('bank_accounts', 'bank_accounts.id', '=', 'bank_transactions.bankAccount_id')
									->where('bank_transactions.type', '=', 'deposit')
									->where('bank_accounts.user_id', $user->id)
									->get();

		return View::make("admin/bank_transactions")
				->with("title", "Transaction")
				->with("sub_title", "All Deposits")
				->with("transactions", $deposite_transactions)
				->with("transaction", "deposit")
				->with("user", $user);	
	}));	

	//Route for adding the deposit
	Route::get("admin_deposit/new", array(
		"as" => "admin/deposit_new", function(){
		$user = Auth::user();
		$accounts = DB::table('bank_accounts')
							->where('user_id', $user->id)
							->get();

		$branchs = DB::table('bank_branchs')
							->get();	

		$atm = DB::table('atm')
						->leftJoin('userclients', 'userclients.client_id', '=', 'atm.clients_id')
						->leftJoin('users', 'users.id', '=', 'userclients.user_id')
						->where('users.id', '=', $user->id)
						->select('atm.terminalID', 'atm.id')
						->get();	
		
		return View::make("admin/bank_deposit_new")
				->with("title","Transaction")
				->with("sub_title", "Add Deposit")
				->with("transactionByID", null)
				->with("accounts", $accounts)
				->with("branchs", $branchs)
				->with("atm", $atm)
				->with("user", $user);	
	}));

	/* Bank Deposit Transaction Event END */

	//Route for editing the withdraw
	Route::get("admin_deposit/edit/{id}", array(
		"as" => "admin/deposit_edit", function($id){
		$user = Auth::user();
		$accounts = DB::table('bank_accounts')
							->get();	

		$atm = DB::table('atm')
						->leftJoin('userclients', 'userclients.client_id', '=', 'atm.clients_id')
						->leftJoin('users', 'users.id', '=', 'userclients.user_id')
						->where('users.id', '=', $user->id)
						->select('atm.terminalID', 'atm.id')
						->get();

		$transactionByID = BankTransaction::find($id);

		$branchs = DB::table('banks')
						->leftJoin('bank_accounts', 'banks.id', '=', 'bank_accounts.bank_id')
						->leftJoin('bank_branchs', 'bank_branchs.bank_id', '=', 'banks.id')
						->where('bank_accounts.id', '=', $transactionByID->bankAccount_id)
						->select('bank_branchs.id', 'bank_branchs.bankAddress')
						->get();	

		return View::make("admin/bank_deposit_new")
				->with("title","Transaction")
				->with("sub_title", "Add Deposit")
				->with("transactionByID", $transactionByID)
				->with("accounts", $accounts)
				->with("branchs", $branchs)
				->with("atm", $atm)
				->with("user", $user);	
	}));
	/* Bank Withdraw Transaction Event END */

});

/* 
//Authorized BY Master
*/

Route::group(array("before" => "auth|auth.master"), function(){
	//Route to teacher dashboard
	Route::get("master", array(
		"as" => "master/home", function(){
		$user = Auth::user();

		return View::make("master.home")
			->with("title", "Dashboard")
			->with("user", $user);
	}));	
});

/* 
//Authorized BY Manager
*/

Route::group(array("before" => "auth|auth.manager"), function(){
	
	Route::get("/", array(
		"as" => "manager/home", function(){
		$user = Auth::user();

		return View::make("manager.home")
			->with("title", "Dashboard")
			->with("sub_title", "")
			->with("user", $user);
	}));

	//Route to Manager dashboard
	Route::get("manager", array(
		"as" => "manager/home", function(){
		$user = Auth::user();

		return View::make("manager.home")
			->with("title","Dashboard")
			->with("sub_title", "")
			->with("user", $user);
	}));	

	/* Clients Event START */
	//Route for clients list
	Route::get("manager_clients", array(
		"as" => "manager/clients", function(){
		$user = Auth::user();
		$clients = DB::table('clients')->get();	
		return View::make("admin/clients")
				->with("title", "Clients")
				->with("sub_title", "All Clients")
				->with("clients", $clients)
				->with("user", $user);	
	}));	

	//Route for adding the client
	Route::get("manager_client/new", array(
		"as" => "manager/client_new", function(){
		$user = Auth::user();

		return View::make("admin/client_new")
				->with("title","Clients")
				->with("sub_title", "Add Client")
				->with("clientByID", null)
				->with("user", $user);
	}));	

	//Route for editing the client
	Route::get("manager_client/edit/{id}", array(
		"as" => "manager/client_edit", function($id){
		$user = Auth::user();
		$clientByID = Client::find($id);
		return View::make("admin/client_new")
				->with("title","Clients")
				->with("sub_title", "Edit Client")
				->with("clientByID", $clientByID)
				->with("user", $user);	
	}));
	/* Clients Event END */

	/* ClientContacts Event START */	
	//Route for clientcontacts list
	Route::get("manager_clientcontacts", array(
		"as" => "manager/clientcontacts", function(){
		$user = Auth::user();
		$clientcontacts = DB::table('clientcontacts')->get();	
		
		return View::make("admin/clientcontacts")
				->with("title", "Client Contacts")
				->with("sub_title", "All ClientContacts")
				->with("clientcontacts", $clientcontacts)
				->with("user", $user);	
	}));	

	//Route for adding the clientcontact
	Route::get("manager_clientcontact/new", array(
		"as" => "manager/clientcontact_new", function(){
		$user = Auth::user();
		$clients = DB::table('clients')
							->where('published', 1)
							->get();
		
		return View::make("admin/clientcontact_new")
				->with("title","Client Contacts")
				->with("sub_title", "Add ClientContact")
				->with("clientContactByID", null)
				->with("clients", $clients)
				->with("user", $user);	
	}));	

	//Route for editing the clientcontact
	Route::get("manager_clientcontact/edit/{id}", array(
		"as" => "manager/clientcontact_edit", function($id){
		$user = Auth::user();

		$clientContactByID = ClientContact::find($id);
		$clients = DB::table('clients')
							->where('published', 1)
							->get();

		return View::make("admin/clientcontact_new")
				->with("title", "Client Contacts")
				->with("sub_title", "Edit ClientContact")
				->with("clientContactByID", $clientContactByID)
				->with("clients", $clients)
				->with("user", $user);	
	}));
	/* ClientContacts Event END */	

	/* ATM Event START */	
	//Route for atm list
	Route::get("manager_atm", array(
		"as" => "manager/atm", function(){
		$user = Auth::user();
		$atm = DB::table('atm')->get();	

		return View::make("admin/atm")
				->with("title", "ATM")
				->with("sub_title", "All ATM")
				->with("atm", $atm)
				->with("user", $user);	
	}));	

	//Route for adding the atm
	Route::get("manager_atm/new", array(
		"as" => "manager/atm_new", function(){
		$user = Auth::user();
		$clients = DB::table('clients')
							->where('published', 1)
							->get();		
		return View::make("admin/atm_new")
				->with("title","ATM")
				->with("sub_title", "Add ATM")
				->with("atmByID", null)
				->with("clients", $clients)
				->with("user", $user);	
	}));	

	//Route for editing the atm
	Route::get("manager_atm/edit/{id}", array(
		"as" => "manager/atm_edit", function($id){
		$user = Auth::user();
		$atmByID = ATM::find($id);
		$clients = DB::table('clients')
							->where('published', 1)
							->get();	
		return View::make("admin/atm_new")
				->with("sub_title", "Edit ATM")
				->with("title","Dashboard")
				->with("atmByID", $atmByID)
				->with("clients", $clients)
				->with("user", $user);	
	}));
	/* ATM Event END */	

	/* Contracts Event START */	
	//Route for Contracts list
	Route::get("manager_contracts", array(
		"as" => "manager/contracts", function(){
		$user = Auth::user();
		$contracts = DB::table('contracts')->get();	

		return View::make("admin/contracts")
				->with("title", "Contracts")
				->with("sub_title", "All Contracts")
				->with("contracts", $contracts)
				->with("user", $user);	
	}));	

	//Route for adding the Contract
	Route::get("manager_contract/new", array(
		"as" => "manager/contract_new", function(){
		$user = Auth::user();

		return View::make("admin/contract_new")
				->with("title","Contracts")
				->with("sub_title", "Add Contract")
				->with("contractByID", null)
				->with("user", $user);	
	}));	

	//Route for editing the Contract
	Route::get("manager_contract/edit/{id}", array(
		"as" => "manager/contract_edit", function($id){
		$user = Auth::user();
		
		$contractByID = Contract::find($id);
		return View::make("admin/contract_edit")
				->with("sub_title", "Edit Contract")
				->with("title","Contracts")
				->with("contractByID", $contractByID)
				->with("user", $user);	
	}));	
	/* Contracts Event END */

	/* Bank Withdraw Transaction Event START */	
	// List Route for bank transaction of withdraw
	Route::get("manager_withdraws", array(
		"as" => "manager/withdraws", function(){
		$user = Auth::user();
		$withdraw_transactions = DB::table('bank_transactions')
									->leftJoin('bank_accounts', 'bank_accounts.id', '=', 'bank_transactions.bankAccount_id')
									->where('bank_transactions.type', '=', 'withdraw')
									->where('bank_accounts.user_id', $user->id)
									->get();	

		return View::make("admin/bank_transactions")
				->with("title", "Transaction")
				->with("sub_title", "All Withdraws")
				->with("transactions", $withdraw_transactions)
				->with("transaction", "withdraw")
				->with("user", $user);	
	}));	

	//Route for adding the withdraw
	Route::get("manager_withdraw/new", array(
		"as" => "manager/withdraw_new", function(){
		$user = Auth::user();
		$accounts = DB::table('bank_accounts')
							->where('user_id', $user->id)
							->get();

		$branchs = DB::table('bank_branchs')
							->get();	
		
		$atm = DB::table('atm')
						->leftJoin('userclients', 'userclients.client_id', '=', 'atm.clients_id')
						->leftJoin('users', 'users.id', '=', 'userclients.user_id')
						->where('users.id', '=', $user->id)
						->select('atm.terminalID', 'atm.id')
						->get();

		return View::make("admin/bank_withdraw_new")
				->with("title","Transaction")
				->with("sub_title", "Add Withdraw")
				->with("transactionByID", null)
				->with("accounts", $accounts)
				->with("branchs", $branchs)
				->with("atm", $atm)
				->with("user", $user);	
	}));

	//Route for editing the withdraw
	Route::get("manager_withdraw/edit/{id}", array(
		"as" => "manager/withdraw_edit", function($id){
		$user = Auth::user();
		$accounts = DB::table('bank_accounts')		
							->get();	

		$atm = DB::table('atm')
						->leftJoin('userclients', 'userclients.client_id', '=', 'atm.clients_id')
						->leftJoin('users', 'users.id', '=', 'userclients.user_id')
						->where('users.id', '=', $user->id)
						->select('atm.terminalID', 'atm.id')
						->get();

		$transactionByID = BankTransaction::find($id);

		$branchs = DB::table('banks')
						->leftJoin('bank_accounts', 'banks.id', '=', 'bank_accounts.bank_id')
						->leftJoin('bank_branchs', 'bank_branchs.bank_id', '=', 'banks.id')
						->where('bank_accounts.id', '=', $transactionByID->bankAccount_id)
						->select('bank_branchs.id', 'bank_branchs.bankAddress')
						->get();	

		return View::make("admin/bank_withdraw_new")
				->with("title","Transaction")
				->with("sub_title", "Add Withdraw")
				->with("transactionByID", $transactionByID)
				->with("accounts", $accounts)
				->with("branchs", $branchs)
				->with("atm", $atm)
				->with("user", $user);	
	}));
	/* Bank Withdraw Transaction Event END */

	/* Bank Deposit Transaction Event START */	
	// List Route for bank transaction of deposit
	Route::get("manager_deposits", array(
		"as" => "manager/deposits", function(){
		$user = Auth::user();
		//$deposite_transactions = DB::table('bank_transactions')
		//									->where('type', 'deposit')
		//									->get();	

		$deposite_transactions = DB::table('bank_transactions')
									->leftJoin('bank_accounts', 'bank_accounts.id', '=', 'bank_transactions.bankAccount_id')
									->where('bank_transactions.type', '=', 'deposit')
									->where('bank_accounts.user_id', $user->id)
									->get();	

		return View::make("admin/bank_transactions")
				->with("title", "Transaction")
				->with("sub_title", "All Deposits")
				->with("transactions", $deposite_transactions)
				->with("transaction", "deposit")
				->with("user", $user);	
	}));	

	//Route for adding the deposit
	Route::get("manager_deposit/new", array(
		"as" => "manager/deposit_new", function(){
		$user = Auth::user();
		$accounts = DB::table('bank_accounts')
							->where('user_id', $user->id)
							->get();

		$branchs = DB::table('bank_branchs')
							->get();	

		$atm = DB::table('atm')
						->leftJoin('userclients', 'userclients.client_id', '=', 'atm.clients_id')
						->leftJoin('users', 'users.id', '=', 'userclients.user_id')
						->where('users.id', '=', $user->id)
						->select('atm.terminalID', 'atm.id')
						->get();	
		
		return View::make("admin/bank_deposit_new")
				->with("title","Transaction")
				->with("sub_title", "Add Deposit")
				->with("transactionByID", null)
				->with("accounts", $accounts)
				->with("branchs", $branchs)
				->with("atm", $atm)
				->with("user", $user);	
	}));

	/* Bank Deposit Transaction Event END */

	//Route for editing the withdraw
	Route::get("manager_deposit/edit/{id}", array(
		"as" => "manager/deposit_edit", function($id){
		$user = Auth::user();
		$accounts = DB::table('bank_accounts')
							->get();	

		$atm = DB::table('atm')
						->leftJoin('userclients', 'userclients.client_id', '=', 'atm.clients_id')
						->leftJoin('users', 'users.id', '=', 'userclients.user_id')
						->where('users.id', '=', $user->id)
						->select('atm.terminalID', 'atm.id')
						->get();

		$transactionByID = BankTransaction::find($id);

		$branchs = DB::table('banks')
						->leftJoin('bank_accounts', 'banks.id', '=', 'bank_accounts.bank_id')
						->leftJoin('bank_branchs', 'bank_branchs.bank_id', '=', 'banks.id')
						->where('bank_accounts.id', '=', $transactionByID->bankAccount_id)
						->select('bank_branchs.id', 'bank_branchs.bankAddress')
						->get();	

		return View::make("admin/bank_deposit_new")
				->with("title","Transaction")
				->with("sub_title", "Add Deposit")
				->with("transactionByID", $transactionByID)
				->with("accounts", $accounts)
				->with("branchs", $branchs)
				->with("atm", $atm)
				->with("user", $user);	
	}));
	/* Bank Withdraw Transaction Event END */
});

/* 
//Authorized BY Contractor
*/

Route::group(array("before" => "auth|auth.contractor"), function(){
	
	Route::get("/", array(
		"as" => "contractor/home", function(){
		$user = Auth::user();

		return View::make("contractor.home")
			->with("title", "Dashboard")
			->with("sub_title", "")
			->with("user", $user);
	}));

	Route::get("contractor", array(
		"as" => "contractor/home", function(){
		$user = Auth::user();

		return View::make("contractor.home")
			->with("title", "Dashboard")
			->with("sub_title", "")
			->with("user", $user);
	}));

	/* ClientContacts Event START */	
	//Route for clientcontacts list
	Route::get("contractor_clientcontacts", array(
		"as" => "contractor/clientcontacts", function(){
		$user = Auth::user();
		$clientcontacts = DB::table('clientcontacts')->get();	
		
		return View::make("admin/clientcontacts")
				->with("title", "Client Contacts")
				->with("sub_title", "All ClientContacts")
				->with("clientcontacts", $clientcontacts)
				->with("user", $user);	
	}));	

	//Route for adding the clientcontact
	Route::get("contractor_clientcontact/new", array(
		"as" => "contractor/clientcontact_new", function(){
		$user = Auth::user();
		$clients = DB::table('clients')
							->where('published', 1)
							->get();
		
		return View::make("admin/clientcontact_new")
				->with("title","Client Contacts")
				->with("sub_title", "Add ClientContact")
				->with("clientContactByID", null)
				->with("clients", $clients)
				->with("user", $user);	
	}));	

	//Route for editing the clientcontact
	Route::get("contractor_clientcontact/edit/{id}", array(
		"as" => "contractor/clientcontact_edit", function($id){
		$user = Auth::user();

		$clientContactByID = ClientContact::find($id);
		$clients = DB::table('clients')
							->where('published', 1)
							->get();

		return View::make("admin/clientcontact_new")
				->with("title", "Client Contacts")
				->with("sub_title", "Edit ClientContact")
				->with("clientContactByID", $clientContactByID)
				->with("clients", $clients)
				->with("user", $user);	
	}));
	/* ClientContacts Event END */	

	/* Bank Withdraw Transaction Event START */	
	// List Route for bank transaction of withdraw
	Route::get("contractor_withdraws", array(
		"as" => "contractor/withdraws", function(){
		$user = Auth::user();
		//$withdraw_transactions = DB::table('bank_transactions')
		//							->where('type', 'withdraw')
		//							->get();	

		$withdraw_transactions = DB::table('bank_transactions')
									->leftJoin('bank_accounts', 'bank_accounts.id', '=', 'bank_transactions.bankAccount_id')
									->where('bank_transactions.type', '=', 'withdraw')
									->where('bank_accounts.user_id', $user->id)
									->get();

		return View::make("admin/bank_transactions")
				->with("title", "Transaction")
				->with("sub_title", "All Withdraws")
				->with("transactions", $withdraw_transactions)
				->with("transaction", "withdraw")
				->with("user", $user);	
	}));	

	//Route for adding the withdraw
	Route::get("contractor_withdraw/new", array(
		"as" => "contractor/withdraw_new", function(){
		$user = Auth::user();
		$accounts = DB::table('bank_accounts')
							->where('user_id', $user->id)
							->get();

		$branchs = DB::table('bank_branchs')
							->get();	
		
		$atm = DB::table('atm')
						->leftJoin('userclients', 'userclients.client_id', '=', 'atm.clients_id')
						->leftJoin('users', 'users.id', '=', 'userclients.user_id')
						->where('users.id', '=', $user->id)
						->select('atm.terminalID', 'atm.id')
						->get();

		return View::make("admin/bank_withdraw_new")
				->with("title","Transaction")
				->with("sub_title", "Add Withdraw")
				->with("transactionByID", null)
				->with("accounts", $accounts)
				->with("branchs", $branchs)
				->with("atm", $atm)
				->with("user", $user);	
	}));

	//Route for editing the withdraw
	Route::get("contractor_withdraw/edit/{id}", array(
		"as" => "contractor/withdraw_edit", function($id){
		$user = Auth::user();
		$accounts = DB::table('bank_accounts')		
							->get();	

		$atm = DB::table('atm')
						->leftJoin('userclients', 'userclients.client_id', '=', 'atm.clients_id')
						->leftJoin('users', 'users.id', '=', 'userclients.user_id')
						->where('users.id', '=', $user->id)
						->select('atm.terminalID', 'atm.id')
						->get();

		$transactionByID = BankTransaction::find($id);

		$branchs = DB::table('banks')
						->leftJoin('bank_accounts', 'banks.id', '=', 'bank_accounts.bank_id')
						->leftJoin('bank_branchs', 'bank_branchs.bank_id', '=', 'banks.id')
						->where('bank_accounts.id', '=', $transactionByID->bankAccount_id)
						->select('bank_branchs.id', 'bank_branchs.bankAddress')
						->get();	

		return View::make("admin/bank_withdraw_new")
				->with("title","Transaction")
				->with("sub_title", "Add Withdraw")
				->with("transactionByID", $transactionByID)
				->with("accounts", $accounts)
				->with("branchs", $branchs)
				->with("atm", $atm)
				->with("user", $user);	
	}));
	/* Bank Withdraw Transaction Event END */

	/* Bank Deposit Transaction Event START */	
	// List Route for bank transaction of deposit
	Route::get("contractor_deposits", array(
		"as" => "contractor/deposits", function(){
		$user = Auth::user();
		//$deposite_transactions = DB::table('bank_transactions')
		//									->where('type', 'deposit')
		//									->get();	
		$deposite_transactions = DB::table('bank_transactions')
									->leftJoin('bank_accounts', 'bank_accounts.id', '=', 'bank_transactions.bankAccount_id')
									->where('bank_transactions.type', '=', 'deposit')
									->where('bank_accounts.user_id', $user->id)
									->get();

		return View::make("admin/bank_transactions")
				->with("title", "Transaction")
				->with("sub_title", "All Deposits")
				->with("transactions", $deposite_transactions)
				->with("transaction", "deposit")
				->with("user", $user);	
	}));	

	//Route for adding the deposit
	Route::get("contractor_deposit/new", array(
		"as" => "contractor/deposit_new", function(){
		$user = Auth::user();
		$accounts = DB::table('bank_accounts')
							->where('user_id', $user->id)
							->get();

		$branchs = DB::table('bank_branchs')
							->get();	

		$atm = DB::table('atm')
						->leftJoin('userclients', 'userclients.client_id', '=', 'atm.clients_id')
						->leftJoin('users', 'users.id', '=', 'userclients.user_id')
						->where('users.id', '=', $user->id)
						->select('atm.terminalID', 'atm.id')
						->get();	
		
		return View::make("admin/bank_deposit_new")
				->with("title","Transaction")
				->with("sub_title", "Add Deposit")
				->with("transactionByID", null)
				->with("accounts", $accounts)
				->with("branchs", $branchs)
				->with("atm", $atm)
				->with("user", $user);	
	}));

	/* Bank Deposit Transaction Event END */

	//Route for editing the withdraw
	Route::get("contractor_deposit/edit/{id}", array(
		"as" => "contractor/deposit_edit", function($id){
		$user = Auth::user();
		$accounts = DB::table('bank_accounts')
							->get();	

		$atm = DB::table('atm')
						->leftJoin('userclients', 'userclients.client_id', '=', 'atm.clients_id')
						->leftJoin('users', 'users.id', '=', 'userclients.user_id')
						->where('users.id', '=', $user->id)
						->select('atm.terminalID', 'atm.id')
						->get();

		$transactionByID = BankTransaction::find($id);

		$branchs = DB::table('banks')
						->leftJoin('bank_accounts', 'banks.id', '=', 'bank_accounts.bank_id')
						->leftJoin('bank_branchs', 'bank_branchs.bank_id', '=', 'banks.id')
						->where('bank_accounts.id', '=', $transactionByID->bankAccount_id)
						->select('bank_branchs.id', 'bank_branchs.bankAddress')
						->get();	

		return View::make("admin/bank_deposit_new")
				->with("title","Transaction")
				->with("sub_title", "Add Deposit")
				->with("transactionByID", $transactionByID)
				->with("accounts", $accounts)
				->with("branchs", $branchs)
				->with("atm", $atm)
				->with("user", $user);	
	}));
	/* Bank Withdraw Transaction Event END */		
});

/* 
//Authorized BY Client
*/

Route::group(array("before" => "auth|auth.client"), function(){
	
	Route::get("/", array(
		"as" => "client/home", function(){
		$user = Auth::user();	

		return View::make("client.home")
			->with("title", "Dashboard")
			->with("sub_title", "")
			->with("user", $user);			
	}));

	Route::get("client", array(
		"as" => "client/home", function(){
		$user = Auth::user();	

		return View::make("client.home")
			->with("title", "Dashboard")
			->with("sub_title", "")
			->with("user", $user);			
	}));

	/* Bank Withdraw Transaction Event START */	
	// List Route for bank transaction of withdraw
	Route::get("client_withdraws", array(
		"as" => "client/withdraws", function(){
		$user = Auth::user();
		//$withdraw_transactions = DB::table('bank_transactions')
		//							->where('type', 'withdraw')
		//							->get();	

		$withdraw_transactions = DB::table('bank_transactions')
									->leftJoin('bank_accounts', 'bank_accounts.id', '=', 'bank_transactions.bankAccount_id')
									->where('bank_transactions.type', '=', 'withdraw')
									->where('bank_accounts.user_id', $user->id)
									->get();

		return View::make("admin/bank_transactions")
				->with("title", "Transaction")
				->with("sub_title", "All Withdraws")
				->with("transactions", $withdraw_transactions)
				->with("transaction", "withdraw")
				->with("user", $user);	
	}));	

	//Route for adding the withdraw
	Route::get("client_withdraw/new", array(
		"as" => "client/withdraw_new", function(){
		$user = Auth::user();
		$accounts = DB::table('bank_accounts')
							->where('user_id', $user->id)
							->get();

		$branchs = DB::table('bank_branchs')
							->get();	
		
		$atm = DB::table('atm')
						->leftJoin('userclients', 'userclients.client_id', '=', 'atm.clients_id')
						->leftJoin('users', 'users.id', '=', 'userclients.user_id')
						->where('users.id', '=', $user->id)
						->select('atm.terminalID', 'atm.id')
						->get();

		return View::make("admin/bank_withdraw_new")
				->with("title","Transaction")
				->with("sub_title", "Add Withdraw")
				->with("transactionByID", null)
				->with("accounts", $accounts)
				->with("branchs", $branchs)
				->with("atm", $atm)
				->with("user", $user);	
	}));

	//Route for editing the withdraw
	Route::get("client_withdraw/edit/{id}", array(
		"as" => "client/withdraw_edit", function($id){
		$user = Auth::user();
		$accounts = DB::table('bank_accounts')		
							->get();	

		$atm = DB::table('atm')
						->leftJoin('userclients', 'userclients.client_id', '=', 'atm.clients_id')
						->leftJoin('users', 'users.id', '=', 'userclients.user_id')
						->where('users.id', '=', $user->id)
						->select('atm.terminalID', 'atm.id')
						->get();

		$transactionByID = BankTransaction::find($id);

		$branchs = DB::table('banks')
						->leftJoin('bank_accounts', 'banks.id', '=', 'bank_accounts.bank_id')
						->leftJoin('bank_branchs', 'bank_branchs.bank_id', '=', 'banks.id')
						->where('bank_accounts.id', '=', $transactionByID->bankAccount_id)
						->select('bank_branchs.id', 'bank_branchs.bankAddress')
						->get();	

		return View::make("admin/bank_withdraw_new")
				->with("title","Transaction")
				->with("sub_title", "Add Withdraw")
				->with("transactionByID", $transactionByID)
				->with("accounts", $accounts)
				->with("branchs", $branchs)
				->with("atm", $atm)
				->with("user", $user);	
	}));
	/* Bank Withdraw Transaction Event END */

	/* Bank Deposit Transaction Event START */	
	// List Route for bank transaction of deposit
	Route::get("client_deposits", array(
		"as" => "client/deposits", function(){
		$user = Auth::user();
		//$deposite_transactions = DB::table('bank_transactions')
		//									->where('type', 'deposit')
		//									->get();	
		$deposite_transactions = DB::table('bank_transactions')
									->leftJoin('bank_accounts', 'bank_accounts.id', '=', 'bank_transactions.bankAccount_id')
									->where('bank_transactions.type', '=', 'deposit')
									->where('bank_accounts.user_id', $user->id)
									->get();

		return View::make("admin/bank_transactions")
				->with("title", "Transaction")
				->with("sub_title", "All Deposits")
				->with("transactions", $deposite_transactions)
				->with("transaction", "deposit")
				->with("user", $user);	
	}));	

	//Route for adding the deposit
	Route::get("client_deposit/new", array(
		"as" => "client/deposit_new", function(){
		$user = Auth::user();
		$accounts = DB::table('bank_accounts')
							->where('user_id', $user->id)
							->get();

		$branchs = DB::table('bank_branchs')
							->get();	

		$atm = DB::table('atm')
						->leftJoin('userclients', 'userclients.client_id', '=', 'atm.clients_id')
						->leftJoin('users', 'users.id', '=', 'userclients.user_id')
						->where('users.id', '=', $user->id)
						->select('atm.terminalID', 'atm.id')
						->get();	
		
		return View::make("admin/bank_deposit_new")
				->with("title","Transaction")
				->with("sub_title", "Add Deposit")
				->with("transactionByID", null)
				->with("accounts", $accounts)
				->with("branchs", $branchs)
				->with("atm", $atm)
				->with("user", $user);	
	}));

	/* Bank Deposit Transaction Event END */

	//Route for editing the withdraw
	Route::get("client_deposit/edit/{id}", array(
		"as" => "client/deposit_edit", function($id){
		$user = Auth::user();
		$accounts = DB::table('bank_accounts')
							->get();	

		$atm = DB::table('atm')
						->leftJoin('userclients', 'userclients.client_id', '=', 'atm.clients_id')
						->leftJoin('users', 'users.id', '=', 'userclients.user_id')
						->where('users.id', '=', $user->id)
						->select('atm.terminalID', 'atm.id')
						->get();

		$transactionByID = BankTransaction::find($id);

		$branchs = DB::table('banks')
						->leftJoin('bank_accounts', 'banks.id', '=', 'bank_accounts.bank_id')
						->leftJoin('bank_branchs', 'bank_branchs.bank_id', '=', 'banks.id')
						->where('bank_accounts.id', '=', $transactionByID->bankAccount_id)
						->select('bank_branchs.id', 'bank_branchs.bankAddress')
						->get();	

		return View::make("admin/bank_deposit_new")
				->with("title","Transaction")
				->with("sub_title", "Add Deposit")
				->with("transactionByID", $transactionByID)
				->with("accounts", $accounts)
				->with("branchs", $branchs)
				->with("atm", $atm)
				->with("user", $user);	
	}));
	/* Bank Withdraw Transaction Event END */	
});

/*
//POST Routes
*/

//Route to UserController login method
Route::post("user/login", array(
	"uses" => "UserController@loginAction"
));
//Route to UserController password reset request method
Route::post("user/request", array(
	"uses" => "UserController@requestAction"
));

//Route to UserController password reset method
Route::post("reset", array(
	"uses" => "UserController@resetAction"
));

//Route to UserController password reset method
Route::post("verify", array(
	"uses" => "UserController@verifyAction"
));

//Route to UserController registration method
Route::post ("user/register", array(
	"before" => "csrf", 
	"uses" => "UserController@registerAction"
));

//Route to UserController account method
Route::post ("account/update", array(
	"before" => "csrf",
	"uses" => "UserController@accountInfo"
));

//Route to UserController addUser method
Route::post ("admin/user_add", array(
	"as" => "admin/user_add",
	"before" => "csrf",
	"uses" => "UserController@addUser"
));

//Route to UserController update method
Route::post ("admin/user_update", array(
	"as" => "admin/user_update",
	"uses" => "UserController@updateAction"
));

//Route to UserController delete method
Route::post ("admin/user_delete", array(
	"as" => "admin/user_delete",
	"uses" => "UserController@deleteAction"
));

//Route to UserController delete method
Route::post ("admin/user_assign_client", array(
	"as" => "admin/user_assign_client",
	"uses" => "UserController@clientsAction"
));

//Route to ClientController addClient method
Route::post ("admin/client_add", array(
	"as" => "admin/client_add",
	"before" => "csrf",
	"uses" => "ClientController@addClient"
));
//Route to ClientController addClient method
Route::post ("admin/client_update", array(
	"as" => "admin/client_update",
	"before" => "csrf",
	"uses" => "ClientController@updateAction"
));
//Route to ClientController delete method
Route::post ("admin/client_delete", array(
	"as" => "admin/client_delete",
	"uses" => "ClientController@deleteAction"
));


//Route to ClientContactController addContact method
Route::post ("admin/clientcontact_add", array(
	"as" => "admin/clientcontact_add",
	"before" => "csrf",
	"uses" => "ClientContactController@addContact"
));
//Route to ClientContactController addContact method
Route::post ("admin/clientcontact_update", array(
	"as" => "admin/clientcontact_update",
	"before" => "csrf",
	"uses" => "ClientContactController@updateAction"
));

//Route to ClientContactController delete method
Route::post ("admin/clientcontact_delete", array(
	"as" => "admin/clientcontact_delete",
	"uses" => "ClientContactController@deleteAction"
));

//Route to ATMController addContact method
Route::post ("admin/atm_add", array(
	"as" => "admin/atm_add",
	"before" => "csrf",
	"uses" => "ATMController@addATM"
));
//Route to ATMController addContact method
Route::post ("admin/atm_update", array(
	"as" => "admin/atm_update",
	"before" => "csrf",
	"uses" => "ATMController@updateAction"
));

//Route to ATMController delete method
Route::post ("admin/atm_delete", array(
	"as" => "admin/atm_delete",
	"uses" => "ATMController@deleteAction"
));

//Route to ATMController addRebank method
Route::post ("admin/rebank_add", array(
	"as" => "admin/rebank_add",
	"before" => "csrf",
	"uses" => "ATMController@addRebank"
));

//Route to ATMController addCash method
Route::post ("admin/cash_add", array(
	"as" => "admin/cash_add",
	"before" => "csrf",
	"uses" => "ATMController@addCash"
));

//Route to ATMController addCash method
Route::post ("admin/cash_update", array(
	"as" => "admin/cash_add",
	"before" => "csrf",
	"uses" => "ATMController@addCash"
));

//Route to ContractController addContract method
Route::post ("admin/contract_add", array(
	"as" => "admin/contract_add",
	"before" => "csrf",
	"uses" => "ContractController@addContract"
));
//Route to ClientContactController updateAction method
Route::post ("admin/contract_update", array(
	"as" => "admin/contract_update",
	"before" => "csrf",
	"uses" => "ContractController@updateAction"
));

//Route to ClientContactController delete method
Route::post ("admin/atm_delete", array(
	"as" => "admin/atm_delete",
	"uses" => "ContractController@deleteAction"
));

//Route to BankController addBank method
Route::post ("admin/bank_add", array(
	"as" => "admin/bank_add",
	"before" => "csrf",
	"uses" => "BankController@addBank"
));
//Route to BankController updateBank method
Route::post ("admin/bank_update", array(
	"as" => "admin/bank_update",
	"before" => "csrf",
	"uses" => "BankController@updateBank"
));

//Route to BankController deleteBank method
Route::post ("admin/bank_delete", array(
	"as" => "admin/bank_delete",
	"uses" => "BankController@deleteBank"
));

//Route to BankController addBankAccount method
Route::post ("admin/account_add", array(
	"as" => "admin/account_add",
	"before" => "csrf",
	"uses" => "BankController@addBankAccount"
));
//Route to BankController updateBankAccount method
Route::post ("admin/account_update", array(
	"as" => "admin/account_update",
	"before" => "csrf",
	"uses" => "BankController@updateBankAccount"
));

//Route to BankController deleteBankAccount method
Route::post ("admin/account_delete", array(
	"as" => "admin/account_delete",
	"uses" => "BankController@deleteBankAccount"
));

//Route to BankController addBankBranch method
Route::post ("admin/branch_add", array(
	"as" => "admin/branch_add",
	"before" => "csrf",
	"uses" => "BankController@addBankBranch"
));
//Route to BankController updateBankBranch method
Route::post ("admin/branch_update", array(
	"as" => "admin/branch_update",
	"before" => "csrf",
	"uses" => "BankController@updateBankBranch"
));

//Route to BankController deleteBankBranch method
Route::post ("admin/branch_delete", array(
	"as" => "admin/branch_delete",
	"uses" => "BankController@deleteBankBranch"
));

//Route to BankController addBankBranch method
Route::post ("admin/withdraw_add", array(
	"as" => "admin/withdraw_add",
	"before" => "csrf",
	"uses" => "BankTransactionController@addWithdraw"
));
//Route to BankController updateBankBranch method
Route::post ("admin/withdraw_update", array(
	"as" => "admin/withdraw_update",
	"before" => "csrf",
	"uses" => "BankTransactionController@updateWithdraw"
));

//Route to BankTransactionController addDeposit method
Route::post ("admin/deposit_add", array(
	"as" => "admin/deposit_add",
	"before" => "csrf",
	"uses" => "BankTransactionController@addDeposit"
));
//Route to BankTransactionController updateDeposit method
Route::post ("admin/deposit_update", array(
	"as" => "admin/deposit_update",
	"before" => "csrf",
	"uses" => "BankTransactionController@updateDeposit"
));

//Route to BankTransactionController deleteBankTransaction method
Route::post ("admin/transaction_delete", array(
	"as" => "admin/transaction_delete",
	"uses" => "BankTransactionController@deleteBankTransaction"
));

Route::get("bank/account/{account}/{random}", array(
	"as" => "bank/account", function($account, $random) {
	
	$data = array();
	if(Request::ajax())
	{	
		$branchs = DB::table('banks')
						->leftJoin('bank_accounts', 'banks.id', '=', 'bank_accounts.bank_id')
						->leftJoin('bank_branchs', 'bank_branchs.bank_id', '=', 'banks.id')
						->where('bank_accounts.id', '=', $account)
						->select('bank_branchs.id', 'bank_branchs.bankAddress')
						->get();	

		$i = 0;

		foreach($branchs as $branch) {
			$data[$i]['id'] = $branch->id;
			$data[$i]['address'] = $branch->bankAddress;
			$i ++;
		}
		return json_encode($data);
	}
}));

Route::get("cash/pre_loaded/{atm_id}/{random}", array(
	"as" => "cash/pre_loaded", function($atm_id, $random) {
	
	$data = array();
	if(Request::ajax())
	{	
		$interactioByATM = DB::table('atm_interactions')
						->where('atm_id', '=', $atm_id)
						->orderBy('id', 'DESC')
						->select('id', 'C1loaded', 'C2loaded')						
						->first();		
				
		//foreach($branchs as $branch) {
			$data['id'] = $interactioByATM->id;
			$data['pre_loaded'] = $interactioByATM->C1loaded + $interactioByATM->C2loaded;
		//	$i ++;
		//}
		
		return json_encode($data);
	}
}));

//Route to ATMController deleteInteraction method
Route::post ("admin/interaction_delete", array(
	"as" => "admin/interaction_delete",
	"uses" => "ATMController@deleteInteraction"
));

Route::get("cash/source_terminal/{source}/{random}", array(
	"as" => "cash/source_terminal", function($source, $random) {
	
	$user = Auth::user();
	$data = array();
	if(Request::ajax())
	{	
		if ($source == 'atm') {
			$sources_atm = DB::table('atm')
							->leftJoin('userclients', 'userclients.client_id', '=', 'atm.clients_id')
							->leftJoin('users', 'users.id', '=', 'userclients.user_id')
							->where('users.id', '=', $user->id)
							->select('atm.terminalID', 'atm.id')
							->get();
			$i = 0;

			foreach($sources_atm as $atm) {
				$data[$i]['id'] = $atm->id;
				$data[$i]['value'] = $atm->terminalID;
				$i ++;
			}
		} else if ($source == 'bank') {
			$sources_account = DB::table('bank_accounts')
								->where('user_id', $user->id)
								->select('id', 'accountNumber')
								->get();
			$i = 0;

			foreach($sources_account as $account) {
				$data[$i]['id'] = $account->id;
				$data[$i]['value'] = $account->accountNumber;
				$i ++;
			}
		} else {
				$data[0]['id'] = 1;
				$data[0]['value'] = 'Spare';			
		}
		
		return json_encode($data);
	}
}));

Route::post("/addImageFile/{id}", array(
	"as" => "addImageFile", function($id) {
	
	App::make('ImageUploadController')->construct($id);
}));
/*
Route::get("/addImageFile/{id}", array(
	"as" => "addImageFile", function($id) {
	
	App::make('ImageUploadController')->construct($id);
}));
*/
Route::post( 'asset/delete', array(
	'uses' => 'BankTransactionController@asssetAction'
) );

/*
//Modal views
*/
//Add new addSound modal
Route::get ("modals/addImage/{id}", array(
	"as" => "modals/addImage", function($id){
		return View::make('modals.addImage')
						->with('terminalID', $id);
}));

/*
// Log user out
*/
Route::get('logout', array(
	'as' => 'user/logout', function () {
    Auth::logout();

    return Redirect::route('user/login');
}))->before('auth');
