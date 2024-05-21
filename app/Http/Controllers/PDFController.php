<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App;
use App\Models\DivisionsModel;

class PDFController extends Controller
{
   public function agency_proposal(Request $request)
   {   
      $year = $request->year;
      return view('budget_proposal.agency_proposal_table')->with('year_selected', $year);
   }
   public function index() {
         return view('budget_proposal.cash_programs.division');
   }
  

}
