@extends('layouts.app')

@section('header')
    <h2 style="position:fixed;">Document Tracker</h2>
   
   
@endsection

@section('content')

<div>
        
        <table class= "table">
        <thead>
            <tr>
            <th class = "topleft main_th">CODE</th>
            <th class = "main_th">SUBJECT</th>
            <th class = "main_th">SENDER</th>
            <th class = "main_th">FOR/TO</th>
            <th class = "topright main_th">STATUS</th>
            </tr>
        </thead>

         <tbody style="text-align:center;">

        </tbody>
                      
        </table>
        
</div>

        <!--PAGINATION-->
        <div class="paginations">    
            <nav aria-label="Page navigation example ">
                <ul class="pagination ">
                  <li class="page-item"> {{$docus->links()}}</li>
                </ul>
            </nav>
        </div>
            
        <!--SEARCH FUNCTION-->
        <script>
                $(document).ready(function(){
                
                 fetch_docu_data();
                
                 function fetch_docu_data(query = '')
                 {
                  $.ajax({
                   url:"{{ route('live_search.action') }}",
                   method:'GET',
                   data:{query:query},
                   dataType:'json',
                   success:function(data)
                   {
                    $('tbody').html(data.table_data);
                    $('#total_records').text(data.total_data);
                   }
                  })
                 }
                
                 $(document).on('keyup', '#search', function(){
                  var query = $(this).val();
                  fetch_docu_data(query);
                 });
                });
                </script>
@endsection

