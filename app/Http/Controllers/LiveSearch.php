<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Docu;
use Auth;

class LiveSearch extends Controller
{
    function index()
    {
     return view('live_search');
    }

    function action(Request $request)
    {
     if($request->ajax())
     {
      $output = '';
      $query = $request->get('query');
      if($query != '')
      {
       $data = DB::table('docus')
       ->where('username', '=', Auth::user()->username)
        ->where('subject', 'like', '%' .$query. '%')
        ->orWhere('recipient', 'like', '%'.$query.'%')
        ->orWhere('sender', 'like', '%'.$query.'%')
        ->orWhere('final_action_stat', 'like', '%'.$query.'%')
        ->orderBy('docu_id', 'desc')
         ->get();
         
      }
      else
      {
       $data = DB::table('docus')
       
       ->where('username', '=', Auth::user()->username)
         ->orderBy('docu_id', 'desc')
         ->get();
      }
      $total_row = $data->count();
      if($total_row > 0)
      {
       foreach($data as $row)
       {
        $output .= '
        <tr>
         <td>'.$row->docu_id.'</td>
         <td><a href ="/docu/'.$row->docu_id.'"> '.$row->subject.'</a></td>
         <td>'.$row->sender.'</td>
         <td>'.$row->recipient.'</td>
         <td>'.$row->final_action_stat.'</td>
        </tr>
        ';
       }
      }
      else
      {
       $output = '
       <tr>
        <td align="center" colspan="5">No Data Found</td>
       </tr>
       ';
      }
      $data = array(
       'table_data'  => $output,
       'total_data'  => $total_row
      );

      echo json_encode($data);
     }
    }
}

