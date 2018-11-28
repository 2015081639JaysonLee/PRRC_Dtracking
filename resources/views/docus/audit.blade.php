@extends('layouts.app')


@section('content')

<!-- <div class="container"> -->
<h4>Routing History</h4>
<table class="bordered" id="users-table">
  <thead>
    <tr>
      <th>ID</th>
      <th>FROM</th>
      <th>TO</th>
      <th>DATE SENT</th>
      <th>INSTRUCTIONS/REMARKS</th>
      <th>DEADLINE</th>
      <th>DATE COMPLIED</th>
    </tr>
  </thead>
  <tbody>
    <?php $key = 1;?>
        @foreach($route_history as $out)
            
    <tr>
      <td>{{$key}}</td>
      <!-- From column -->
      <td>{{$out->new_values['sender']}}</td>
      <!-- To column -->
      <td>{{App\User::whereId($out->new_values['receipient_id'])->first()->username}}</td>
      <!-- Date sent column -->
      <td>{{\Carbon\Carbon::parse($out->new_values['updated_at'])->format('Y-m-d g:i:s A')}}</td>
      <!-- Remark column -->
            @if(array_key_exists('routeinfo_id', $out->new_values))
                
      <td>{{$remark = App\RouteInfo::whereId($out->new_values['routeinfo_id'])->pluck('remarks')->first()}}</td>
            @else
                
      <td>No specified remark</td>
            @endif
            
            
      <!-- Deadline column -->
      <td>{{\Carbon\Carbon::parse($out->new_values['date_deadline'])->format('Y-m-d g:i:s A')}}</td>
      <!-- Compiled column -->
            @if(array_key_exists('routeinfo_id', $out->new_values))
                
      <?php $compiled = App\RouteInfo::whereId($out->new_values['routeinfo_id'])->pluck('updated_at')->first();?>
      <td>{{\Carbon\Carbon::parse($compiled)->format('Y-m-d g:i:s A')}}</td>
            @else
                
      <td>No specified compiled date</td>
            @endif
            
    </tr>
    <?php $key++;?>
        @endforeach
    
  </tbody>
</table>

@stop

@push('scripts')

<script>
    $(document).ready(function(){
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
    });

  </script>
@endpush