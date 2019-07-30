<?php

namespace App\Http\Controllers\Web;

use DataTables;
use Illuminate\Http\Request;
use App\Models\BlackListedNumber;
use App\Http\Controllers\Controller;

class BlackListController extends Controller
{
    public function showBlackList(Request $request)
    {
        if ($request->ajax()) {

            $model = BlackListedNumber::query();

            return  DataTables::eloquent($model)

                    ->addColumn('action', function(){

                        $button = "<i class='fa fa-fw fa-trash text-danger' style='transform: scale(1.5);' title='Delete'></i>";

                        return $button;

                    })

                    ->setRowId(function (BlackListedNumber $number) {
                        return $number->id;
                    })

                    ->setRowClass(function (BlackListedNumber $number) {
                        return $number->id % 2 == 0 ? 'alert-success' : 'alert-warning';
                    })

                    ->setRowAttr([
                        'align' => 'center',
                    ])
                    
                    ->make(true);
        }

        return view('admin.other_layouts.blacklisted_numbers.all_blacklisted_number');    

    	/*
        $allBlackListNumbers = BlackListedNumber::paginate(8);
    	return view('admin.other_layouts.blacklisted_numbers.all_blacklisted_number', compact('allBlackListNumbers'));
        */
    }

    public function deleteBlackListedNumber($blackListId)
    {
    	$numberToDelete = BlackListedNumber::find($blackListId);
    	$numberToDelete->delete();

    	return redirect()->back()->with('success', 'Number is Deleted');
    }
}
