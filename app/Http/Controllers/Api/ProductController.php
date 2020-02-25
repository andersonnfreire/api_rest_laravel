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
    	$data = ['data' => $id];
    	return response()->json($data);
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
    		return response()->json(ApiError::errorMessage('Houve um errro ao realizar operação',1010));
    	}
		
    }	

    


    
}
