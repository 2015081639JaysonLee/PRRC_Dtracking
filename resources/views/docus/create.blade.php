@extends('layouts.app')

@section('content')

<div class = "msg">
    @include('inc.message')
</div>
<div class ="container">
  <h4 class="grey-text text-darken-3" >Add a Record</h4>
  <div class="card white">
    <div class="card-content black-text">
      <a href="/docu" class="btn red" style=" float:right; margin:auto;">Cancel</a>
      <br>
        <br>
          <div class="row">
            {!! Form::open(['action' => 'DocuController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    
            {{Form::hidden('user_id', Auth::user()->id)}}

            
            <div class="col s2">
              <div class="input-field">
                {{Form::select('rushed', 
                    ['1' => 'Yes',
                    '0' => 'No'
                    ], 0, ['id' => 'rushed']
                )}}
                
                <label for="rushed">
                  <b>Is it Rush? 
                    <span style="color:red">*</span>
                  </b>
                </label>
              </div>
            </div>
            <div class="col s3">
              <div class="input-field">
                {{Form::select('location', 
                    ['Internal' => 'Internal',
                    'External' => 'External'
                    ], null, ['placeholder' => 'Choose your option', 'id' => 'location']
                )}}
                
                <label for="location">
                  <b>Internal or External? 
                    <span style="color:red">*</span>
                  </b>
                </label>
              </div>
            </div>
            <div class="col s7">
              <div class="input-field">
                {{Form::select('department', $department_list ,null, ['placeholder' => 'Choose your option', 'id' => 'department'])}}
                
                <label for="department">
                  <b>Department 
                    <span style="color:red">*</span>
                  </b>
                </label>
              </div>
            </div>
            <div class="col s4">
              <div class="input-field">
                {{Form::text('iso', '', ['placeholder' => 'ISO Number'])}}
                {{Form::label('iso', 'ISO Number')}}
                </div>
            </div>
            <div class="col s8">
              <div class="input-field">
                {{Form::text('subject', '', ['placeholder' => 'Subject'])}}
                
                <label for="subject">
                  <b>Subject 
                    <span style="color:red">*</span>
                  </b>
                </label>
              </div>
            </div>
            <div class="col s6">
              <div class="input-field">
                {{Form::text('sender', '', ['placeholder' => 'Sender', 'class' => 'autocomplete', 'id' => 'sender', 'autocomplete' => 'off'])}}
                
                <label for="sender">
                  <b>Sender 
                    <span style="color:red">*</span>
                  </b>
                </label>
              </div>
            </div>
            <div class="col s6">
              <div class="input-field">
                {{Form::text('recipient', '', ['placeholder' => 'Recipient', 'class' => 'autocomplete', 'id' => 'recipient', 'autocomplete' => 'off'])}}
                
                <label for="recipient">
                  <b>Recipient 
                    <span style="color:red">*</span>
                  </b>
                </label>
              </div>
            </div>
            <div class="col s6">
              <div class="input-field">
                {{Form::text('sender_add', '', ['placeholder' => 'Sender Address'])}}
            {{Form::label('sender_add', 'Sender Address')}}
                </div>
            </div>
            <div class="col s6">
              <div class="input-field">
                {{Form::text('addressee', '', ['placeholder' => 'Addressee'])}}
            {{Form::label('addressee', 'Addressee(s)')}}
                </div>
            </div>
            <div class="col s6">
              <div class="input-field">
                {{Form::select('statuscode', $status_list, null, ['placeholder' => 'Choose your option', 'id' => 'statuscode'])}}
            
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
              <div class="col s12">
                <div class="input-field">
                {{Form::text('remarks', '', ['placeholder' => 'Remarks'])}}
                
                  <label for="remarks">
                    <b>Remarks 
                      <span style="color:red">*</span>
                    </b>
                  </label>
                </div>
              </div>
              <div class="col s4">
                <div class="input-field">
                {{Form::text('final_action_date', '', ['class' => 'datepicker', 'autocomplete' => 'off'])}}
                
                  <label for="final_action_date">
                    <b>Final Action Date 
                      <span style="color:red">*</span>
                    </b>
                  </label>
                </div>
              </div>
              <div class="col s8 ">
                <div class="input-field right-align">
                {{Form::submit('Create', ['class'=>'btn green'])}}            
                {!! Form::close() !!} 
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
@stop

@push('scripts')

      <script>
    $(document).ready(function(){
        // @TODO sama yung holiday sa di mapipiling dates
        $('#department option:first').attr('disabled', true);
        $('#statuscode option:first').attr('disabled', true);
        // $('.ui-datepicker-month').formSelect();
        // $('.ui-datepicker-year').formSelect();
        $('.datepicker').datepicker({
            dateFormat: "yy-mm-dd",
            autoclose: true,
            showOtherMonths: true,
            selectOtherMonths: true,
            minDate : 0,
            beforeShowDay : $.datepicker.noWeekends
            // changeMonth: true,
            // changeYear: true
        });
        $('.datepicker').datepicker("option", "showAnim", "slideDown");
        $('select').formSelect();
        $('input.autocomplete').autocomplete({
            data: {
                @foreach($user_not_including_the_current_user as $user)
                    '{{$user}}' : '{{asset('images/unknown.jpg')}}',
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