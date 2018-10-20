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

    function get_docu_data()
    {
        
     $docu_data = DB::table('docus')
        
        ->get();
     return $docu_data;
    }

 
    function pdf($docu_id) {
        
        dd($docu_id);
    // $pdf = \App::make('dompdf.wrapper');
    //  $pdf->loadHTML($this->convert_docu_data_to_html());
   // $pdf->loadHTML($this->get_data_pdf());
    
     return $pdf->stream();
    }

    function convert_docu_data_to_html()
    {
     $docu_data = $this->get_docu_data(4);

     foreach($docu_data as $docu)
     {
     $output = '
     <h2 align="center">Document and Routing Information</h2>
   
     <h3>Document Information</h3>
     <table style="font-family: Barlow; text-align: left; border: 1px solid black; width:100%;  border-collapse: collapse;">
      			
		<tr>
            <th style="border: 1px solid black; padding: 8px;">Document Code</th>
            <td style="border: 1px solid black; padding: 8px;">'.$docu->docu_id.'</td>
        </tr>
    
        <tr>
            <th style="border: 1px solid black; padding: 8px;">For/To</th>
            <td style="border: 1px solid black; padding: 8px;">'.$docu->recipient.'</td>
        </tr>
        
        <tr>
            <th style="border: 1px solid black; padding: 8px;">Actual Date Received</th>
            <td style="border: 1px solid black; padding: 8px;">to be coded soon...</td>
        </tr>
        
        <tr>
            <th style="border: 1px solid black; padding: 8px;">Sender</th>
            <td style="border: 1px solid black; padding: 8px;">'.$docu->sender.'</td>
        </tr>
        
        <tr>
            <th style="border: 1px solid black; padding: 8px;">Sender Address</th>
            <td style="border: 1px solid black; padding: 8px;">'.$docu->sender_add.'</td>
        </tr>
        
        <tr>
            <th style="border: 1px solid black; padding: 8px;">Subject</th>
            <td style="border: 1px solid black; padding: 8px;">'.$docu->subject.'</td>
        </tr>
        
        <tr>
            <th style="border: 1px solid black; padding: 8px;">Addressee(s)</th>
            <td style="border: 1px solid black; padding: 8px;">'.$docu->addressee.'</td>
        </tr>
        
        <tr>
            <th style="border: 1px solid black; padding: 8px;">CC Addressee(s)</th>
            <td style="border: 1px solid black; padding: 8px;">'.$docu->cc_addressee.'</td>
        </tr>
        
        <tr>
            <th style="border: 1px solid black; padding: 8px;">Final Action Status</th>
            <td style="border: 1px solid black; padding: 8px;">'.$docu->final_action_stat.'</td>
        </tr>
        
        <tr>
            <th style="border: 1px solid black; padding: 8px;">Final Action</th>
            <td style="border: 1px solid black; padding: 8px;">'.$docu->final_action_remarks.'</td>
        </tr>
        
        <tr>
            <th style="border: 1px solid black; padding: 8px;">Final Action Date</th>
            <td style="border: 1px solid black; padding: 8px;">'.$docu->final_action_date.'</td>
        </tr>
        
        <tr>
            <th style="border: 1px solid black; padding: 8px;">Final Action By</th>
            <td style="border: 1px solid black; padding: 8px;">to be coded soon....</td>
        </tr>
        
     </table>
    
     
     
     <h3>Routing Information</h3>
     <table style="font-family: Barlow; text-align: left; border: 1px solid black; width:100%;  border-collapse: collapse;">
         <tr>
            <th style="border: 1px solid black; padding: 8px;">Date/Time Stamp</th>
            <td style="border: 1px solid black; padding: 8px;">'.$docu->created_at.'</td>
        </tr>
    
        <tr>
            <th style="border: 1px solid black; padding: 8px;">Routing Status</th>
            <td style="border: 1px solid black; padding: 8px;"></td>
        </tr>
        
        <tr>
            <th style="border: 1px solid black; padding: 8px;">Receiving Office</th>
            <td style="border: 1px solid black; padding: 8px;">to be coded soon...</td>
        </tr>
        
        <tr>
            <th style="border: 1px solid black; padding: 8px;">Date/Time Received</th>
            <td style="border: 1px solid black; padding: 8px;"></td>
        </tr>
        
        <tr>
            <th style="border: 1px solid black; padding: 8px;">Date/Time Released</th>
            <td style="border: 1px solid black; padding: 8px;"></td>
        </tr>
        
        <tr>
            <th style="border: 1px solid black; padding: 8px;">Accept Remarks</th>
            <td style="border: 1px solid black; padding: 8px;"></td>
        </tr>
      </table>

      <table style="font-family: Barlow; text-align: left; margin-top:5%; border: 1px solid black; width:100%;  border-collapse: collapse;">  
        
         <tr>
            <th style="border: 1px solid black; padding: 8px;"></th>Date/Time</th>
            <th style="border: 1px solid black; padding: 8px;">Department</th>
            <th style="border: 1px solid black; padding: 8px;">Remarks</th>		
        </tr>
        
        <tr>
            <td style="border: 1px solid black; padding: 8px;">Routing Status</td>
            <td style="border: 1px solid black; padding: 8px;"></td>
            <td style="border: 1px solid black; padding: 8px;"></td>
        </tr>
     
    </table>
    
    ';}
     return $output;
    }
}
