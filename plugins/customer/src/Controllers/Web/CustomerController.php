<?php

namespace Plugins\Customer\Controllers\Web;
use Illuminate\Http\Request;
use Core\Base\Controllers\Web\BasePublicController;

class CustomerController extends BasePublicController
{
	/**
	 * Show my account customer
	 * @param Request $request 
	 * @author  TrinhLe 
	 * @return Illuminate\View\View
	 */
	public function myAccount(Request $request)
	{
		return view("plugins-customer::account.myaccount");
	}
}