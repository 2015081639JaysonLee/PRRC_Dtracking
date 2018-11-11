@extends('layouts.app')


@section('content')
<!-- <div class="container"> -->
<table class="bordered" id="users-table">
    <thead>
        <tr>
            <th>FROM</th>
            <th>TO</th>
            <th>DATE</th>
            <th>INSTRUCTIONS/REMARKS</th>
            <th>DEADLINE</th>
            <th>DATE COMPLIED</th>
            
        </tr>
    </thead>
    <tbody>
    <?php 
        $keyBackFrom = 0;
        $keyBackTo = 0;
        $keyBackRemarks = 0;
        $keyBackDeadline = 0;
    ?>
        @foreach($history as $key => $out)
            <tr>
            @if(array_key_exists('sender', $out->new_values))
                <td>{{$out->new_values['sender']}}</td>
                <?php $keyBackFrom = $out->new_values['sender'];?>
            @else
                <td>{{$keyBackFrom}}</td>
            @endif

            @if(array_key_exists('recipient', $out->new_values))
                <td>{{$out->new_values['recipient']}}</td>
                <?php $keyBackTo = $out->new_values['recipient'];?>
            @else
                <td>{{$keyBackTo}}</td>
            @endif

                <td style = "background : red; color : white;">Unsure pa ako</td>
            
            @if(array_key_exists('final_action_remarks', $out->new_values))
                <td>{{$out->new_values['final_action_remarks']}}</td>
                <?php $keyBackRemarks = $out->new_values['final_action_remarks'];?>
            @else
                <td>{{$keyBackRemarks}}</td>
            @endif
            
            @if(array_key_exists('final_action_date', $out->new_values))
                <td>{{$out->new_values['final_action_date']}}</td>
                <?php $keyBackDeadline = $out->new_values['final_action_date'];?>
            @else
                <td>{{$keyBackDeadline}}</td>
            @endif

                <td  style = "background : red; color : white;">Di ko alam to</td>
            </tr>
        @endforeach
    </tbody>
</table>
<!-- </div> -->

@endsection