@extends('layouts.app')

<?php 
$deadline = $docu_to_be_shown->final_action_date;
$deadline = explode('-', $deadline);
$deadline_year = $deadline[0];
$deadline_month = $deadline[1];
$deadline_day = explode(' ', $deadline[2])[0];
?>
<?php 
    if($editInfoValues != null){
        $status = $editInfoValues->statuscode_id;
        $remarks = $editInfoValues->remarks;
        $idForEdit = $editInfoValues->id;    
    }
    else{
        $status = '';
        $remarks = '';
        $idForEdit = '';
    }
    $is_approved = $docu_to_be_shown->is_accepted;    
?>

  @section('show_nav2')
    
<div class="blue nav-content">
  <ul class="tabs tabs-transparent">
    <li class="tab">
      <a href="{{URL::to('/')}}/docu" target = "_self">Back</a>
    </li>
            @if($forsendId == $editInfoValues->edited_by 
            && $docu_to_be_shown->deleted_at == null
            && $is_approved == '0')
            
    <li class="tab">
      <a href="#sendTo" class="modal-trigger" target = "_self">Send To</a>
    </li>
            @endif
            
    <li class="tab">
      <a href="/audit/{{$docu_to_be_shown->id}}" target="_self">History</a>
    </li class="tab">
    <li class="tab">
      <a href="{{ url('dynamic_pdf/pdf/' . $docu_to_be_shown->id)}}" target = "_self">Convert to PDF</a>
    </li>
            @if(Auth::user()->role->name == 'Super Admin'
            && $is_approved == '0')
            
    <li class="tab">
      <a href="/docu/{{$docu_to_be_shown->id}}/edit" target = "_self">Edit</a>
    </li>
            @endif
            @if($docu_to_be_shown->deleted_at == null
            && $is_approved == '0')
            
    <li class="tab">
      <a href="#softDeleteConfirm" class="modal-trigger">Soft Delete</a>
    </li>
            @endif
            @if(Auth::user()->role->name == "Super Admin" 
            && $docu_to_be_shown->deleted_at != null)
    <li class="tab">
      <a href="#forceDeleteConfirm" class="modal-trigger">Force Delete</a>
    </li>
    <li class="tab">
      <a href="#restoreRecord" class="modal-trigger">Restore</a>
    </li>
            @endif
            @if($forsendId == $editInfoValues->edited_by 
            && Auth::user()->role->name == 'Approver'
            && $is_approved == '0')
            
    <li class="tab">
      <a href="#approval" class="modal-trigger" target = "_self">Approve</a>
    </li>
            @endif
  </ul>
</div>

    @endsection

@section('content')

