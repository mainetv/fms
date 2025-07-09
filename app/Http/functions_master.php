<?php

use App\Models\DivisionsModel;
use App\Models\FiscalYearsModel;
use App\Models\FundsModel;
use App\Models\HeadersModel;
use App\Models\LibraryActivityModel;
use App\Models\LibraryBanksModel;
use App\Models\LibraryExpenseAccountModel;
use App\Models\LibraryObjectExpenditureModel;
use App\Models\LibraryPAPModel;
use App\Models\LibraryPayeeTypeModel;
use App\Models\LibraryRsTypesModel;
use App\Models\LibrarySubactivityModel;
use App\Models\PaymentModesModel;
use App\Models\PayTypesModel;
use App\Models\TaxTypesModel;
use App\Models\UserRolesModel;
use App\Models\ViewAllotmentStatusModel;
use App\Models\ViewBpStatusModel;
use App\Models\ViewHRMSUsersModel;
use App\Models\ViewLibraryBankAccountsModel;
use App\Models\ViewLibraryDvTransactionTypesModel;
use App\Models\ViewLibraryPayeesModel;
use App\Models\ViewLibrarySignatoriesModel;
use App\Models\ViewNotificationsModel;
use App\Models\ViewRSTypesModel;
use App\Models\ViewUsersHasRolesModel;
use App\Models\ViewUsersModel;
use Illuminate\Support\Carbon;

function convert_number_to_words($number){ 
    if (($number < 0) || ($number > 999999999)) 
    { 
    throw new Exception("Number is out of range");
    } 

    $Gn = floor($number / 1000000);  /* Millions (giga) */ 
    $number -= $Gn * 1000000; 
    $kn = floor($number / 1000);     /* Thousands (kilo) */ 
    $number -= $kn * 1000; 
    $Hn = floor($number / 100);      /* Hundreds (hecto) */ 
    $number -= $Hn * 100; 
    $Dn = floor($number / 10);       /* Tens (deca) */ 
    $n = $number % 10;               /* Ones */ 

    $res = ""; 

    if ($Gn) 
    { 
        $res .= convert_number_to_words($Gn) . " Million"; 
    } 

    if ($kn) 
    { 
        $res .= (empty($res) ? "" : " ") . 
        convert_number_to_words($kn) . " Thousand"; 
    } 

    if ($Hn) 
    { 
        $res .= (empty($res) ? "" : " ") . 
        convert_number_to_words($Hn) . " Hundred"; 
    } 

    $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", 
        "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", 
        "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eighteen", 
        "Nineteen"); 
    $tens = array("", "", "Twenty", "Thirty", "Forty", "Fifty", "Sixty", 
        "Seventy", "Eighty", "Ninety"); 

    if ($Dn || $n) 
    { 
        if (!empty($res)) 
        { 
            //$res .= " and "; 
			$res .= " "; 
        } 

        if ($Dn < 2) 
        { 
            $res .= $ones[$Dn * 10 + $n]; 
        } 
        else 
        { 
            $res .= $tens[$Dn]; 

            if ($n) 
            { 
                $res .= "-" . $ones[$n]; 
            } 
        }
    } 

    if (empty($res)) 
    { 
        $res = "zero"; 
    } 

    return $res; 
}

function parseNull($key, $row)
{
   if (!isset($row[$key])) {
      return null; // If the key does not exist, return null
   }

   $value = $row[$key];
   return ($value === 'NULL' || $value === '') ? null : $value;
}

function formatDate($date)
{
   if (!$date) {
      return null; // If date is null or empty, return null
   }

   try {
      // Attempt to parse the date in the expected format
      return Carbon::createFromFormat('m/d/Y H:i', $date)->format('Y-m-d H:i:s');
   } catch (\Exception $e) {
      // If parsing fails, attempt to parse it with Carbon's flexible parser
      try {
         return Carbon::parse($date)->format('Y-m-d H:i:s');
      } catch (\Exception $e) {
         return null; // Return null if parsing still fails
      }
   }
}

function removeComma($number){
   $res=str_replace(",", "", $number);
   return $res; 
}

function numtomonth($xm) {
   switch ($xm) {
      case '1':
         return "January" ;
         break;
      case '2':
         return "February" ;
         break;
      case '3':
         return "March" ;
         break;
      case '4':
         return "April" ;
         break;
      case '5':
         return "May" ;
         break;
      case '6':
         return "June" ;
         break;
      case '7':
         return "July" ;
         break;
      case '8':
         return "August" ;
         break;
      case '9':
         return "September" ;
         break;
      case '10':
         return "October" ;
         break;
      case '11':
         return "November" ;
         break;
      case '12':
         return "December" ;
         break;
   }
}

function convert_number_format($number){
   $res = preg_replace(
      '/(-)([\d\.\,]+)/ui',  
      '($2)',                          
      number_format($number,2,'.',',')       
   );
   return $res;
}

function getAllActiveStaff() {
   $data = ViewHRMSUsersModel::orderBy('lname', 'ASC')->get();
   return $data;
}

function getUserRoles()
{
   $data = UserRolesModel::orderBy('name', 'ASC')->get();
   return $data;
}

