@extends('layouts.app')

@section('header')
<button class="btn btn-light" onclick="location.href='/docu'"><i class="fa fa-arrow-left"></i> Back </button>

@endsection

@section('header2')
<div>
<nav class="navbar " id="navs2" >
    <!-- Button trigger modal -->
        <ul class="nav ">
                <li>
                    <button type="button" class="btn btn-outline-secondary mr-sm-3" data-toggle="modal" data-target="#exampleModal">
                    <i class="fa fa-send"></i>&nbsp;Send To
                    </button>
                    
                 </li>   

                 <li>
                    <form method="POST" action="DocuController@audit">
                        <button type="button" class="butt1" type="submit" > <i class="fa fa-history"></i>&nbsp;History</button>

                    </form>
                
                </li>
        </ul>
   
        <ul class="nav justify-content-end">

                <li>
                        <a href="{{ url('dynamic_pdf/pdf/' . $docu->docu_id)}}" class="btn btn-secondary">Convert into PDF</a>
        
                </li>

                <li>
                        <a href="/docu/{{$docu->docu_id}}/edit" class="btn btn-link mr-sm-3" > <i class="fa fa-edit"></i>&nbsp;Edit</a>
            
                </li>  

                <li>
                    {!!Form::open(['action' => ['DocuController@destroy', $docu->docu_id], 'method' => 'POST'])!!}
        
                    {{Form::hidden('_method', 'DELETE')}}
                    {{Form::submit('Delete', ['class' => 'butt'])}}
                    {!!Form::close()!!}
                
                </li>

               
        
               
        
         </ul>

   
    
</nav>
</div>


                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Forward Document To: </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>

                        <div class="modal-body">

                            
                               
                                <button type="submit" class="btn btn-primary">Send</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                               
                        </div>

                       
                    </div>
                    </div>
                </div>


@endsection

@section('content')



        
<div >
    <div class= "header2">
        <h3>Document Information</h3>
        <hr>
        <table class = "t1">
        
            <tr>
                <th>Document Code</th>
                <td>{{$docu->docu_id}}</td>
            </tr>
        
            <tr>
                <th>For/To</th>
                <td>{{$docu->recipient}}</td>
            </tr>
            
            <tr>
                <th>Actual Date Received</th>
                <td>to be coded soon...</td>
            </tr>
            
            <tr>
                <th>Sender</th>
                <td>{{$docu->sender}}</td>
            </tr>
            
            <tr>
                <th>Sender Address</th>
                <td>{{$docu->sender_add}}</td>
            </tr>
            
            <tr>
                <th>Subject</th>
                <td>{{$docu->subject}}</td>
            </tr>
            
            <tr>
                <th>Addressee(s)</th>
                <td>{{$docu->iaddressee}}</td>
            </tr>
            
            <tr>
                <th>CC Addressee(s)</th>
                <td>{{$docu->cc_addressee}}</td>
            </tr>
            
            <tr>
                <th>Final Action Status</th>
                <td>{{$docu->final_action_stat}}</td>
            </tr>
            
            <tr>
                <th>Final Action</th>
                <td>{{$docu->final_action_remarks}}</td>
            </tr>
            
            <tr>
                <th>Final Action Date</th>
                <td>{{$docu->final_action_date}}</td>
            </tr>
            
            <tr>
                <th>Final Action By</th>
                <td>to be coded soon....</td>
            </tr>
        
        </table>
        
    </div>
    
    <div class = "header3">
        <h3>Routing Information</h3>
        <hr>
        <table class = "t2">
            <tr>
                <td><br></td>
            </tr>
            <tr>
                <th>Date/Time Stamp</th>
                <td>{{$docu->created_at}}</td>
            </tr>
        
            <tr>
                <th>Routing Status</th>
                <td></td>
            </tr>
            
            <tr>
                <th>Receiving Office</th>
                <td>to be coded soon...</td>
            </tr>
            
            <tr>
                <th>Date/Time Received</th>
                <td></td>
            </tr>
            
            <tr>
                <th>Date/Time Released</th>
                <td></td>
            </tr>
            
            <tr>
                <th>Accept Remarks</th>
                <td></td>
            </tr>
            
        </table>
        
        <br><br>
        <table class = "t3">
            <tr>
                <td><br></td>
            </tr>
            
            <tr>
                <th>Date/Time</th>
                <th>Department</th>
                <th>Remarks</th>		
            </tr>
            
            <tr>
                <td>Routing Status</td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </div>
        
    
        
    
  
    
    
    <!-- TABLE TO SHOW DOCUMENT INFO -->
   
    
   

</div>  

@endsection