<br>
  <br>
    <br>
    <div id="restoreRecord" class="modal">
        <div class="modal-content">
          <h4>Restoring document with ID : {{$docu_to_be_shown->id}}</h4>
          <p>Are you sure you want to restore this document?</p>
            {!!Form::open(['action' => ['DocuController@restore'], 'method' => 'POST'])!!}
            <input type="hidden" id="hidden_docuId" name = "hidden_docuId" value = "{{$docu_to_be_shown->id}}">
        </div>
        <div class="modal-footer">
          <a href="#!" class="modal-close waves-effect waves-red btn red">Cancel</a>
            {{Form::submit('Restore', ['class' => 'btn green'])}}
            {!!Form::close()!!}
        
        </div>
      </div>
    <div id="approval" class="modal">
        <div class="modal-content">
          <h4>Approve the Document with ID : {{$docu_to_be_shown->id}}</h4>
          <p>Are you sure you want to approve this document?</p>
            {!!Form::open(['action' => ['DocuController@approve'], 'method' => 'POST'])!!}
            <input type="hidden" id="hidden_docuId" name = "hidden_docuId" value = "{{$docu_to_be_shown->id}}">
        </div>
        <div class="modal-footer">
          <a href="#!" class="modal-close waves-effect waves-red btn red">Cancel</a>
            {{Form::submit('Approve', ['class' => 'btn green'])}}
            {!!Form::close()!!}
        
        </div>
      </div>
      <div id="softDeleteConfirm" class="modal">
        <div class="modal-content">
          <h4>Confirming removal of Document ID : {{$docu_to_be_shown->id}}</h4>
          <p>Are you sure you want to soft delete this document?</p>
            {!!Form::open(['action' => ['DocuController@destroy', $docu_to_be_shown->id], 'method' => 'POST'])!!}
            {{Form::hidden('_method', 'DELETE')}}
        
        </div>
        <div class="modal-footer">
          <a href="#!" class="modal-close waves-effect waves-red btn red">Cancel</a>
            {{Form::submit('Delete', ['class' => 'btn green'])}}
            {!!Form::close()!!}
        
        </div>
      </div>
      <div id="forceDeleteConfirm" class="modal">
        <div class="modal-content">
          <h4>Confirming deletion of Document ID : {{$docu_to_be_shown->id}}</h4>
          <p>Are you sure you want to permenantly delete this document?
          <br>
          <h5 class = "red-text">Warning: This cannot be undone!!!</h5>
          </p>
            {!!Form::open(['action' => ['DocuController@destroy', $docu_to_be_shown->id], 'method' => 'POST'])!!}
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
                        {{Form::label('deadline', 'Deadline for Reviewing')}}
                    </div>
            </div>
            <input type="hidden" id="hidden_docuId" name = "hidden_docuId" value = "{{$docu_to_be_shown->id}}">
              <input type="hidden" id="hidden_sender" name = "hidden_sender" value = "{{Auth::user()->username}}">
                <input type="hidden" id="hidden_routeinfoID" name = "hidden_routeinfoID" value = "
                  <?php echo $idForEdit;?>">
                </div>
              </div>
              <div class="modal-footer" style="margin-top : -20px;">
                <a href="#!" class="modal-close waves-effect waves-red btn red">Cancel</a>
            {{Form::submit('Send', ['class' => 'btn green'])}}
            {!!Form::close()!!}
        
              </div>
            </div>
            <div class="row">
    @include('inc.message')
    
              <div class="col m12">
                <div class="col s1"></div>
                <div class="col s10">
                  <div class="card white z-depth-5">
                    <div class="card-content black-text">
                      <span class="card-title">Document Information: {{$docu_to_be_shown->id}}
                      <span style="float:right;">Current Status : {{$editInfoValues->statuscode->status}}</span>
                      </span>
                      <div class="divider"></div>
                      <table>
                        <tr>
                          <th>Current holder</th>
                          <td>{{App\User::whereId($forsendId)->pluck('username')->first()}}</td>
                          <th>ISO-CODE</th>
                          @if($docu_to_be_shown->iso_code)
                            <td>{{$docu_to_be_shown->iso_code}}</td>
                          @else
                            <td>No ISO Code</td>
                          @endif
                        </tr>
                        <tr>
                          <th>Department</th>
                          <td>{{$docu_to_be_shown->department->name}}</td>
                          <th>Location</th>
                          <td>{{$docu_to_be_shown->location}}</td>
                        </tr>
                        <tr>
                          <th>Subject</th>
                          <td>{{$docu_to_be_shown->subject}}</td>
                          <th>Is it rushed?</th>
                          @if($docu_to_be_shown->is_rush == 1)
                            <td>Yes</td>
                          @else
                            <td>No</td>
                          @endif
                        </tr>
                        <tr>
                          <th>Sender</th>
                          <td>{{$docu_to_be_shown->sender}}</td>
                          <th></th>
                          <td></td>
                        </tr>
                        <tr>
                          <th>Sender Address</th>
                            @if($docu_to_be_shown->sender_add)
                                
                          <td>{{$docu_to_be_shown->sender_add}}</td>
                            @else
                                
                          <td>No input</td>
                            @endif
                          <th></th>
                          <td></td>
                        </tr>
                        <tr>
                          <th>Receipient</th>
                          <td>{{$docu_to_be_shown->recipient}}</td>
                          <th></th>
                          <td></td>
                        </tr>
                        <tr>
                          <th>Receipient Address</th>
                            @if($docu_to_be_shown->addressee)
                                
                          <td>{{$docu_to_be_shown->addressee}}</td>
                            @else
                                
                          <td>No input</td>
                            @endif
                          <th></th>
                          <td></td>
                        </tr>
                        <tr>
                          <th>Deadline for Approving</th>
                          <td>{{$docu_to_be_shown->final_action_date}}</td>
                          <th></th>
                          <td></td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="col s1"></div>
              </div>
              <div class="col m12">
                <div class="col s12">
                  <div class="card white z-depth-5">
                    <div class="card-content black-text">
                      <span class="card-title">Routing Information 
                    @if(App\Forsending::where('docu_id', $docu_to_be_shown->id)
                    ->pluck('receipient_id')->first() == Auth::user()->id 
                    && $docu_to_be_shown->deleted_at == null
                    && $is_approved == '0')
                        @if($editInfoValues != null  && $editInfoValues->edited_by == Auth::user()->id)
                            
                        <span style="float:right;">
                          <a href="#editRouteInfo" class = "waves-effect waves-light btn-small modal-trigger green">
                                Edit Info</a>
                        </span>
                        @else
                            
                        <span style="float:right;">
                          <a href="#routeInfo" class = "waves-effect waves-light btn-small modal-trigger green">
                                Add Progress Report</a>
                        </span>
                        @endif
                    @else
                        
                        <span style="float:right;">
                          <a href="#routeInfo" class = "waves-effect waves-light btn-small modal-trigger green" disabled>
                            Cannot Add Report</a>
                        </span>                                        
                    @endif
                    
                      </span>
                      <div class="divider"></div>
                      <table class="bordered" id="routing">
                        <thead>
                          <tr>
                            <th style = "width:5%;">ID</th>
                            <th style = "width:15%;">Date</th>
                            <th style = "width:10%;">Edited by</th>
                            <th style = "width:10%;">Scanned docu</th>
                            <th style = "width:10%;">Status</th>
                            <th style = "width:50%;">Remarks</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php $countInfo = count($all_routeinfo_of_docu);?>
                            @foreach($all_routeinfo_of_docu as $infoValue)
                                
                          <tr>
                            <td>{{$countInfo}}</td>
                            <td>{{$infoValue->updated_at->format('Y-m-d g:i:s A')}}</td>
                            <td id = "user_edit">{{App\User::where('id', $infoValue->edited_by)
                                    ->pluck('username')->first()}}</td>
                            <td>
                              <b>
                                <a href="#viewFiles" class="modal-trigger fileInfo" data-id_of_selected_info = "{{$infoValue->id}}"> 
                                    {{'Upload'.$countInfo}} </a>
                              </td>
                            </b>
                            <td>{{$infoValue->statuscode->status}}</td>
                            <td>{{$infoValue->remarks}}</td>
                          </tr>
                          <?php $countInfo--;?>
                            @endforeach                         
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div id="viewFiles" class="modal">
              <div id="File_to_place" class="modal-content">
                Loading...
              </div>
              <div class="modal-footer">
                <a href="#!" id="fileViewer-close-button" class="modal-close waves-effect waves-red red btn-flat">Go back</a>
              </div>
            </div>
            <div id="routeInfo" class="modal" style = "height: 400px;">
              <div class="modal-content">
                <div class="row">
                  {!!Form::open(['action' => ['DocuController@routeInfo'], 'method' => 'POST', 'enctype' => 'multipart/form-data'])!!}
            
                  <div class="col s12">
                    <div class="input-field">
                      {{Form::text('remarks', '', ['placeholder' => 'Remarks for the document'])}}
                      <label for="remarks">
                        <b>Remarks 
                          <span style="color:red">*</span>
                        </b>
                      </label>
                    </div>
                  </div>
                  <div class="col s6">
                    <div class="input-field">
                      {{Form::select('statuscode', $status_list, '', 
                      ['placeholder' => 'Choose your option', 'id' => 'statuscode'])}}
                
                      <label for="statuscode">
                        <b>Status 
                          <span style="color:red">*</span>
                        </b>
                      </label>
                    </div>
                  </div>
                  <div class="col s6">
                    <div class="input-field" style ="margin-top: 38px;">
                      <input type="file" name="filename[]" multiple>
                      </div>
                    </div>
                    <input type="hidden" id="hidden_docuId" name = "hidden_docuId" value = "{{$docu_to_be_shown->id}}">
                      <input type="hidden" id="editedBy" name = "editedBy" value = "{{Auth::user()->id}}">
                      </div>
                    </div>
                    <div class="modal-footer" style = "margin-top: 95px;">
                      <a href="#!" class="modal-close waves-effect waves-red btn red">Cancel</a>
                        {{Form::submit('Add', ['class' => 'btn green'])}}
                        {!!Form::close()!!}
    
                    </div>
                  </div>
                  <div id="editRouteInfo" class="modal" style = "height: 365px;">
                    <div class="modal-content">
                      <div class="row">
                        {!!Form::open(['action' => ['DocuController@editRouteInfo'], 'method' => 'POST', 'enctype' => 'multipart/form-data'])!!}
            
                        <div class="col s12">
                          <div class="input-field">
                            {{Form::text('remarks', $remarks, ['placeholder' => 'Remarks for the document'])}}
                            {{Form::label('remarks', 'Remarks')}}
                </div>
                        </div>
                        <div class="col s6">
                          <div class="input-field">
                            {{Form::select('statuscode', $status_list, $status, ['id' => 'statuscode'])}}
                
                            <label for="statuscode">
                              <b>Status 
                                <span style="color:red">*</span>
                              </b>
                            </label>
                          </div>
                        </div>
                        <div class="col s6">
                          <div class="input-field" style ="margin-top: 38px;">
                            <input type="file" name="filename[]" multiple>
                            </div>
                          </div>
                          <input type="hidden" id="hidden_docuId" name = "hidden_docuId" value = "{{$docu_to_be_shown->id}}">
                            <input type="hidden" id="hidden_routeinfoID" name = "hidden_routeinfoID" value = "
                              <?php echo $idForEdit;?>">
                            </div>
                          </div>
                          <div class="modal-footer" style = "margin-top: 50px;">
                            <a href="#!" class="modal-close waves-effect waves-red btn red">Cancel</a>
                            {{Form::submit('Update', ['class' => 'btn green'])}}
                            {!!Form::close()!!}
                          </div>
                        </div>
