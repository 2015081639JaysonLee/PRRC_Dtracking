@extends('layouts.app')

@section('content')

<div class="container">
    <div class="msg">
        @include('inc.message')
    </div>
    <div class="card white" style="z-index: 1">
        <div class="card-content black-text" >
            <a href="/docu/{{$docu->docu_id}}" class="btn red" style=" float:right;">Cancel</a>
            <br><br>

            <div class="row">
            {!! Form::open(['action' => ['DocuController@update', $docu->docu_id], 'method' => 'POST']) !!}
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
                        ], $docu->department, ['disabled'])}}
                        {{Form::label('', 'Department')}}
                    </div>
                </div>

                <div class="col s6">
                    <div class="input-field">
                        {{Form::label('subject', 'Subject')}}
                        {{Form::text('subject', $docu->subject, ['class' => 'validate'])}}
                    </div>
                </div>
                
                <div class="col s6">
                    <div class="input-field">
                        {{Form::text('sender', $docu->sender, ['placeholder' => 'Sender'])}}
                        {{Form::label('sender', 'Sender')}}
                    </div>
                </div>

                <div class="col s6">
                    <div class="input-field">
                        {{Form::text('recipient', $docu->recipient, ['placeholder' => 'For/To'])}}
                        {{Form::label('recipient', 'For/To')}}
                    </div>
                </div>

                <div class="col s6">
                    <div class="input-field">
                    {{Form::text('sender_add', $docu->sender_add, ['placeholder' => 'Sender Address'])}}
                        {{Form::label('sender_add', 'Sender Address')}}
                    </div>
                </div>

                <div class="col s6">
                    <div class="input-field">
                    {{Form::text('addressee', $docu->addressee, ['placeholder' => 'Addressee'])}}
                        {{Form::label('addressee', 'Addressee(s)')}}
                        
                    </div>
                </div>


                <div class="col s6">
                    <div class="input-field">
                    {{Form::text('final_action_date', $docu->final_action_date, ['class' => 'datepicker', 'disabled'])}}
                        {{Form::label('final_action_date', 'Final Action Date')}}
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
</script>
@endpush