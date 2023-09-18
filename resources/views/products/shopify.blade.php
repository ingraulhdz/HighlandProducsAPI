@extends('layout')

@section('css')
<link href="https://cdn.datatables.net/select/1.6.2/css/select.bootstrap5.css" rel="stylesheet"/>
@endsection


@section('content')



<h3 class="text-dark align-center">{{count($productsApi)}} Products to export |    {{ $calls ?? 'calls' }}
    Calls</h3>

<table id="example" class="table table-striped display nowrap" style="width:100%">
    <thead>
        <tr>
            <th>Handle</th>
            <th>Title</th>
            <th>Image Src</th>
            <th>Body (HTML)</th>
          
        </tr>
    </thead>
    <tbody>
        @foreach($productsApi as $product)                       

        <tr>
      <td>{{$product->handle}}</td>                                                                         
      <td>{{$product->title}}</td>                                                                         

        <td>{{$product->image_src}}</td>                                                                         
        <td>{{$product->description}}</td>                                                                         
           
            </td>
        </tr>
 
      @endforeach

        
    </tbody>
  
</table>

@endsection


@section('js')

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>

<script>


    $(document).ready(function() {
$('#example').DataTable( {
    dom: 'Bfrtip',
    buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
    ]
} );
} );



</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.js"></script>
<script src="https://cdn.datatables.net/select/1.6.2/js/dataTables.select.js"></script>
@endsection