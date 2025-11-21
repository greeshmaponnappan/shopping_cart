<?php

namespace App\Interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface
{
   
    public function all();
    public function paginate(int $perPage = 12): LengthAwarePaginator;
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    // public function find(int $id): ?Product;
    // public function create(array $data): Product;
    // public function update(int $id, array $data): Product;
}