function getNotifications($user_id){   
   $data = ViewNotificationsModel::where('user_id_to',$user_id)->where('is_read', '0')->where('is_deleted', '0')->orderBy('created_at', 'DESC')->get();  
   return $data;
}

function getAllNotifications($user_id){   
   $data = ViewNotificationsModel::where('user_id_to',$user_id)->where('is_deleted', '0')->orderBy('created_at', 'DESC')->get(); 
   return $data;
}

function getUserDetailsHasRoles($user_id){
   $data = ViewUsersHasRolesModel::where('id',$user_id)->where('is_active',1)->where('is_deleted', '0')->get(); 
   // dd($data);
   return $data;
}

function getUserDetails($user_id){
   $data = ViewUsersModel::where('id', $user_id)->get();
   // dd($data);
   return $data;
}

function getFiscalYears(){
   $data = FiscalYearsModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('year', 'DESC')->get(); 
   // dd($data);
   return $data;
}

function getYears(){
   $data = FiscalYearsModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('year', 'DESC')->get(); 
   // dd($data);
   return $data;
}

function getYearsV($year_selected){
   $data = FiscalYearsModel::where('year', $year_selected)->where("is_active", 1)->where("is_deleted", 0)->orderBy('year', 'DESC')->get(); 
   // dd($data);
   return $data;
}

function getYearsH($year_selected){
   $fy1 = DB::table('fiscal_year')->select('year', 'fiscal_year.fiscal_year1 as fiscal_year')
      ->where('year','=',$year_selected)
      ->where('is_active','=',1)
      ->where('is_deleted','=',0);
   $fy2 = DB::table('fiscal_year')->select('year', 'fiscal_year.fiscal_year2 as fiscal_year')
      ->where('year','=',$year_selected)
      ->where('.is_active','=',1)
      ->where('is_deleted','=',0);
   $data = DB::table('fiscal_year')->select('year', 'fiscal_year.fiscal_year3 as fiscal_year')
      ->where('year','=',$year_selected)->where('.is_active','=',1)->where('is_deleted','=',0)
      ->union($fy1)->union($fy2)->orderBy('fiscal_year', 'ASC')->get();
   // dd($data);
   return $data;
}

function getAllActiveDivisions(){
   $data = DivisionsModel::where("is_active", 1)->orderBy('division_acronym', 'ASC')->get(); 
   // dd($data);
   return $data;
}

function getDepartmentHeader(){
   $data = HeadersModel::where('header_for', 'Department')->where("is_active", 1)->where("is_deleted", 0)->pluck('header_title')->first();
   // dd($data);
   return $data;
}

function getAgencyHeader(){
   $data = HeadersModel::where('header_for', 'Agency')->where("is_active", 1)->where("is_deleted", 0)->pluck('header_title')->first();
   // dd($data);
   return $data;
}

function getExecutiveDirector(){
   $data = ViewUsersHasRolesModel::where('role_id', '10')->where("is_active", 1)->where("is_deleted", 0)->pluck('fullname_first')->first();
   // dd($data);
   return $data;
}

function getUserID(){
   $data = auth()->user()->id; 
   return $data;
}

function getUserFullname($user_id){
   $data = ViewUsersHasRolesModel::where('id',$user_id)->pluck('fullname_first')->first();
   // dd($data);
   return $data;
}

function getUserRole($user_id){
   $data = ViewUsersHasRolesModel::where('id', $user_id)->pluck('user_role')->first(); 
   // dd($data);
   return $data;
}

function getUserRoleID($user_id){
   $data = ViewUsersHasRolesModel::where('id', $user_id)->pluck('user_role_id')->first(); 
   // dd($data);
   return $data;
}

function getUserRoleIsDivision($user_id){
   $data = ViewUsersHasRolesModel::where('id', $user_id)->whereIn('role_id',[7,6,11])
      ->pluck('user_role')->first();     
   // dd($data);
   return $data;
}

function getUserDivisionID($user_id){
   $data = ViewUsersHasRolesModel::where('id', $user_id)->pluck('division_id')->first(); 
   // dd($data);
   return $data;
}

function getUserDivisionAcronym($user_id){
   $data = ViewUsersHasRolesModel::where('id', $user_id)->pluck('division_acronym')->first(); 
   return $data;
}

function getUserDivisionClusterID($user_id){
   $data = ViewUsersHasRolesModel::where('id', $user_id)->pluck('cluster_id')->first(); 
   return $data;
}

function getUserParentDivisionID($user_id){
   $data = ViewUsersHasRolesModel::where('id', $user_id)->pluck('parent_division_id')->first(); 
   // dd($data);
   return $data;
}

function getUserDivisionDirector($user_division_id){
   $data = ViewUsersHasRolesModel::where('division_id', $user_division_id)
   ->where('role_id', 6)->pluck('fullname_last')->first(); 
   // dd($data);
   return $data;
}

function getUserDivisionDirectorFAD($user_parent_division_id){
   $data = ViewUsersHasRolesModel::where('parent_division_id', $user_parent_division_id)
      ->where('role_id', 6)->pluck('fullname_last')->first(); 
   // dd($data);
   return $data;
}

