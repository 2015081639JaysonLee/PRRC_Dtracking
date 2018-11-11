@extends('layouts.app')

<?php 
    if($editInfoValues != null){
        $status = $editInfoValues->status;
        $remarks = $editInfoValues->remarks;
        $idForEdit = $editInfoValues->edited_by;
    }
    else{
        $status = '';
        $remarks = '';
        $idForEdit = '';
    }
?>

  @section('show_nav2')
    <div class="blue nav-content">
        <ul class="tabs tabs-transparent">
            <li class="tab"><a href="{{URL::to('/')}}/docu" target = "_self">Back</a></li>
            @if($idForEdit == Auth::user()->id)
            <li class="tab"><a href="#sendTo" class="modal-trigger" target = "_self">Send To</a></li>
            @endif
            <li class="tab">
                <a href="/audit/{{$docu->docu_id}}" target="_self">History</a>
            </li class="tab">
            <li class="tab"><a href="{{ url('dynamic_pdf/pdf/' . $docu->docu_id)}}" target = "_self">Convert to PDF</a></li>
            @if(Auth::user()->role->name == 'Super Admin')
            <li class="tab"><a href="/docu/{{$docu->docu_id}}/edit" target = "_self">Edit</a></li>
            @endif
            @if(Auth::user()->role->name == 'Super Admin')
            <li class="tab"><a href="#deleteConfirm" class="modal-trigger">Delete</a> </li>
            @endif
        </ul>
    </div>

    @endsection

@section('content')
<br><br><br>
    <div id="deleteConfirm" class="modal">
        <div class="modal-content">
            <h4>Confirming deletion of Document ID : {{$docu->docu_id}}</h4>
            <p>Are you sure you want to delete this document? <br><br>
            This action cannot be undone!</p>
            {!!Form::open(['action' => ['DocuController@destroy', $docu->docu_id], 'method' => 'POST'])!!}
            {{Form::hidden('_method', 'DELETE')}}
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-red btn red">Cancel</a>
            {{Form::submit('Delete', ['class' => 'btn green'])}}
            {!!Form::close()!!}
        </div>
    </div>

    <div id="sendTo" class="modal">
        <div class="modal-content">
            <div class="row">
                {!!Form::open(['action' => ['DocuController@sendTo'], 'method' => 'POST'])!!}
                <div class="col s6">
                    <div class="input-field">
                        {{Form::text('receiver', '', ['class' => 'autocomplete', 'id' => 'receiver', 'autocomplete' => 'off'])}}
                        {{Form::label('receiver', 'Username')}}
                    </div>
                </div>
                <div class="col s6">
                    <div class="input-field">
                        {{Form::text('deadline', '', ['class' => 'datepicker', 'autocomplete' => 'off'])}}
                        {{Form::label('deadline', 'Deadline')}}
                    </div>
                </div>
                <input type="hidden" id="hidden_docuId" name = "hidden_docuId" value = "{{$docu->docu_id}}">
                <input type="hidden" id="hidden_senderId" name = "hidden_senderId" value = "{{Auth::user()->id}}">
            </div>
        </div>
        <div class="modal-footer" style="margin-top : -20px;">
            <a href="#!" class="modal-close waves-effect waves-red btn red">Cancel</a>
            {{Form::submit('Send', ['class' => 'btn green'])}}
            {!!Form::close()!!}
        </div>
    </div>
    
<div class="row">
    <div class = "msg">
        @include('inc.message')
    </div>
    <div class="col m5">
        <div class="col s1">

        </div>

        <div class="col s10">
            <div class="card">
                <div class="card-content black-text">
                    <span class="card-title">Document Information</span>
                    <div class="divider"></div>
                    <table>
                        <tr>
                            <th>Document Code</th>
                            <td>{{$docu->docu_id}}</td>
                        </tr>

                        <tr>
                            <th>Department</th>
                            <td>{{$docu->department->name}}</td>
                        </tr>

                        <tr>
                            <th>Subject</th>
                            <td>{{$docu->subject}}</td>
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
                            <th>For/To</th>
                            <td>{{$docu->recipient}}</td>
                        </tr>

                        <tr>
                            <th>Actual Date Received</th>
                            <td>@TODO kailangan ko ba talaga to?</td>
                        </tr>

                        <tr>
                            <th>Deadline</th>
                            <td>{{$docu->final_action_date}}</td>
                        </tr>

                    </table>
                </div>
            </div>
        </div>

        <div class="col s1">

        </div>
    </div>

    <div class="col m7">
        <div class="col s12">

            <div class="col s11">
                <div class="card">
                    <div class="card-content black-text">
                        <span class="card-title">Routing Information 
                            @if(count($info) > 0)
                                @if(App\Forsending::where('docu_id', '=', $docu_id)->pluck('receiver_id')->first() == Auth::user()->id)
                                    @if($info[0]->edited_by != Auth::user()->id)
                                        <span style="float:right;">
                                            <a href="#routeInfo" class = "waves-effect waves-light btn-small modal-trigger green">Add Progress Report</a>
                                        </span>
                                    @else   
                                        <span style="float:right;">
                                            <a href="#editRouteInfo" class = "waves-effect waves-light btn-small modal-trigger green">Edit Info</a>                        
                                        </span>
                                    @endif 
                                @else
                                    <span style="float:right;">
                                        <a href="#routeInfo" class = "waves-effect waves-light btn-small modal-trigger green" disabled>Cannot Add Report</a>
                                    </span>                       
                                @endif
                            @else
                            <span style="float:right;">
                                <a href="#routeInfo" class = "waves-effect waves-light btn-small modal-trigger green">Add Progress Report</a>
                            </span>
                            @endif                                
                        </span> 
                        <div class="divider"></div>
                        <table class="bordered" id="routing">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Edited by</th>
                                    <th>Scanned docu</th>
                                    <th>Status</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($info as $infoValue)
                                    <tr>
                                        <td>{{$infoValue->updated_at->format('Y-m-d')}}</td>
                                        <td id = "user_edit">{{App\User::where('id', '=', $infoValue->edited_by)->pluck('username')->first()}}</td>
                                        <td>{{$infoValue->scanned_docu}}</td>
                                        <td>{{$infoValue->status}}</td>
                                        <td>{{$infoValue->remarks}}</td>
                                    </tr>
                                @endforeach                          
                                {{$info->links()}}
                                <!-- @TODO ayusing UI ng pagination na nasa /resources/pagination/default -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col s1">

            </div>
        </div>
    </div>
