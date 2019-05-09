<?php

namespace App\Http\Controllers\Web;

use App\Models\BlackListedNumber;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlackListController extends Controller
{
    public function showBlackList()
    {
    	$allBlackListNumbers = BlackListedNumber::paginate(8);

    	return view('admin.other_layouts.blacklisted_numbers.all_blacklisted_number', compact('allBlackListNumbers'));
    }

    public function deleteBlackListedNumber($blackListId)
    {
    	$numberToDelete = BlackListedNumber::find($blackListId);
    	$numberToDelete->delete();

    	return redirect()->back()->with('success', 'Number is Deleted');
    }
}
