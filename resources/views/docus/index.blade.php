@extends('layouts.app')

@section('search')
<form class= "hide-on-med-and-down search-on-nav">
    <div class="input-field blue lighten-2">
        <input id="autocomplete-input" type="search" class="autocomplete search-bar" required>
        <label class="label-icon search-icon" for="autocomplete-input"><i class="material-icons blue-text">search</i></label>
    </div>
</form> 
@endsection

@section('content')
<div class = "msg">
    @include('inc.message')
</div>
    <table class="bordered" id="users-table">
        <thead>
            <tr>
                <th>CODE</th>
                <th>SUBJECT</th>
                <th>SENDER</th>
                <th>FOR/TO</th>
                <th>STATUS</th>
            </tr>
        </thead>
        <tbody>
            @foreach($docus as $out)
                <tr>
                    <td> {{$out->docu_id}} </td>
                    <td><a href ="/docu/{{$out->docu_id}}"> {{$out->subject}}</a></td>
                    <td>{{$out->sender}}</td>
                    <td>{{$out->recipient}}</td>
                    <td>{{App\RouteInfo::where('docu_id', '=', $out->docu_id)->latest('id')->pluck('status')->first()}}</td>
                </tr>                
            @endforeach
        </tbody>
    </table>
@stop

@push('scripts')
<script>
 $(function() {
        $('#users-table').DataTable({
            responsive: {
                // details: {
                //     display : $.fn.dataTable.Responsive.display.modal({
                //         header: function ( row ) {
                //             var data = row.data();
                //             return 'Details for '+data[0]+' '+data[1];
                //         }
                //     }),
                //     renderer: $.fn.dataTable.Responsive.renderer.tableAll()
                // } @TODO try gawin to after all basic functionalities
            },
            pagingType: "simple",
            pageLength: 10,
            dom: '<div>pt',
            language:{
                paginate:{
                    previous: "<i class='material-icons'>chevron_left</i>",
                    next: "<i class='material-icons'>chevron_right</i>"
                }
            },
            order: []
        });
        oTable = $('#users-table').DataTable();
        $('#autocomplete-input').keyup(function() {
            oTable.search($(this).val()).draw();
        });
    });
</script>
@endpush