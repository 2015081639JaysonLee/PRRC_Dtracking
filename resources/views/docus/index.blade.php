@extends('layouts.app')

@section('search')

<form class= "hide-on-med-and-down search-on-nav">
  <div class="input-field grey lighten-2">
    <input id="autocomplete-input" type="search" class="autocomplete search-bar" required>
      <label class="label-icon search-icon" for="autocomplete-input">
        <i class="material-icons blue-text">search</i>
      </label>
    </div>
  </form> 
@endsection

@section('content')
@include('inc.message')
    
  <h4>{{$title}}</h4>
  <table class="bordered" id="users-table">
    <thead>
      <tr>
        <th style="width:10%;">CODE</th>
        <th style="width:30%;">SUBJECT</th>
        <th style="width:20%;">CREATOR</th>
        <th style="width:30%;">FINAL ACTION DATE</th>
        <th style="width:10%;">STATUS</th>
      </tr>
    </thead>
    <tbody>
            @foreach($docus as $out)
                @if($out->is_rush)
                    
      <tr class = "red lighten-2">
                @else
                    
        <tr>
                @endif
                    
          <td> {{$out->id}} </td>
          <td>
            <a href ="/docu/{{$out->id}}" style = "color : #0d47a1">
              <b> {{$out->subject}}</b>
            </a>
          </td>
          <td>{{App\User::whereId($out->user_id)->pluck('username')->first()}}</td>
          <td>{{\Carbon\Carbon::parse($out->final_action_date)->format('Y-m-d g:i:s A')}}</td>
          <td>{{App\RouteInfo::where('docu_id', $out->id)->first()->statuscode()->first()->status}}</td>
        </tr>                
            @endforeach
        
      </tbody>
    </table>
    @if(Auth::user()->role->name == 'Encoder' || Auth::user()->role->name == 'Super Admin')
    
    <div class="fixed-action-btn">
      <a class="btn-floating btn-large green">
        <i class="large material-icons">add</i>
      </a>
      <ul>
        <li>
          <a class="waves-effect waves-light btn-floating light-blue tooltipped" data-tooltip="Manual Add" data-position="left" href='/docu/create'>
            <i class="material-icons">mode_edit</i>
          </a>
        </li>
      </ul>        
    @endif
@stop

@push('scripts')

      <script>
    document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.fixed-action-btn');
    var instances = M.FloatingActionButton.init(elems, {
    //   direction: 'left'
        hoverEnabled: false
    });
  });
 $(function() {
    
    $('.fixed-action-btn').floatingActionButton();
    $('.tooltipped').tooltip();
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