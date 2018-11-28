@extends('layouts.app')

@section('content')



<div class="container">
  <div class="msg">
        @include('inc.message')
    </div>
  <div class="card white" style="z-index: 1">
    <div class="card-content black-text" >
      <a href="/docu/{{$docu_to_edit->id}}" class="btn red" style=" float:right;">Cancel</a>
      <br>
        <br>
          <div class="row">
            {!! Form::open(['action' => ['DocuController@update', $docu_to_edit->id], 'method' => 'POST']) !!}
                
            
            <div class="col s2">
              <div class="input-field">
                    {{Form::select('rushed', 
                        ['1' => 'Yes',
                        '0' => 'No'
                        ], $docu_to_edit->is_rushed, ['id' => 'rushed']
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
                        ], $docu_to_edit->location, ['id' => 'location']
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
                    {{Form::select('department', $department_list , '$docu_to_edit->department_id', [
                    'id' => 'department'
                    ])}}
                    
                
                <label for="department">
                  <b>Department 
                    <span style="color:red">*</span>
                  </b>
                </label>
              </div>
            </div>
            <div class="col s4">
              <div class="input-field">
                    {{Form::text('iso', $docu_to_edit->iso_code, [
                    'placeholder' => 'ISO Number'
                    ])}}
                    {{Form::label('iso', 'ISO Number')}}
                    </div>
            </div>
            <div class="col s8">
              <div class="input-field">
                    {{Form::text('subject', $docu_to_edit->subject, [
                    'placeholder' => 'Subject'
                    ])}}
                    
                
                <label for="subject">
                  <b>Subject 
                    <span style="color:red">*</span>
                  </b>
                </label>
              </div>
            </div>
            <div class="col s6">
              <div class="input-field">
                    {{Form::text('sender', $docu_to_edit->sender, [
                    'placeholder' => 'Sender', 
                    'class' => 'autocomplete', 
                    'id' => 'sender', 
                    'autocomplete' => 'off', 
                    'disabled'
                    ])}}
                    
                
                <label for="sender">
                  <b>Sender 
                    <span style="color:red">*</span>
                  </b>
                </label>
              </div>
            </div>
            <div class="col s6">
              <div class="input-field">
                    {{Form::text('recipient', $docu_to_edit->recipient, [
                    'placeholder' => 'Recipient', 
                    'class' => 'autocomplete', 
                    'id' => 'recipient', 
                    'autocomplete' => 'off', 
                    'disabled'])}}
                    
                
                <label for="recipient">
                  <b>Recipient 
                    <span style="color:red">*</span>
                  </b>
                </label>
              </div>
            </div>
            <div class="col s6">
              <div class="input-field">
                    {{Form::text('sender_add', $docu_to_edit->sender_add, [
                    'placeholder' => 'Sender Address',
                    'disabled'
                    ])}}
                {{Form::label('sender_add', 'Sender Address')}}
                    </div>
            </div>
            <div class="col s6">
              <div class="input-field">
                    {{Form::text('addressee', $docu_to_edit->addressee, [
                    'placeholder' => 'Addressee',
                    'disabled'
                    ])}}
                {{Form::label('addressee', 'Addressee(s)')}}
                    </div>
            </div>
            <div class="col s6">
              <div class="input-field">
                    {{Form::text('final_action_date', $docu_to_edit->final_action_date, [
                    'class' => 'datepicker'
                    ])}}
                
                <label for="final_action_date">
                  <b>Final Action Date
                    <span style="color:red">*</span>
                  </b>
                </label>
              </div>
            </div>
            <div class="col s6">
              <div class="input-field">
                        {{Form::hidden('_method','PUT')}}
                        {{Form::submit('Update', ['class'=>'btn btn-primary'])}}

                        {!! Form::close() !!}
                    </div>
            </div>
          </div>
          <!--End of div.row -->
        </div>
      </div>
    </div>
@stop

@push('scripts')

    
    <script>
    $('select').formSelect();
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
</script>
@endpush