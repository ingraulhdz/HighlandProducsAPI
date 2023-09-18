@extends('layout')

@section('css')
<link href="https://cdn.datatables.net/select/1.6.2/css/select.bootstrap5.css" rel="stylesheet"/>
@endsection
@section('content')

@if(Session::has('message'))
    
    <div class="alert alert-primary alert-dismissible" data-mdb-dismiss="alert">{{ session('message') }}'</div>
@endif



<h3 class="text-dark align-center">{{count($products)}} Avaliable products from API</h3>
<a href="toShopify" class="btn btn-primary">Export to Shopify <i class="fab fa-shopify fa-lg"></i></a>

<table id="example" class="table datatable table-striped display nowrap" style="width:100%"  data-mdb-striped="true" data-mdb-sm="true" data-mdb-fixed-header="true" data-mdb-border-color="primary">
    <thead>
        <tr>
            <th>Name</th>
            <th>UPC</th>
            <th>Image</th>
            <th>Options</th>
          
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)                       

        <tr>
      <td>{{$product->name}}</td>                                                                         
       <td>{{$product->upc}}</td>   
       <td>{{$product->img ? 'Ok'  : 'NO IMAGE'}}</td>   
       <td>
        <a href="{{route('products.show' , $product)}}" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i>
        </a>
    </td>                                                                      
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
<script src="https://cdn.datatables.net/select/1.6.2/js/dataTables.select.js"></script>
@endsection