function getAllDivisions(){
   $data = DivisionsModel::where("is_deleted", 0)->orderBy('division_acronym', 'asc')->get();
   // dd($data);
   return $data;
}

function getRDDivisions(){
   $data = DivisionsModel::where('cluster_id', 20)->where("is_active", 1)->orderBy('division_acronym', 'asc')->get();
   // dd($data);
   return $data;
}

function getARMMSDivisions(){
   $data = DivisionsModel::where('cluster_id', 21)->where("is_active", 1)->orderBy('division_acronym', 'asc')->get();
   // dd($data);
   return $data;
}

function getAllBankAccounts(){
   $data = ViewLibraryBankAccountsModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('bank_account_no', 'asc')->get();
   // dd($data);
   return $data;
}

function getRSTypes(){
   $data = LibraryRsTypesModel::where("is_active", 1)->where("is_deleted", 0)->get();
   // dd($data);
   return $data;
}

function getRSType($rs_type_id){
   $data = ViewRSTypesModel::where('id', $rs_type_id)->get();
   // dd($data);
   return $data;
}

function getFunds(){
   $data = FundsModel::where("is_active", 1)->where("is_deleted", 0)->get();
   // dd($data);
   return $data;
}

function getPaymentModes(){
   $data = PaymentModesModel::where("is_active", 1)->where("is_deleted", 0)->get();
   // dd($data);
   return $data;
}

function getBanks(){
   $data = LibraryBanksModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('id', 'asc')->get();
   // dd($data);
   return $data;
}

function getPayees(){
   $data = ViewLibraryPayeesModel::where('is_verified', 1)->where('is_active',1)->where("is_deleted", 0)->orderBy('payee', 'asc')->get();
   // dd($data);
   return $data;
}

function getPayeeTypes(){
   $data = LibraryPayeeTypeModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('id', 'asc')->get();
   // dd($data);
   return $data;
}

function getDvTransactionTypes(){
   $data = ViewLibraryDvTransactionTypesModel::where("is_active", 1)->where("is_deleted", 0) ->orderBy('transaction_type')->get();      
   // dd($data);
   return $data;
}

function getDvSignatories(){
   $data = ViewLibrarySignatoriesModel::where('module_id', 6)->where("is_active", 1)->where("is_deleted", 0)->orderBy('fullname_first')->get();
   // dd($data);
   return $data;
}

function getPayTypes(){
   $data = PayTypesModel::where("is_active", 1)->where("is_deleted", 0)->get();      
   // dd($data);
   return $data;
}

function getTaxTypes(){
   $data = TaxTypesModel::where("is_active", 1)->where("is_deleted", 0)->get();      
   // dd($data);
   return $data;
}

function getUserRoleNotDivision($user_id){
   $data = ViewUsersHasRolesModel::where('id', $user_id)
   ->where(function ($query) {
   $query->where('role_id','=',9)
       ->orWhere('role_id','=',10)
       ->orWhere('role_id','=',3)
       ->orWhere('role_id','=', 8);
   })
   ->pluck('user_role')->first();     
   // dd($data);
   return $data;
}

function getBPActiveStatusID($division_id, $year_selected){
   $data = ViewBpStatusModel::where('division_id', $division_id)->where('year', $year_selected)
      ->where('is_active',1)->where('is_deleted',0)->get();
   // dd($data);
   return $data;
}

function getCPActiveStatusID($division_id, $year_selected){
   $data = ViewBpStatusModel::where('division_id', $division_id)->where('year', $year_selected)
      ->where('is_active',1)->where('is_deleted',0)->get();
   // dd($data);
   return $data;
}

function getAllotmentActiveStatus($year_selected){
   $data = ViewAllotmentStatusModel::where('year', $year_selected)
      ->where('is_active',1)->where('is_deleted',0)->get();
   // dd($data);
   return $data;
}

function getLibraryPAP(){
   $data = LibraryPAPModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('pap_code')->get();
   return $data;
}

function getLibraryActivities($user_division_id){
   $data = LibraryActivityModel::where('division_id',$user_division_id)->orWhereNull('division_id')
      ->where("is_active", 1)->where("is_deleted", 0)->orderBy('activity')->get();
   return $data;
}

function getLibrarySubactivities(){
   $data = LibrarySubactivityModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('subactivity')->get();
   return $data;
}

function getLibraryExpenseAccounts(){
   $data = LibraryExpenseAccountModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('expense_account')->get();
   return $data;
}

function getLibraryObjectExpenditures(){
   $data = LibraryObjectExpenditureModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('object_expenditure')->get();
   return $data;
}

function getAdaSignatories(){
      $data = ViewLibrarySignatoriesModel::where('module_id', 8)->where("is_active", 1)->where("is_deleted", 0)->orderBy('fullname_first')->get();
      // dd($data);
      return $data;
   }


   function getDivisionAcronym($division_id){
      $data = DivisionsModel::where('id', $division_id)->pluck('division_acronym')->first(); 
      return $data;
   }
