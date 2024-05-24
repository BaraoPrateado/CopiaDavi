<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUpdateSupport;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('id', 'desc')->get();
        $total = Product::count();
        return view('admin.product.home', compact(['products','total']));
    }

    public function create()
    {
        return view('admin.product.create');
    }

    public function save(StoreUpdateSupport $request)
    {
        
        $data = $request->validated();
        // dd($data);
        $data = Product::create($data);
        if ($data) {
            session()->flash('success','Produto adicionado com sucesso');
            return redirect()->route('products.index');
        } else {
            session()->flash('error','Falha na criação');
            return redirect()->route('products.create');
        }
    }

    public function edit($id)
    {
        $products = Product::findOrFail($id);
        return view('admin.product.update', compact('products',));
    }

    public function delete($id)
    {
        $products = Product::findOrFail($id)->delete();
        if ($products) {
            session()->flash('success', 'Produto excluído com sucesso!');
            return redirect()->route('products.index');
        } else {
            session()->flash('error','Erro na exclusão do item');
            return redirect()->route('products.index');
        }
    }
    public function update(StoreUpdateSupport $request, $id)
    {
        $data = $request->validated();

        $products = Product::findOrFail($id);
        
        $nome = $request->nome;
        $categoria = $request->categoria;
        $valor = $request->valor;

        $products->nome = $nome;
        $products->categoria = $categoria;
        $products->valor = $valor;
        $data = $products->save();
        if ($data) {
            session()->flash('success', 'Produto atualizado com sucesso!');
            return redirect()->route('products.index');
        } else {
            session()->flash('error','Falha na edição');
            return redirect()->route('products.update');
        }

    
}
}