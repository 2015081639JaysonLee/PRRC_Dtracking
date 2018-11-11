@extends('layouts.app')

@section('content')

<?php
$username = Auth::user()->username;
?>
<div class = "msg">
    @include('inc.message')
</div>
<div class ="container">
	<div class="card white">
		<div class="card-content black-text">
			<a href="/docu" class="btn red" style=" float:right; margin:auto;">Cancel</a>
			<br><br>
			<div class="row">
            {!! Form::open(['action' => 'DocuController@store', 'method' => 'POST']) !!}
    
            {{Form::hidden('user_id', Auth::user()->id)}}
            <div class="col s6">
                <div class="input-field">
                {{Form::select('department', 
                    ['1' => 'Administrative Division',
                    '2' => 'Deputy Executive Director For Finance and Administrative Services',
                    '3' => 'Board of Commissioners',
                    '4' => 'Design Division',
                    '5' => 'Easement Recovery, Housing and Resettlement Division',
                    '6' => 'Environment Management Division',
                    '7' => 'Executive Secretary',
                    '8' => 'Finance Division',
                    '9' => 'Management Information Systems Division',
                    '10' => 'Deputy Executive Director for Operations',
                    '11' => 'Planning Division',
                    '12' => 'Project Manager Office',
                    '13' => 'Public Information, Advocacy and Tourism Division',
                    '14' => 'Riverbanks Development and Flood Control Division'
                    ],null, ['placeholder' => 'Choose your option', 'id' => 'department'])}}
                {{Form::label('department', 'Department')}}
                </div>
            </div>
            
            <div class="col s6">
                <div class="input-field">
                {{Form::text('subject', '', ['placeholder' => 'Subject'])}}
                {{Form::label('subject', 'Subject')}}
                </div>
            </div>

            <div class="col s6">
                <div class="input-field">
                {{Form::text('sender', '', ['placeholder' => 'Sender'])}}
                {{Form::label('sender', 'Sender')}}
                </div>
            </div>

            <div class="col s6">
                <div class="input-field">
                {{Form::text('recipient', '', ['placeholder' => 'For/To add department'])}}
                {{Form::label('recipient', 'For/To')}}
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
                {{Form::text('final_action_date', '', ['class' => 'datepicker', 'autocomplete' => 'off'])}}
            {{Form::label('final_action_date', 'Final Action Date')}}
                </div>
            </div>
            
            <div class="col s6">
                <div class="input-field">
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
        $('#department option:first').attr('disabled', true);
        // $('.ui-datepicker-month').formSelect();
        // $('.ui-datepicker-year').formSelect();
        $('.datepicker').datepicker({
            dateFormat: "yy-mm-dd",
            autoclose: true,
            showOtherMonths: true,
            selectOtherMonths: true,
            // changeMonth: true,
            // changeYear: true
        });
        $('.datepicker').datepicker("option", "showAnim", "slideDown");
        $('select#department').formSelect();
        
    });
</script>
@endpush