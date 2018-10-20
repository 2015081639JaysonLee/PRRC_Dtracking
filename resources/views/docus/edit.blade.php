@extends('layouts.app')

@section('header')
    <h2>Edit Document</h2>
@endsection


@section('content')


<div class = "msg">
        @include('inc.message')
</div>  

<div class ="createcontainer">
    <a href="/docu/{{$docu->docu_id}}" class="btn btn-danger" style=" float:right;">Cancel</a>
    <br>
    {!! Form::open(['action' => ['DocuController@update', $docu->docu_id], 'method' => 'POST']) !!}
    
        
            {{Form::label('subject', 'Subject')}}
            {{Form::text('subject', $docu->subject, ['placeholder' => 'Subject'])}}
        
            {{Form::label('recipient', 'For/To')}}
            {{Form::text('recipient', $docu->recipient, ['placeholder' => 'For/To'])}}

            {{Form::label('sender', 'Sender')}}
            {{Form::text('sender', $docu->sender, ['placeholder' => 'Sender'])}}
        
            {{Form::label('sender_add', 'Sender Address')}}
            {{Form::text('sender_add', $docu->sender_add, ['placeholder' => 'Sender Address'])}}
        
            {{Form::label('addressee', 'Addressee(s)')}}
            {{Form::text('addressee', $docu->addressee, ['placeholder' => 'Addressee'])}}
        
            {{Form::label('cc_addressee', 'CC Addressee')}}
            {{Form::text('cc_addressee', $docu->cc_addressee, ['placeholder' => 'CC Addressee'])}}
        
            {{Form::label('final_action_stat', 'Final Action Status')}}
            {{Form::text('final_action_stat', $docu->final_action_stat, ['placeholder' => 'Final Action Status'])}}
        
            {{Form::label('final_action_remarks', 'Final Action Remarks')}}
            {{Form::text('final_action_remarks', $docu->final_action_remarks, ['placeholder' => 'Final Action Remarks'])}}

            {{Form::label('final_action_date', 'Final Action Date')}}
            {{Form::date('final_action_date', $docu->final_action_date)}}

            <br> <br>
        
            {{Form::label('final_action_by', 'Final Action By')}}
            {{Form::text('final_action_by', $docu->final_action_by, ['placeholder' => 'Final Action By'])}}

            {{Form::hidden('_method','PUT')}}
            {{Form::submit('Update', ['class'=>'btn btn-primary'])}}
            
    {!! Form::close() !!}   
</div>
@endsection