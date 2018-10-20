@extends('layouts.app')

@section('header')
<h1 style="position:fixed;">Document Tracker</h1>
<form role="search" method="GET" action="{{url("/searchcontent")}}">
    
        <input type="text" placeholder="Search" name="title" style="width:20%; float:right; margin-right: 47%;">
        
    </div>
    </form>
@endsection


@section('content')

<div style="margin-top: 120px; position:absolute; width:100%;">
        
        <table class= "maintable">
         <tr>
          <th class = "topleft main_th">CODE</th>
          <th class = "main_th">SUBJECT</th>
          <th class = "main_th">SENDER</th>
          <th class = "main_th">FOR/TO</th>
          <th class = "topright main_th">STATUS</th>
         </tr>

         @if(count($docus) > 0)
            @foreach($docus as $docu)
            <tr>
            <td class= "main_td">{{$docu->id}}</td>
            <td class= "main_td"><a href ="/docu/{{$docu->id}}" >{{$docu->subject}}</a></td>
            <td class= "main_td">{{$docu->sender}}</td>
            <td class= "main_td">{{$docu->recipient}}</td>
            <td class= "main_td">{{$docu->final_action_stat}}</td>
            </tr>
            @endforeach

        
            
         @else 
             <p>No Documents Found</p>
         @endif
                      
        </table>
        
</div>


        <div class="paginations">    
            <nav aria-label="Page navigation example ">
                <ul class="pagination ">
                  <li class="page-item"> {{$docus->links()}}</li>
                </ul>
            </nav>
        </div>


@endsection