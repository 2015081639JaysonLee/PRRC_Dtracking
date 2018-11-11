<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Docu;
use DB;
use PDF;

class DynamicPDFController extends Controller
{
    function index()
    {
     $docu_data = $this->get_docu_data();
     return view('dynamic_pdf')->with('docu_data', $docu_data);
    }

    function get_docu_data($docu_id)
    {
        
     $docu_data = DB::table('docus')
        ->where('docu_id', '=', $docu_id)
        ->get();
     return $docu_data;
    }

 
    function pdf($docu_id) {
        
        
     $pdf = \App::make('dompdf.wrapper');
     $pdf->loadHTML($this->convert_docu_data_to_html($docu_id));
     //$pdf->loadHTML($this->get_data_pdf());
    
     return $pdf->stream();
    }

    function convert_docu_data_to_html($docu_id)
    {
     $docu_data = $this->get_docu_data($docu_id);

     foreach($docu_data as $docu)
     {
     $output = '
     <div style="position:absolute;">
	<h3>PASIG RIVER REHABILITATION COMMISION</h3>
	<p>DOCUMENT ROUTING SLIP</p>
</div>
<div style=" position:relative; float: right;  border: 1px solid black; padding: 10px 25px; margin-top: 2%; ">
	<label>
	  <input type="checkbox" checked="checked">
	  <span class="checkmark"></span>
	  RUSH
	</label>
</div>
<br><br><br><br><br>
<table style="border-collapse: collapse;  border: 1px solid black; width:100%; text-align:center;">
  <tr>
    <td colspan="2" style="border: 1px solid black; text-align:left;"><b>From:</b> <br>	&nbsp;	&nbsp;'.$docu->sender.'</td>
    <td colspan="2" style="border: 1px solid black; text-align:left;"><b>Date Received:</b>
	<br> 	&nbsp;	&nbsp;</td>
    <td colspan="2" style="border: 1px solid black; text-align:left;"><b>Reference Number:</b> <br>
	&nbsp;	&nbsp;'.$docu->docu_id.'</td>
  </tr>
  
   <tr>
    <td colspan="6" style="border: 1px solid black; text-align:left;"><b>SUBJECT:</b>
	<br>	&nbsp;	&nbsp; '.$docu->subject.'</td>
   </tr>
   
   <tr>
    <th colspan="6"  style="border: 1px solid black;">ROUTING SLIP</th>
   </tr>
      
   <tr>
    <th style="border: 1px solid black;">FROM</th>
	<th style="border: 1px solid black;">TO</th>
	<th style="border: 1px solid black;">DATE</th>
	<th style="border: 1px solid black;">INSTRUCTIONS/REMARKS</th>
	<th style="border: 1px solid black;">DEADLINE</th>
	<th style="border: 1px solid black;">DATE COMPLIED</th>
   </tr>
   
   <tr>
    <td style="border: 1px solid black;">'.$docu->sender.'</td>
	<td style="border: 1px solid black;">'.$docu->recipient.'</td>
	<td style="border: 1px solid black;">date right now</td>
	<td style="border: 1px solid black;"> Wala pang remarks, nasa kabilang table</td>
	<td style="border: 1px solid black;">'.$docu->final_action_date.'</td>
	<td style="border: 1px solid black;">date complied</td>
	
   </tr>
   </table>
    ';}
     return $output;
    }
}
