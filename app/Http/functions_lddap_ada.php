<?php

use App\Models\PrefixNumberModel;
use App\Models\ViewCheckDVModel;
use App\Models\ViewLDDAPModel;
use App\Models\ViewLibraryPayeesModel;
use Illuminate\Support\Facades\DB;

   function getLDDAPbyFundMonthYear($fund_selected, $month_selected, $year_selected){
      $data = ViewLDDAPModel::where('fund_id', $fund_selected)->whereMonth('lddap_date', $month_selected)->whereYear('lddap_date', $year_selected)
            ->where('is_active', 1)->where('is_deleted', 0)->orderBy('lddap_no', 'ASC')->get();
      // dd($data);
      return $data; 
   }

   function getLDDAPPrefix($fund_id){
      $data= PrefixNumberModel::where('fund_id', $fund_id)->where('is_active', 1)->where('is_deleted', 0)->get();
      // dd($data);
      return $data;
   }

   function getCheckDVByAccountbyDate($bank_account_id, $check_date){
      $data=ViewCheckDVModel::where('check_date', $check_date)->where('bank_account_id', $bank_account_id)
         ->where('is_active', 1)->where('is_deleted', 0)->get();	
      // dd($data);
      return $data; 
   }

   function getPayeeBankAccountNumbers($payee_id){
      $data=ViewLibraryPayeesModel::where('parent_id', $payee_id)->where('is_active', 1)->where('is_deleted', 0)->get();	
      // dd($data);
      return $data; 
   }

