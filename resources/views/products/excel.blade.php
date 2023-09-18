<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        table, th, td {
  border: 1px solid black;
}
</style>
</head>
<body>
    <table>
        <thead>
        <tr>
            <th>Handle</th>
            <th>Title</th>
            <th>Variant Grams</th>
                       <th>LxWxH_Bottle</th>
                       <th>Body (HTML)</th>
                       <th>Image Src</th>


        </tr>
        </thead>
        <tbody>
        @foreach($products as $product)
            <tr>
                <td>{{ $product->handle }}</td>
                <td>{{ $product->Item_description }}</td>
                <td>{{ $product->Wgt_Unit}}</td>
                       <td>{{ $product->LxWxH_Bottle}}</td>
                       <td>{{ $product->description}}</td>
                       <td>{{ $product->img}}</td>

            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>