<?php


namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductsImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return Product|null
     */
    public function model(array $row)
    {
        return new Product([
           'id'     => $row[0],
           'name'    => $row[1],
        ]);
    }
}