@stop

@push('scripts')

<script>
    $(document).on('click', '#fileViewer-close-button', function(){
      $("#File_to_place").html('Loading');
    });

    $(document).on('click', '.fileInfo', function(){
      var dataID = $(this).data('id_of_selected_info');
      $.ajax({
          type:'POST',
          url:'/jsonFile',
          data: {
            dataID : dataID,
            '_token' : '<?php echo csrf_token() ?>'
          },
          success:function(data){
            $("#File_to_place").html(data.File_Uploads);
          },
          fail:function(err){
            console.log(err);
          }
      });
    });
    $(document).ready(function(){
        $('#statuscode option:first').attr('disabled', true);
        $('select').formSelect();
        @if($editInfoValues != null)
        var urlParams = new URLSearchParams(window.location.search);
        if((urlParams.get('page') == 1 || !urlParams.has('page')) 
        && '{{$editInfoValues->edited_by}}' == '{{$forsendId}}'){
            var i = $('#routing').children('tbody').children('tr')[0];
            if($(i).children('#user_edit').text() == '{{Auth::user()->username}}'){
                $(i).css('background-color', '#388e3c');
            }
        }
        @endif
        $('.datepicker').datepicker({
            dateFormat: "yy-mm-dd",
            autoclose: true,
            showOtherMonths: true,
            selectOtherMonths: true,
            minDate : 0,
            maxDate: new Date({{$deadline_year}}, {{$deadline_month}} - 1, {{$deadline_day}}),
            beforeShowDay : $.datepicker.noWeekends
            // changeMonth: true,
            // changeYear: true
        });
        $('.datepicker').datepicker("option", "showAnim", "slideDown");
        $('.modal').modal();
        $('input.autocomplete').autocomplete({
            data: {
                @foreach($userForSendList as $user)
                    '{{$user->username}}' : '{{asset('images/unknown.jpg')}}',
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