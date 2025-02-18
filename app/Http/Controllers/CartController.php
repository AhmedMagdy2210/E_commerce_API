<?php

namespace App\Http\Controllers;

use App\ApiTrait;
use App\Http\Resources\Cart\CartResource;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Models\ProductDetail;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller {
    use ApiTrait;
    /**
     * Index method to return the user cart
     * Store method to store the cart_items and if the user dosent have a cart create one
     * Update to update the cart_items quantity in the cart
     * Destroy to delete the cart
     * Clear to clear all the items for the cart
     * UpdateCartTotal to check if the user have cart :-
     *      if : no create one and add the total_price of the items
     *      if : yes just update the total_price
     */

    public function index() {
        $userId = Auth::id();
        $cart = Cart::where('user_id', $userId)->with('items.product_details.product.category', 'items.product_details.size', 'items.product_details.color')->first();
        if (!$cart) {
            $cart = $this->createCart($userId);
        }

        return $this->successResponse(new CartResource($cart), 'The cart data');
        // $cartItems = CartItem::where('cart_id', $cart->id)->with('product_details.product.category', 'product_details.size', 'product_details.color')->get();
        // $total_price = $cart->total_price;

    }

    public function createCart($userId) {
        $cart = Cart::create([
            'user_id' => $userId,
            'total_price' => 0,
        ]);
        return $cart;
    }

    public function store(Request $request) {
        $userId = Auth::id();
        $validator = Validator::make($request->all(), [
            'product_detail_id' => 'required|exists:product_details,id',
            'quantity' => 'required|integer|min:1'
        ]);
        if ($validator->fails()) {
            return $this->failedValidationResponse($validator->errors());
        }
        $productDetail = ProductDetail::find($request->product_detail_id);
        if (!$productDetail) {
            return $this->errorResponse('No product found', 404);
        } elseif ($productDetail->stock_quantity < $request->quantity) {
            return $this->errorResponse('Not enough stock', 400);
        }
        $price = $request->quantity * $productDetail->price;
        $cart = Cart::firstOrCreate(['user_id' => $userId]);
        $cartItem = CartItem::updateOrCreate([
            'cart_id' => $cart->id,
            'product_details_id' => $request->product_detail_id,
        ], ['quantity' => DB::raw("quantity + {$request->quantity}"), 'price' => DB::raw("price + {$price}")]);
        //must update the cart->total_price after i create or update the cart_items so:
        $this->updateCartTotal($cart->id);
        return $this->successResponse($cartItem, "The item added successfully", 200);
    }



    public function updateCartTotal($cartId) {
        $totalPrice = CartItem::where('cart_id', $cartId)->sum('price');
        Cart::where('id', $cartId)->update(['total_price' => $totalPrice]);
    }
}
