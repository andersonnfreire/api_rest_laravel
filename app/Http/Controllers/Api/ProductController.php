<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\API\ApiError;

class ProductController extends Controller
{

	public function __construct(Product $product)
	{
		$this->product = $product;
	}

    public function index()
    {
    	return response()->json($this->product->paginate(10));
    }
    public function show(Product $id)
    {
		try {
		    $produto = Product::find($id);
		    return response()->json($produto);
		}catch (ModelNotFoundException $e) {
	    	return response()->json($e->getMessage(),404);
		}    		        	
    }
    public function store(Request $request)
    {
    	try{
    		$productData = $request->all();	
    		$this->product->create($productData);
    		$return = ['data' => ['msg' => 'Produto criado com sucesso!']];
    		return response()->json($return,201);
    	}
    	catch(\Exception $e){
    		if(config('app.debug'))
    		{
    			return response()->json(ApiError::errorMessage($e->getMessage(),1010));
    		}
    		return response()->json(ApiError::errorMessage('Houve um errro ao realizar operação de inserir',1010));
    	}
		
    }	

    public function update(Request $request, $id)
    {
    	try{
    		$productUp = $request->all();	
    		$produto   = $this->product->find(11);
    		$produto->update($productUp);

    		$return = ['data' => ['msg' => 'Produto atualizado com sucesso!']];
    		return response()->json($return,201);
    	}
    	catch(\Exception $e){
    		if(config('app.debug'))
    		{
    			return response()->json(ApiError::errorMessage($e->getMessage(),1010));
    		}
    		return response()->json(ApiError::errorMessage('Houve um errro ao realizar operação atualizar',1011));
    	}
		
    }

    public function delete(Product $id)
    {
    	try{
    		$id->delete();

    		$return = ['data' => ['msg' => 'Produto:' .$id->name .' excluido com sucesso!']];
    		return response()->json($return,200);
    	}
    	catch(\Exception $e){
    		if(config('app.debug'))
    		{
    			return response()->json(ApiError::errorMessage($e->getMessage(),1010));
    		}
    		return response()->json(ApiError::errorMessage('Houve um errro ao realizar operação de remover',1012));
    	}
		
    }	



}
