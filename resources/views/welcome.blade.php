@extends('layout')

@section('content')


<h3 class="text-dark align-center">{{count($productsApi)}} Avaliable producs</h3>

<table id="example" class="table table-striped display nowrap" style="width:100%">
    <thead>
        <tr>
            <th>Handle</th>
            <th>Title</th>
            <th>Variant Barcode</th>
            <th>Image Src</th>
            <th>Body (HTML)</th>

          
        </tr>
    </thead>
    <tbody>
        @foreach($productsApi as $product)                       

        <tr>
      <td>{{$product->handle}}</td>                                                                         
      <td>{{$product->name}}</td>                                                                         

        <td>{{$product->upc}}</td>                                                                         
        <td>{{$product->img}}</td>                                                                         
        <td>{{$product->description}}</td>                                                                         
           
            </td>
        </tr>
 
      @endforeach

        
    </tbody>
  
</table>

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




@endsection