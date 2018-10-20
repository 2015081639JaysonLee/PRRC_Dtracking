@extends('layouts.app')

@section('header')
    <h2>Create New Document</h2>
@endsection


@section('content')

<?php

$username = Auth::user()->username;

?>

<div class = "msg">
        @include('inc.message')
</div>  

<div class ="createcontainer">
    <a href="/docu" class="btn btn-danger" style=" float:right; margin:auto;">Cancel</a>
    <br>
    {!! Form::open(['action' => 'DocuController@store', 'method' => 'POST']) !!}
    
        
            {{Form::hidden('username', $username)}}

            {{Form::label('subject', 'Subject')}}
            {{Form::text('subject', '', ['placeholder' => 'Subject'])}}
        
            {{Form::label('recipient', 'For/To')}}
            {{Form::text('recipient', '', ['placeholder' => 'For/To add department'])}}

            {{Form::label('sender', 'Sender')}}
            {{Form::text('sender', '', ['placeholder' => 'Sender'])}}
        
            {{Form::label('sender_add', 'Sender Address')}}
            {{Form::text('sender_add', '', ['placeholder' => 'Sender Address'])}}
        
            {{Form::label('addressee', 'Addressee(s)')}}
            {{Form::text('addressee', '', ['placeholder' => 'Addressee'])}}
        
            {{Form::label('cc_addressee', 'CC Addressee')}}
            {{Form::text('cc_addressee', '', ['placeholder' => 'CC Addressee'])}}
        
            {{Form::label('final_action_stat', 'Final Action Status')}}
            {{Form::text('final_action_stat', '', ['placeholder' => 'Final Action Status'])}}
        
            {{Form::label('final_action_remarks', 'Final Action Remarks')}}
            {{Form::text('final_action_remarks', '', ['placeholder' => 'Final Action Remarks'])}}

            {{Form::label('final_action_date', 'Final Action Date')}}
            {{Form::date('final_action_date', \Carbon\Carbon::now())}}

            <br> <br>
        
            {{Form::label('final_action_by', 'Final Action By')}}
            {{Form::text('final_action_by', '', ['placeholder' => 'Final Action By'])}}
        
            {{Form::submit('Create', ['class'=>'btn btn-primary'])}}

            
            
    {!! Form::close() !!}   
</div>
@endsection