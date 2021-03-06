<?php

namespace App\Http\Controllers;

use App\OrderCart;
use App\User;
use Illuminate\Http\Request;
use Doctrine\ORM\Mapping AS ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Illuminate\Support\Facades\Auth;
use LaravelDoctrine\ORM\Facades\EntityManager;

class OrderCartsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $cart = EntityManager::getRepository('App\OrderCart')->findBy(array("user"=>Auth::user()->getAuthIdentifier()));
        $products = $cart[0]->getOrderCartProducts();
        $type = "order";
        return view("cartProducts", compact('products', 'type'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $cart = EntityManager::getRepository('App\OrderCart')->findBy(array("user"=>Auth::user()->getAuthIdentifier()));
        $cart[0]->emptyProducts();
        $products = $cart[0]->getOrderCartProducts();
        $type = "order";
        return view("cartProducts", compact('products', 'type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        //$cart = EntityManager::find('App\OrderCart', $request->user_id);
        $cart = new OrderCart();
        $cart = EntityManager::getRepository('App\OrderCart')->findBy(array("user"=>Auth::user()->getAuthIdentifier()));
        $product = EntityManager::find('App\Product', $id);
        $price = 0.0;
        if($product->type == "normal"){
            $price = $product->getPrice();
        }else{
            $price = $product->getNewPrice();
        }
        if(count($cart)){
            $c = $cart[0];
            $arr = $c->getOrderCartProducts();
            EntityManager::detach($c);
            $c->addProduct($product);
            $c->setTotalPrice($c->getTotalPrice()+$price);

            EntityManager::merge($c);
            foreach ($arr as $orderCartProduct){
                EntityManager::merge($orderCartProduct);
            }

            EntityManager::flush();

            return response()->json(array("text"=>"added"));
        }else{
            $cart = new OrderCart();
            $cart->setTotalPrice($price);
            $cart->setUser(Auth::user());
            $cart->addProduct($product);
            EntityManager::persist($cart);
            EntityManager::flush();
            return response()->json(array("text"=>"created"));
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $product = EntityManager::find('App\Product', $id);
        $carts = EntityManager::getRepository('App\OrderCart')->findBy(array("user"=>Auth::user()->getAuthIdentifier()));
        $cart = $carts[0];
        $cart->removeProduct($product);
        return response()->json(array("text"=>"OK"));
    }
}