</div>

<div id="routeInfo" class="modal">
    <div class="modal-content">
        <div class="row">
            {!!Form::open(['action' => ['DocuController@routeInfo'], 'method' => 'POST'])!!}
            <div class="col s12">
                <div class="input-field">
                    {{Form::text('status', '', ['placeholder' => 'Current status of the document', 'class' => 'validate'])}}
                    {{Form::label('status', 'Status')}}
                </div>
            </div>
            <div class="col s12">
                <div class="input-field">
                    {{Form::text('remarks', '', ['placeholder' => 'Remarks for the document'])}}
                    {{Form::label('remarks', 'Remarks')}}
                </div>
            </div>
            <input type="hidden" id="hidden_docuId" name = "hidden_docuId" value = "{{$docu->docu_id}}">
            <input type="hidden" id="editedBy" name = "editedBy" value = "{{Auth::user()->id}}">
        </div>
    </div>
    <div class="modal-footer" >
        <a href="#!" class="modal-close waves-effect waves-red btn red">Cancel</a>
        {{Form::submit('Send', ['class' => 'btn green'])}}
        {!!Form::close()!!}
    </div>
</div>

<div id="editRouteInfo" class="modal">
    <div class="modal-content">
        <div class="row">
            {!!Form::open(['action' => ['DocuController@editRouteInfo'], 'method' => 'POST'])!!}
            <div class="col s12">
                <div class="input-field">
                    {{Form::text('status', $status, ['placeholder' => 'Current status of the document', 'class' => 'validate'])}}
                    {{Form::label('status', 'Status')}}
                </div>
            </div>
            <div class="col s12">
                <div class="input-field">
                    {{Form::text('remarks', $remarks, ['placeholder' => 'Remarks for the document'])}}
                    {{Form::label('remarks', 'Remarks')}}
                </div>
            </div>
            <input type="hidden" id="hidden_routeinfoID" name = "hidden_routeinfoID" value = "<?php echo $idForEdit;?>">
        </div>
    </div>
    <div class="modal-footer" >
        <a href="#!" class="modal-close waves-effect waves-red btn red">Cancel</a>
        {{Form::submit('Send', ['class' => 'btn green'])}}
        {!!Form::close()!!}
    </div>
</div>
@stop

@push('scripts')
<script>
    $(document).ready(function(){
        var urlParams = new URLSearchParams(window.location.search);
        if((urlParams.get('page') == 1 || !urlParams.has('page')) && '{{$idForEdit}}' == '{{Auth::user()->id}}' ){
            var i = $('#routing').children('tbody').children('tr')[0];
            if($(i).children('#user_edit').text() == '{{Auth::user()->username}}'){
                $(i).css('background-color', '#ffd54f');
            }
        }
        $('.datepicker').datepicker({
            dateFormat: "yy-mm-dd",
            autoclose: true,
            showOtherMonths: true,
            selectOtherMonths: true,
            // changeMonth: true,
            // changeYear: true
        });
        $('.datepicker').datepicker("option", "showAnim", "slideDown");
        $('.modal').modal();
        $('input.autocomplete').autocomplete({
            data: {
                @foreach($userForSendList as $user)
                    '{{$user->username}}' : null,
                @endforeach
            },
            limit : 5,
            sortFunction : function(a, b , inputString){
                return a.indexOf(inputString) - b.indexOf(inputString);
            }
        });
    });
</script>
@endpush