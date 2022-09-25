<?php

namespace App\Http\Controllers;

use App\Product;
use App\Area;
use App\Product_Warehouse;
use App\ProductTag;
use App\Quotation;
use App\Review;
use App\Tags;
use App\Tax;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Category;
use App\Cart;
use App\Order;
use App\Checkout;
use App\Sale;
use App\Customer;
use App\Product_Sale;
use App\Brand;
use App\Contact;
use App\User;
use App\Newsletter;
use App\Blog;
use App\Payment;
use App\Unit;
use App\ProductQuotation;
use App\Variant;
use App\Wishlist;
use App\Hub;

use Auth;
use Hash;
use App\Mail\UserNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;


use Illuminate\Support\Facades\DB;


class WebsiteController extends Controller
{
    //home page view
    public function index(Request $request)
    {

        $session = \Session::getId();
        if ($request->quick_id == null) {

            $product_details_info = null;
            $quick_view = null ;

        }else{
            $product_details_info  = Product::orderBy('id', 'DESC')
                ->join('brands', 'brands.id', '=', 'products.brand_id')
                ->where('products.id', '=', $request->quick_id)
                ->where('products.is_active', true)
                ->select('products.*')
                ->first();
            $quick_view = 9 ;

        }

        $skin_tags = Tags::where('tag_parent_name','Skin Issue')->get();
        $ingredients_tags = Tags::where('tag_parent_name','Ingredient')->get();
        $routine_tags = Tags::where('tag_parent_name','Routine')->get();

        // foreach ()
        $categories = Category::orderBy('categories.id', 'DESC')
            ->join('products', 'products.category_id', '=', 'categories.id')
            ->where('categories.is_active', true)
            ->where('categories.parent_id',null)
            ->where('products.is_active', true)
            ->select('categories.id', 'categories.name')
            ->distinct('categories.name')
            ->limit(5)
            ->get();


        $carts = Cart::where('user_ip', request()->ip())->where('session', $session)->latest()->get();
        $subtotal = Cart::all()->where('user_ip', request()->ip())->where('session', $session)->sum(function($t){
            return $t->product_price * $t->product_quantity;
        });
        $products   = Product::orderBy('id', 'DESC')->where('is_active', true)->get();

        // Skin Care
        $count_product =Product_Sale::select(DB::raw('COUNT(id) as cnt', 'product_id'),'product_id')
            ->groupBy('product_id')->orderBy('cnt', 'DESC')->get();
        if (count($count_product) > 0){
            foreach ($count_product as $val){
                $product_id[] = $val->product_id;
            }
        }else{
            foreach ($products as $val){
                $product_id[] = $val->id;
            }
        }



        $brand_parent_id = Brand::where('title','=','Invisible')->first()->id;
        $brand_parent = Brand::where('parent_id', $brand_parent_id)->get();

        foreach ($brand_parent as $row){
            $brand_p_id[] = $row->id;
        }


        $cat_parent_id = Category::where('name','=','Sample')->first()->id;
        $catgory_parent = Category::where('parent_id', $cat_parent_id)->get();

        foreach ($catgory_parent as $row){
            $cat_p_id[] = $row->id;
        }



        $skin_products_best_sell= Product::orderBy('id', 'DESC')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('brands', 'products.brand_id', '=', 'brands.id')
            ->where('categories.is_active', true)
            ->whereNotIn('products.category_id', $cat_p_id)
            ->whereNotIn('products.brand_id', $brand_p_id)
            ->where('products.best_sale_featured',1)
            ->where('products.is_active', true)
            ->select('products.*')
            ->limit(10)
            ->get();


        if ($skin_products_best_sell->count() < 1){
            $skin_products_best_sell = Product::join('categories', 'products.category_id', '=', 'categories.id')
                ->join('brands', 'products.brand_id', '=', 'brands.id')
                ->where('categories.is_active', true)
                ->whereNotIn('products.category_id', $cat_p_id)
                ->whereNotIn('products.brand_id', $brand_p_id)
                ->where('products.is_active', true)
                ->orderBy('products.id', 'DESC')
                ->select('products.*')
                ->limit(10)
                ->get();
        }

        $skin_products_arrivals = Product::join('categories', 'products.category_id', '=', 'categories.id')
            ->join('brands', 'products.brand_id', '=', 'brands.id')
            ->where('categories.is_active', true)
            ->whereNotIn('products.category_id', $cat_p_id)
            ->whereNotIn('products.brand_id', $brand_p_id)
            ->where('products.is_active', true)
            ->orderBy('products.id', 'DESC')
            ->select('products.*')
            ->limit(15)
            ->get();




        // Hair & Body

        $count_product =Product_Sale::select(DB::raw('COUNT(id) as cnt', 'product_id'),'product_id')
            ->groupBy('product_id')->orderBy('cnt', 'DESC')->get();

        foreach ($count_product as $val){
            $product_id[] = $val->product_id;
        }
        $hair_and_body_products_best_sell= Product::orderBy('id', 'DESC')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('brands', 'products.brand_id', '=', 'brands.id')
            ->where('categories.is_active', true)
            ->where('categories.name','=', 'Hair & Body')
            ->whereIn('products.id',$product_id)
            ->whereNotIn('products.brand_id', $brand_p_id)
            ->where('products.is_active', true)
            ->select('products.*')
            ->get();
        if ($hair_and_body_products_best_sell->count() < 1){
            $hair_and_body_products_best_sell = Product::join('categories', 'products.category_id', '=', 'categories.id')
                ->join('brands', 'products.brand_id', '=', 'brands.id')
                ->where('categories.is_active', true)
                ->where('categories.name','=', 'Hair & Body')
                ->where('products.is_active', true)
                ->whereNotIn('products.brand_id', $brand_p_id)
                ->orderBy('products.id', 'DESC')
                ->select('products.*')
                ->get();
        }

        $hair_and_body_products_arrivals = Product::join('categories', 'products.category_id', '=', 'categories.id')
            ->join('brands', 'products.brand_id', '=', 'brands.id')
            ->where('categories.is_active', true)
            ->where('categories.name','=', 'Hair & Body')
            ->where('products.is_active', true)
            ->whereNotIn('products.brand_id', $brand_p_id)
            ->orderBy('products.id', 'DESC')
            ->select('products.*')
            ->get();



        // Makeup
        $count_product =Product_Sale::select(DB::raw('COUNT(id) as cnt', 'product_id'),'product_id')
            ->groupBy('product_id')->orderBy('cnt', 'DESC')->get();

        foreach ($count_product as $val){
            $product_id[] = $val->product_id;
        }
        $makeup_products_best_sell= Product::orderBy('id', 'DESC')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('brands', 'products.brand_id', '=', 'brands.id')
            ->where('categories.is_active', true)
            ->where('categories.name','=', 'Makeup')
            ->whereIn('products.id',$product_id)
            ->whereNotIn('products.brand_id', $brand_p_id)
            ->where('products.is_active', true)
            ->select('products.*')
            ->get();
        if ($makeup_products_best_sell->count() < 1){
            $makeup_products_best_sell = Product::join('categories', 'products.category_id', '=', 'categories.id')
                ->join('brands', 'products.brand_id', '=', 'brands.id')
                ->where('categories.is_active', true)
                ->where('categories.name','=', 'Makeup')
                ->where('products.is_active', true)
                ->whereNotIn('products.brand_id', $brand_p_id)
                ->orderBy('products.id', 'DESC')
                ->select('products.*')
                ->get();
        }

        $makeup_products_arrivals = Product::join('categories', 'products.category_id', '=', 'categories.id')
            ->join('brands', 'products.brand_id', '=', 'brands.id')
            ->where('categories.is_active', true)
            ->where('categories.name','=', 'Makeup')
            ->where('products.is_active', true)
            ->whereNotIn('products.brand_id', $brand_p_id)
            ->orderBy('products.id', 'DESC')
            ->select('products.*')
            ->get();

        $brands     = Brand::orderBy('title', 'ASC')->where('is_active', true)->where('title','!=','OTHERS')->where('parent_id', NULL)->get();

     /*   $brands     = Brand::orderBy('title', 'ASC')
                    ->where('is_active', true)
                    ->where('title','!=','OTHERS')
//                    ->where('parent_id', NULL)
                    ->whereNotIn('id', $brand_p_id)
                    ->get();*/
        $blog       = Blog::orderBy('id', 'DESC')->get();
        return view('eshop.home', compact('quick_view','product_details_info','routine_tags','ingredients_tags','skin_tags','makeup_products_best_sell','makeup_products_arrivals','hair_and_body_products_arrivals','hair_and_body_products_best_sell','skin_products_arrivals','skin_products_best_sell','products', 'categories', 'carts', 'subtotal', 'brands', 'blog'));
    }



    public function make_up()
    {
        $session = \Session::getId();
        $brands     = Brand::orderBy('title', 'ASC')->where('is_active', true)->where('title','!=','OTHERS')->where('parent_id', NULL)->get();
        $products   = Product::orderBy('id', 'DESC')->where('is_active', true)->limit(3)->get();
        $cat_name = Category::where('id', '=', 20)->first();
        $cat = Category::orderBy('id', 'DESC')
            ->where('is_active', true)
            ->get();

        $brand_parent_id = Brand::where('title','=','Invisible')->first()->id;
        $brand_parent = Brand::where('parent_id', $brand_parent_id)->get();

        foreach ($brand_parent as $row){
            $brand_p_id[] = $row->id;
        }

        $brands_product = DB::table('brands')
            ->join('products', 'products.brand_id', '=', 'brands.id')
            ->where('brands.is_active', true)
            ->where('products.is_active', true)
            ->where('products.category_id', '=', 20)
            ->whereNotIn('products.brand_id', $brand_p_id)
            ->distinct('products.brand_id')
            ->select('brands.title', 'brands.id','brands.image')
            ->get();

        // return $brands; exit();
        $categories = Category::orderBy('categories.id', 'DESC')
            ->join('products', 'products.category_id', '=', 'categories.id')
            ->where('categories.is_active', true)
            ->where('categories.parent_id', null)
            ->where('products.is_active', true)
            ->select('categories.id', 'categories.name')
            ->distinct('categories.name')
            ->limit(5)
            ->get();
        $carts = Cart::where('user_ip', request()->ip())->where('session', $session)->latest()->get();
        $subtotal = Cart::all()->where('user_ip', request()->ip())->where('session', $session)->sum(function($t){
            return $t->product_price * $t->product_quantity;
        });

        $makeup_products = Product::orderBy('id', 'DESC')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('brands', 'products.brand_id', '=', 'brands.id')
            ->where('categories.is_active', true)
            ->where('categories.name','=', 'Make up')
            ->whereNotIn('products.brand_id', $brand_p_id)
            ->where('products.is_active', true)
            ->select('products.*')
            ->paginate(8);

        $next_products = Product::where('is_active', true)
            ->orderBy('id', 'DESC')
            ->skip(3)
            ->take(3)
            ->get();
        $category_id = 20;

        return view('eshop.make-up', compact('brands_product','categories', 'makeup_products', 'carts', 'subtotal', 'brands', 'category_id', 'cat_name', 'cat', 'products', 'next_products'));
    }



    //category product page view
    public function category($category_id)
    {
        $session = \Session::getId();
        $brands     = Brand::orderBy('title', 'ASC')->where('is_active', true)->where('title','!=','OTHERS')->where('parent_id', NULL)->get();
        $products   = Product::orderBy('id', 'DESC')->where('is_active', true)->limit(3)->get();
        $cat_name = Category::where('id', '=', $category_id)->first();


        $cat = Category::orderBy('id', 'DESC')
            ->where('is_active', true)
            ->get();

        $brand_parent_id = Brand::where('title','=','Invisible')->first()->id;
        $brand_parent = Brand::where('parent_id', $brand_parent_id)->get();

        foreach ($brand_parent as $row){
            $brand_p_id[] = $row->id;
        }
        $brands_product = DB::table('brands')
            ->join('products', 'products.brand_id', '=', 'brands.id')
            ->where('brands.is_active', true)
            ->where('products.is_active', true)
            ->where('products.category_id', '=', $category_id)
            ->whereNotIn('products.brand_id', $brand_p_id)
            ->distinct('products.brand_id')
            ->select('brands.title', 'brands.id','brands.image')
            ->get();
        // return $brands; exit();
        $categories = Category::orderBy('categories.id', 'DESC')
            ->join('products', 'products.category_id', '=', 'categories.id')
            ->where('categories.is_active', true)
            ->where('categories.parent_id', null)
            ->where('products.is_active', true)
            ->select('categories.id', 'categories.name')
            ->distinct('categories.name')
            ->limit(5)
            ->get();
        $carts = Cart::where('user_ip', request()->ip())->where('session', $session)->latest()->get();
        $subtotal = Cart::all()->where('user_ip', request()->ip())->where('session', $session)->sum(function($t){
            return $t->product_price * $t->product_quantity;
        });
        $product_category   = Category::orderBy('categories.id', 'DESC')
            ->join('products', 'products.category_id', '=', 'categories.id')
            ->where('products.category_id', '=', $category_id)
            ->where('products.is_active', true)
            ->where('products.mini_shop_featured', 1)
            ->whereNotIn('products.brand_id', $brand_p_id)
            ->select('products.*')
            ->paginate(8);
        // dd($product_category);

        $next_products = Product::where('is_active', true)
            ->orderBy('id', 'DESC')
            ->skip(3)
            ->take(3)
            ->get();

        return view('eshop.category', compact('brands_product','categories', 'product_category', 'carts', 'subtotal', 'brands', 'category_id', 'cat_name', 'cat', 'products', 'next_products'));

    }

    //category page
    public function category_page()
    {

        $session = \Session::getId();
        $brands     = Brand::orderBy('title', 'ASC')->where('is_active', true)->where('title','!=','OTHERS')->where('parent_id', NULL)->get();
        $categories = Category::orderBy('categories.id', 'DESC')
            ->join('products', 'products.category_id', '=', 'categories.id')
            ->where('categories.is_active', true)
            ->where('categories.parent_id', null)
            ->where('products.is_active', true)
            ->select('categories.id', 'categories.name', 'categories.image')
            ->distinct('categories.name')
            ->limit(5)
            ->get();
        $carts = Cart::where('user_ip', request()->ip())->where('session', $session)->latest()->get();
        $subtotal = Cart::all()->where('user_ip', request()->ip())->where('session', $session)->sum(function($t){
            return $t->product_price * $t->product_quantity;
        });

        $discount = Product::orderBy('id', 'DESC')
            ->where('promotion', 1)
            ->where('is_active', true)
            ->get();
        $products = Product::where('is_active', true)
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get();
        $next_products = Product::where('is_active', true)
            ->orderBy('id', 'DESC')
            ->skip(3)
            ->take(3)
            ->get();
        return view('eshop.category_page', compact('brands','discount','categories', 'carts', 'subtotal', 'products', 'next_products'));
    }


    //brands page
    public function brands($id, $category_id)
    {
        $session = \Session::getId();
        $cat_name = Category::where('id', '=', $category_id)->first();
        $brand_name = Brand::where('id', '=', $id)->first();

        $brand_parent_id = Brand::where('title','=','Invisible')->first()->id;
        $brand_parent = Brand::where('parent_id', $brand_parent_id)->get();

        foreach ($brand_parent as $row){
            $brand_p_id[] = $row->id;
        }


        $brand_products = Product::join('categories', 'categories.id', '=', 'products.category_id')
            ->join('brands', 'brands.id', '=', 'products.brand_id')
            ->where('products.category_id', '=', $category_id)
            ->where('products.brand_id', '=', $id)
            ->whereNotIn('products.brand_id', $brand_p_id)
            ->where('brands.is_active', 1)
            ->where('products.is_active', true)
            ->select('products.*')
            ->paginate(8);
        $categories = Category::orderBy('categories.id', 'DESC')
            ->join('products', 'products.category_id', '=', 'categories.id')
            ->where('categories.is_active', true)
            ->where('categories.parent_id', null)
            ->where('products.is_active', true)
            ->whereNotIn('products.brand_id', $brand_p_id)
            ->select('categories.id', 'categories.name')
            ->distinct('categories.name')
            ->limit(5)
            ->get();
        $carts = Cart::where('user_ip', request()->ip())->where('session', $session)->latest()->get();
        $subtotal = Cart::all()->where('user_ip', request()->ip())->where('session', $session)->sum(function($t){
            return $t->product_price * $t->product_quantity;
        });



        $brands = DB::table('brands')
            ->join('products', 'products.brand_id', '=', 'brands.id')
            ->where('brands.is_active', true)
            ->orderBy('brands.title', 'ASC')
            ->where('products.category_id', '=', $category_id)
            ->whereNotIn('products.brand_id', $brand_p_id)
            ->where('products.is_active', true)
            ->distinct('products.brand_id')
            ->select('brands.title', 'brands.id')
            ->get();

        $products = Product::where('is_active', true)
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get();
        $next_products = Product::where('is_active', true)
            ->orderBy('id', 'DESC')
            ->skip(3)
            ->take(3)
            ->get();

        return view('eshop.brand', compact('brand_products', 'categories', 'carts', 'subtotal', 'brands', 'category_id', 'cat_name', 'brand_name', 'products', 'next_products'));
    }

    // Category Product
    public function category_product($id)
    {
        $session = \Session::getId();
            $product_details_info = null;
            $quick_view = null ;

        $cat_parent_id = Category::where('name','=','Sample')->first()->id;
        $catgory_parent = Category::where('parent_id', $cat_parent_id)->get();

        foreach ($catgory_parent as $row){
            $cat_p_id[] = $row->id;
        }



        $brand_parent_id = Brand::where('title','=','Invisible')->first()->id;
        $brand_parent = Brand::where('parent_id', $brand_parent_id)->get();

        foreach ($brand_parent as $row){
            $brand_p_id[] = $row->id;
        }


        $brands     = Brand::orderBy('title', 'ASC')->where('is_active', true)->where('title','!=','OTHERS')->where('parent_id', NULL)->get();

        $category_name = Category::where('id', $id)->first();
      //  $category_name = Category::where('id', $id)->first();

        $categories = Category::orderBy('categories.id', 'DESC')
            ->join('products', 'products.category_id', '=', 'categories.id')
            ->where('categories.is_active', true)
            ->where('categories.parent_id', null)
            ->where('products.is_active', true)
            ->whereNotIn('products.brand_id', $brand_p_id)
            ->select('categories.id', 'categories.name')
            ->distinct('categories.name')
            ->limit(5)
            ->get();

        $carts = Cart::where('user_ip', request()->ip())->where('session', $session)->latest()->get();
        $subtotal = Cart::all()->where('user_ip', request()->ip())->where('session', $session)->sum(function($t){
            return $t->product_price * $t->product_quantity;
        });
        $categories_product = Product::orderBy('id', 'DESC')
            ->where('is_active', true)
            ->where('category_id', $id)
            ->whereNotIn('category_id', $cat_p_id)
            ->whereNotIn('brand_id', $brand_p_id)
            ->where('products.is_active', true)
            ->get();

        $products = Product::where('is_active', true)
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get();
        $next_products = Product::where('is_active', true)
            ->orderBy('id', 'DESC')
            ->skip(3)
            ->take(3)
            ->get();
        return view('eshop.category_product', compact('product_details_info','quick_view','brands','categories', 'carts', 'subtotal', 'categories_product', 'products', 'next_products', 'category_name'));

    }


    // Category Product
    public function category_product_name($id , $name)
    {
        $session = \Session::getId();
        $product_details_info = null;
        $quick_view = null ;

        $cat_parent_id = Category::where('name','=','Sample')->first()->id;
        $catgory_parent = Category::where('parent_id', $cat_parent_id)->get();

        foreach ($catgory_parent as $row){
            $cat_p_id[] = $row->id;
        }



        $brand_parent_id = Brand::where('title','=','Invisible')->first()->id;
        $brand_parent = Brand::where('parent_id', $brand_parent_id)->get();

        foreach ($brand_parent as $row){
            $brand_p_id[] = $row->id;
        }


        $brands     = Brand::orderBy('title', 'ASC')->where('is_active', true)->where('title','!=','OTHERS')->where('parent_id', NULL)->get();

        $category_name = Category::where('id', $id)->first();
        //  $category_name = Category::where('id', $id)->first();

        $categories = Category::orderBy('categories.id', 'DESC')
            ->join('products', 'products.category_id', '=', 'categories.id')
            ->where('categories.is_active', true)
            ->where('categories.parent_id', null)
            ->where('products.is_active', true)
            ->whereNotIn('products.brand_id', $brand_p_id)
            ->select('categories.id', 'categories.name')
            ->distinct('categories.name')
            ->limit(5)
            ->get();

        $carts = Cart::where('user_ip', request()->ip())->where('session', $session)->latest()->get();
        $subtotal = Cart::all()->where('user_ip', request()->ip())->where('session', $session)->sum(function($t){
            return $t->product_price * $t->product_quantity;
        });
        $categories_product = Product::orderBy('id', 'DESC')
            ->where('is_active', true)
            ->where('category_id', $id)
            ->whereNotIn('category_id', $cat_p_id)
            ->whereNotIn('brand_id', $brand_p_id)
            ->where('products.is_active', true)
            ->get();

        $products = Product::where('is_active', true)
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get();
        $next_products = Product::where('is_active', true)
            ->orderBy('id', 'DESC')
            ->skip(3)
            ->take(3)
            ->get();
        return view('eshop.category_product', compact('product_details_info','quick_view','brands','categories', 'carts', 'subtotal', 'categories_product', 'products', 'next_products', 'category_name'));

    }


    // Routine

    // Category Product
    public function tagwise_product($id)
    {
       //dd($id);
        $session = \Session::getId();
        $product_details_info = null;
        $quick_view = null ;

        $cat_parent_id = Category::where('name','=','Sample')->first()->id;
        $catgory_parent = Category::where('parent_id', $cat_parent_id)->get();

        foreach ($catgory_parent as $row){
            $cat_p_id[] = $row->id;
        }


        $brand_parent_id = Brand::where('title','=','Invisible')->first()->id;
        $brand_parent = Brand::where('parent_id', $brand_parent_id)->get();

        foreach ($brand_parent as $row){
            $brand_p_id[] = $row->id;
        }


        $brands     = Brand::orderBy('title', 'ASC')->where('is_active', true)->where('title','!=','OTHERS')->where('parent_id', NULL)->get();

        $category_name = Tags::where('id', $id)->first();
        //  $category_name = Category::where('id', $id)->first();

        $categories = Category::orderBy('categories.id', 'DESC')
            ->join('products', 'products.category_id', '=', 'categories.id')
            ->where('categories.is_active', true)
            ->where('categories.parent_id', null)
            ->where('products.is_active', true)
            ->whereNotIn('products.brand_id', $brand_p_id)
            ->select('categories.id', 'categories.name')
            ->distinct('categories.name')
            ->limit(5)
            ->get();

        $carts = Cart::where('user_ip', request()->ip())->where('session', $session)->latest()->get();
        $subtotal = Cart::all()->where('user_ip', request()->ip())->where('session', $session)->sum(function($t){
            return $t->product_price * $t->product_quantity;
        });


        $tags_product = ProductTag::join('products', 'product_tags.product_id', '=', 'products.id')
            ->where('product_tags.tag_id',$id)
            ->whereNotIn('products.category_id', $cat_p_id)
            ->whereNotIn('products.brand_id', $brand_p_id)
            ->where('products.is_active', true)
            ->select('products.*')
            ->get();



        $products = Product::where('is_active', true)
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get();
        $next_products = Product::where('is_active', true)
            ->orderBy('id', 'DESC')
            ->skip(3)
            ->take(3)
            ->get();
        return view('eshop.routine_skin_care', compact('product_details_info','quick_view','brands','categories', 'carts', 'subtotal', 'tags_product', 'products', 'next_products', 'category_name'));
    }

    public function tagwise_product_name($id , $name)
    {
        //dd($id);
        $session = \Session::getId();
        $product_details_info = null;
        $quick_view = null ;

        $cat_parent_id = Category::where('name','=','Sample')->first()->id;
        $catgory_parent = Category::where('parent_id', $cat_parent_id)->get();

        foreach ($catgory_parent as $row){
            $cat_p_id[] = $row->id;
        }


        $brand_parent_id = Brand::where('title','=','Invisible')->first()->id;
        $brand_parent = Brand::where('parent_id', $brand_parent_id)->get();

        foreach ($brand_parent as $row){
            $brand_p_id[] = $row->id;
        }


        $brands     = Brand::orderBy('title', 'ASC')->where('is_active', true)->where('title','!=','OTHERS')->where('parent_id', NULL)->get();

        $category_name = Tags::where('id', $id)->first();
        //  $category_name = Category::where('id', $id)->first();

        $categories = Category::orderBy('categories.id', 'DESC')
            ->join('products', 'products.category_id', '=', 'categories.id')
            ->where('categories.is_active', true)
            ->where('categories.parent_id', null)
            ->where('products.is_active', true)
            ->whereNotIn('products.brand_id', $brand_p_id)
            ->select('categories.id', 'categories.name')
            ->distinct('categories.name')
            ->limit(5)
            ->get();

        $carts = Cart::where('user_ip', request()->ip())->where('session', $session)->latest()->get();
        $subtotal = Cart::all()->where('user_ip', request()->ip())->where('session', $session)->sum(function($t){
            return $t->product_price * $t->product_quantity;
        });


        $tags_product = ProductTag::join('products', 'product_tags.product_id', '=', 'products.id')
            ->where('product_tags.tag_id',$id)
            ->whereNotIn('products.category_id', $cat_p_id)
            ->whereNotIn('products.brand_id', $brand_p_id)
            ->where('products.is_active', true)
            ->select('products.*')
            ->get();



        $products = Product::where('is_active', true)
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get();
        $next_products = Product::where('is_active', true)
            ->orderBy('id', 'DESC')
            ->skip(3)
            ->take(3)
            ->get();
        return view('eshop.routine_skin_care', compact('product_details_info','quick_view','brands','categories', 'carts', 'subtotal', 'tags_product', 'products', 'next_products', 'category_name'));
    }

















    // Category Product
    public function category_product_quick(Request $request,$id)
    {
        $session = \Session::getId();
            $product_details_info  = Product::orderBy('id', 'DESC')
                ->join('brands', 'brands.id', '=', 'products.brand_id')
                ->where('products.id', '=', $id)
                ->where('products.is_active', true)
                ->select('products.*')
                ->first();
            $quick_view = 9 ;




        $cat_parent_id = Category::where('name','=','Sample')->first()->id;
        $catgory_parent = Category::where('parent_id', $cat_parent_id)->get();

        foreach ($catgory_parent as $row){
            $cat_p_id[] = $row->id;
        }

        $brand_parent_id = Brand::where('title','=','Invisible')->first()->id;
        $brand_parent = Brand::where('parent_id', $brand_parent_id)->get();

        foreach ($brand_parent as $row){
            $brand_p_id[] = $row->id;
        }


        $brands     = Brand::orderBy('title', 'ASC')->where('is_active', true)->where('title','!=','OTHERS')->where('parent_id', NULL)->get();

        $category_name = Category::where('id', $request->catg_id)->first();
        //  $category_name = Category::where('id', $id)->first();

        $categories = Category::orderBy('categories.id', 'DESC')
            ->join('products', 'products.category_id', '=', 'categories.id')
            ->where('categories.is_active', true)
            ->where('categories.parent_id', null)
            ->where('products.is_active', true)
            ->whereNotIn('products.brand_id', $brand_p_id)
            ->select('categories.id', 'categories.name')
            ->distinct('categories.name')
            ->limit(5)
            ->get();

        $carts = Cart::where('user_ip', request()->ip())->where('session', $session)->latest()->get();
        $subtotal = Cart::all()->where('user_ip', request()->ip())->where('session', $session)->sum(function($t){
            return $t->product_price * $t->product_quantity;
        });
        $categories_product = Product::orderBy('id', 'DESC')
            ->where('is_active', true)
            ->where('category_id', $request->catg_id)
            ->whereNotIn('category_id', $cat_p_id)
            ->whereNotIn('brand_id', $brand_p_id)
            ->get();

        $products = Product::where('is_active', true)
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get();
        $next_products = Product::where('is_active', true)
            ->orderBy('id', 'DESC')
            ->skip(3)
            ->take(3)
            ->get();
        return view('eshop.category_product', compact('quick_view','product_details_info','brands','categories', 'carts', 'subtotal', 'categories_product', 'products', 'next_products', 'category_name'));

    }



    // Category Product
    public function category_product_hair_scalp($id)
    {
        $session = \Session::getId();
        $product_details_info = null;
        $quick_view = null ;

        $cat_parent_id = Category::where('name','=','Sample')->first()->id;
        $catgory_parent = Category::where('parent_id', $cat_parent_id)->get();

        foreach ($catgory_parent as $row){
            $cat_p_id[] = $row->id;
        }


        $brand_parent_id = Brand::where('title','=','Invisible')->first()->id;
        $brand_parent = Brand::where('parent_id', $brand_parent_id)->get();

        foreach ($brand_parent as $row){
            $brand_p_id[] = $row->id;
        }


        $brands     = Brand::orderBy('title', 'ASC')->where('is_active', true)->where('title','!=','OTHERS')->where('parent_id', NULL)->get();

        $category_name = Category::where('id', $id)->first();
        //  $category_name = Category::where('id', $id)->first();

        $categories = Category::orderBy('categories.id', 'DESC')
            ->join('products', 'products.category_id', '=', 'categories.id')
            ->where('categories.is_active', true)
            ->where('categories.parent_id', null)
            ->where('products.is_active', true)
            ->whereNotIn('products.brand_id', $brand_p_id)
            ->select('categories.id', 'categories.name')
            ->distinct('categories.name')
            ->limit(5)
            ->get();

        $carts = Cart::where('user_ip', request()->ip())->where('session', $session)->latest()->get();
        $subtotal = Cart::all()->where('user_ip', request()->ip())->where('session', $session)->sum(function($t){
            return $t->product_price * $t->product_quantity;
        });
        $categories_product = Product::orderBy('id', 'DESC')
            ->where('is_active', true)
            ->where('category_id', $id)
            ->whereNotIn('category_id', $cat_p_id)
            ->whereNotIn('brand_id', $brand_p_id)
            ->get();

        $products = Product::where('is_active', true)
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get();
        $next_products = Product::where('is_active', true)
            ->orderBy('id', 'DESC')
            ->skip(3)
            ->take(3)
            ->get();
        return view('eshop.category_hair_scalp_product', compact('product_details_info','quick_view','brands','categories', 'carts', 'subtotal', 'categories_product', 'products', 'next_products', 'category_name'));

    }


    public function category_product_name_hair_scalp($id ,$name)
    {
        $session = \Session::getId();
        $product_details_info = null;
        $quick_view = null ;

        $cat_parent_id = Category::where('name','=','Sample')->first()->id;
        $catgory_parent = Category::where('parent_id', $cat_parent_id)->get();

        foreach ($catgory_parent as $row){
            $cat_p_id[] = $row->id;
        }


        $brand_parent_id = Brand::where('title','=','Invisible')->first()->id;
        $brand_parent = Brand::where('parent_id', $brand_parent_id)->get();

        foreach ($brand_parent as $row){
            $brand_p_id[] = $row->id;
        }


        $brands     = Brand::orderBy('title', 'ASC')->where('is_active', true)->where('title','!=','OTHERS')->where('parent_id', NULL)->get();

        $category_name = Category::where('id', $id)->first();
        //  $category_name = Category::where('id', $id)->first();

        $categories = Category::orderBy('categories.id', 'DESC')
            ->join('products', 'products.category_id', '=', 'categories.id')
            ->where('categories.is_active', true)
            ->where('categories.parent_id', null)
            ->where('products.is_active', true)
            ->whereNotIn('products.brand_id', $brand_p_id)
            ->select('categories.id', 'categories.name')
            ->distinct('categories.name')
            ->limit(5)
            ->get();

        $carts = Cart::where('user_ip', request()->ip())->where('session', $session)->latest()->get();
        $subtotal = Cart::all()->where('user_ip', request()->ip())->where('session', $session)->sum(function($t){
            return $t->product_price * $t->product_quantity;
        });
        $categories_product = Product::orderBy('id', 'DESC')
            ->where('is_active', true)
            ->where('category_id', $id)
            ->whereNotIn('category_id', $cat_p_id)
            ->whereNotIn('brand_id', $brand_p_id)
            ->get();

        $products = Product::where('is_active', true)
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get();
        $next_products = Product::where('is_active', true)
            ->orderBy('id', 'DESC')
            ->skip(3)
            ->take(3)
            ->get();
        return view('eshop.category_hair_scalp_product', compact('product_details_info','quick_view','brands','categories', 'carts', 'subtotal', 'categories_product', 'products', 'next_products', 'category_name'));

    }



    // Category Product
    public function category_hair_scalp_product_quick(Request $request,$id)
    {
        $session = \Session::getId();
        $product_details_info  = Product::orderBy('id', 'DESC')
            ->join('brands', 'brands.id', '=', 'products.brand_id')
            ->where('products.id', '=', $id)
            ->where('products.is_active', true)
            ->select('products.*')
            ->first();
        $quick_view = 9 ;


        $brand_parent_id = Brand::where('title','=','Invisible')->first()->id;
        $brand_parent = Brand::where('parent_id', $brand_parent_id)->get();

        foreach ($brand_parent as $row){
            $brand_p_id[] = $row->id;
        }

        $cat_parent_id = Category::where('name','=','Sample')->first()->id;
        $catgory_parent = Category::where('parent_id', $cat_parent_id)->get();

        foreach ($catgory_parent as $row){
            $cat_p_id[] = $row->id;
        }


        $brands     = Brand::orderBy('title', 'ASC')->where('is_active', true)->where('title','!=','OTHERS')->where('parent_id', NULL)->get();

        $category_name = Category::where('id', $request->catg_id)->first();
        //  $category_name = Category::where('id', $id)->first();

        $categories = Category::orderBy('categories.id', 'DESC')
            ->join('products', 'products.category_id', '=', 'categories.id')
            ->where('categories.is_active', true)
            ->where('categories.parent_id', null)
            ->where('products.is_active', true)
            ->whereNotIn('products.brand_id', $brand_p_id)
            ->select('categories.id', 'categories.name')
            ->distinct('categories.name')
            ->limit(5)
            ->get();

        $carts = Cart::where('user_ip', request()->ip())->where('session', $session)->latest()->get();
        $subtotal = Cart::all()->where('user_ip', request()->ip())->where('session', $session)->sum(function($t){
            return $t->product_price * $t->product_quantity;
        });
        $categories_product = Product::orderBy('id', 'DESC')
            ->where('is_active', true)
            ->where('category_id', $request->catg_id)
            ->whereNotIn('products.category_id', $cat_p_id)
            ->whereNotIn('products.brand_id', $brand_p_id)
            ->get();

        $products = Product::where('is_active', true)
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get();
        $next_products = Product::where('is_active', true)
            ->orderBy('id', 'DESC')
            ->skip(3)
            ->take(3)
            ->get();
        return view('eshop.category_hair_scalp_product', compact('quick_view','product_details_info','brands','categories', 'carts', 'subtotal', 'categories_product', 'products', 'next_products', 'category_name'));

    }






    //brands product
    public function brands_product($id)
    {
        $session = \Session::getId();
        $product_details_info = null;
        $quick_view = null ;


        $cat_parent_id = Category::where('name','=','Sample')->first()->id;
        $catgory_parent = Category::where('parent_id', $cat_parent_id)->get();

        foreach ($catgory_parent as $row){
            $cat_p_id[] = $row->id;
        }

        $brand_parent_id = Brand::where('title','=','Invisible')->first()->id;
        $brand_parent = Brand::where('parent_id', $brand_parent_id)->get();

        foreach ($brand_parent as $row){
            $brand_p_id[] = $row->id;
        }


        $brands     = Brand::orderBy('title', 'ASC')->where('is_active', true)->where('title','!=','OTHERS')->where('parent_id', NULL)->get();

        $brand_name = Brand::where('id', $id)->first();

        $categories = Category::orderBy('categories.id', 'DESC')
            ->join('products', 'products.category_id', '=', 'categories.id')
            ->where('categories.is_active', true)
            ->where('categories.parent_id', null)
            ->where('products.is_active', true)
            ->whereNotIn('products.brand_id', $brand_p_id)
            ->select('categories.id', 'categories.name')
            ->distinct('categories.name')
            ->limit(5)
            ->get();

        $carts = Cart::where('user_ip', request()->ip())->where('session', $session)->latest()->get();
        $subtotal = Cart::all()->where('user_ip', request()->ip())->where('session', $session)->sum(function($t){
            return $t->product_price * $t->product_quantity;
        });
        $brands_product = Product::orderBy('id', 'DESC')
            ->where('is_active', true)
            ->where('brand_id', $id)
            ->whereNotIn('products.category_id', $cat_p_id)
            ->whereNotIn('products.brand_id', $brand_p_id)
            ->get();
        //  dd($brands_product);
        $products = Product::where('is_active', true)
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get();
        $next_products = Product::where('is_active', true)
            ->orderBy('id', 'DESC')
            ->skip(3)
            ->take(3)
            ->get();
        return view('eshop.brands_product', compact('product_details_info','quick_view','brands','categories', 'carts', 'subtotal', 'brands_product', 'products', 'next_products', 'brand_name'));

    }




    //brands product
    public function brands_product_name($id , $name)
    {
        $session = \Session::getId();
        $product_details_info = null;
        $quick_view = null ;


        $cat_parent_id = Category::where('name','=','Sample')->first()->id;
        $catgory_parent = Category::where('parent_id', $cat_parent_id)->get();

        foreach ($catgory_parent as $row){
            $cat_p_id[] = $row->id;
        }

        $brand_parent_id = Brand::where('title','=','Invisible')->first()->id;
        $brand_parent = Brand::where('parent_id', $brand_parent_id)->get();

        foreach ($brand_parent as $row){
            $brand_p_id[] = $row->id;
        }


        $brands     = Brand::orderBy('title', 'ASC')->where('is_active', true)->where('title','!=','OTHERS')->where('parent_id', NULL)->get();

        $brand_name = Brand::where('id', $id)->first();

        $categories = Category::orderBy('categories.id', 'DESC')
            ->join('products', 'products.category_id', '=', 'categories.id')
            ->where('categories.is_active', true)
            ->where('categories.parent_id', null)
            ->where('products.is_active', true)
            ->whereNotIn('products.brand_id', $brand_p_id)
            ->select('categories.id', 'categories.name')
            ->distinct('categories.name')
            ->limit(5)
            ->get();

        $carts = Cart::where('user_ip', request()->ip())->where('session', $session)->latest()->get();
        $subtotal = Cart::all()->where('user_ip', request()->ip())->where('session', $session)->sum(function($t){
            return $t->product_price * $t->product_quantity;
        });
        $brands_product = Product::orderBy('id', 'DESC')
            ->where('is_active', true)
            ->where('brand_id', $id)
            ->whereNotIn('products.category_id', $cat_p_id)
            ->whereNotIn('products.brand_id', $brand_p_id)
            ->get();
        //  dd($brands_product);
        $products = Product::where('is_active', true)
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get();
        $next_products = Product::where('is_active', true)
            ->orderBy('id', 'DESC')
            ->skip(3)
            ->take(3)
            ->get();
        return view('eshop.brands_product', compact('product_details_info','quick_view','brands','categories', 'carts', 'subtotal', 'brands_product', 'products', 'next_products', 'brand_name'));

    }



    //brands product
    public function brands_product_quick(Request $request)
    {
        $session = \Session::getId();
        //  dd($request->all());
        $id = $request->brand_id;
        if ($request->quick_id == null) {

            $product_details_info = null;
            $quick_view = null ;
        }else{
            $product_details_info  = Product::orderBy('id', 'DESC')
                ->join('brands', 'brands.id', '=', 'products.brand_id')
                ->where('products.id', '=', $request->quick_id)
                ->where('products.is_active', true)
                ->select('products.*')
                ->first();
            $quick_view = 9 ;

        }


        $cat_parent_id = Category::where('name','=','Sample')->first()->id;
        $catgory_parent = Category::where('parent_id', $cat_parent_id)->get();

        foreach ($catgory_parent as $row){
            $cat_p_id[] = $row->id;
        }


        $brand_parent_id = Brand::where('title','=','Invisible')->first()->id;
        $brand_parent = Brand::where('parent_id', $brand_parent_id)->get();

        foreach ($brand_parent as $row){
            $brand_p_id[] = $row->id;
        }


        $brands     = Brand::orderBy('title', 'ASC')->where('is_active', true)->get();

        $brand_name = Brand::where('id', $id)->first();

        $categories = Category::orderBy('categories.id', 'DESC')
            ->join('products', 'products.category_id', '=', 'categories.id')
            ->where('categories.is_active', true)
            ->where('categories.parent_id', null)
            ->where('products.is_active', true)
            ->whereNotIn('products.brand_id', $brand_p_id)
            ->select('categories.id', 'categories.name')
            ->distinct('categories.name')
            ->limit(5)
            ->get();

        $carts = Cart::where('user_ip', request()->ip())->where('session', $session)->latest()->get();
        $subtotal = Cart::all()->where('user_ip', request()->ip())->where('session', $session)->sum(function($t){
            return $t->product_price * $t->product_quantity;
        });
        $brands_product = Product::orderBy('id', 'DESC')
            ->where('is_active', true)
            ->where('brand_id', $id)
            ->whereNotIn('products.category_id', $cat_p_id)
            ->whereNotIn('products.brand_id', $brand_p_id)
            ->get();
        //  dd($brands_product);
        $products = Product::where('is_active', true)
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get();
        $next_products = Product::where('is_active', true)
            ->orderBy('id', 'DESC')
            ->skip(3)
            ->take(3)
            ->get();
        return view('eshop.brands_product', compact('product_details_info','quick_view','brands','categories', 'carts', 'subtotal', 'brands_product', 'products', 'next_products', 'brand_name'));

    }


    //Other brands product
    public function brands_product_other()
    {

        $session = \Session::getId();
        $product_details_info = null;
        $quick_view = null ;


        $id=3;
        $cat_parent_id = Category::where('name','=','Sample')->first()->id;
        $catgory_parent = Category::where('parent_id', $cat_parent_id)->get();

        foreach ($catgory_parent as $row){
            $cat_p_id[] = $row->id;
        }


        $brand_parent_id = Brand::where('title','=','Invisible')->first()->id;
        $brand_parent = Brand::where('parent_id', $brand_parent_id)->get();

        foreach ($brand_parent as $row){
            $brand_p_id[] = $row->id;
        }


        $brands     = Brand::orderBy('title', 'ASC')->where('is_active', true)->where('title','!=','OTHERS')->where('parent_id', NULL)->get();

        $brand_name = Brand::where('title','OTHERS' )->first();

        $categories = Category::orderBy('categories.id', 'DESC')
            ->join('products', 'products.category_id', '=', 'categories.id')
            ->where('categories.is_active', true)
            ->where('categories.parent_id', null)
            ->where('products.is_active', true)
            ->whereNotIn('products.brand_id', $brand_p_id)
            ->select('categories.id', 'categories.name')
            ->distinct('categories.name')
            ->limit(5)
            ->get();

        $carts = Cart::where('user_ip', request()->ip())->where('session', $session)->latest()->get();
        $subtotal = Cart::all()->where('user_ip', request()->ip())->where('session', $session)->sum(function($t){
            return $t->product_price * $t->product_quantity;
        });
        $brands_product = Product::orderBy('products.id', 'DESC')
                        ->join('brands','brands.id', 'products.brand_id')
                        ->where('brands.parent_id','=', '43')
                        ->where('products.is_active', true)
                        ->whereNotIn('products.brand_id', $brand_p_id)
                        ->select('products.*','brands.*','products.image AS pimage', 'products.id AS pid')
                       // ->where('brand_id', $id)
                        ->whereNotIn('products.category_id', $cat_p_id)
            ->get();
         // dd($brands_product);
        $products = Product::where('is_active', true)
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get();
        $next_products = Product::where('is_active', true)
            ->orderBy('id', 'DESC')
            ->skip(3)
            ->take(3)
            ->get();
        return view('eshop.brands_product_other', compact('quick_view','product_details_info','brands','categories', 'carts', 'subtotal', 'brands_product', 'products', 'next_products', 'brand_name'));

    }

    //Other brands product
    public function brands_product_other_quick(Request $request)
    {
        $session = \Session::getId();
        if ($request->quick_id == null) {

            $product_details_info = null;
            $quick_view = null ;
        }else{
            $product_details_info  = Product::orderBy('id', 'DESC')
                ->join('brands', 'brands.id', '=', 'products.brand_id')
                ->where('products.id', '=', $request->quick_id)
                ->where('products.is_active', true)
                ->select('products.*')
                ->first();
            $quick_view = 9 ;

        }


        $id=3;
        $cat_parent_id = Category::where('name','=','Sample')->first()->id;
        $catgory_parent = Category::where('parent_id', $cat_parent_id)->get();

        foreach ($catgory_parent as $row){
            $cat_p_id[] = $row->id;
        }

        $brand_parent_id = Brand::where('title','=','Invisible')->first()->id;
        $brand_parent = Brand::where('parent_id', $brand_parent_id)->get();

        foreach ($brand_parent as $row){
            $brand_p_id[] = $row->id;
        }


        $brands     = Brand::orderBy('title', 'ASC')->where('is_active', true)->where('title','!=','OTHERS')->where('parent_id', NULL)->get();

        $brand_name = Brand::where('id', $id)->first();

        $categories = Category::orderBy('categories.id', 'DESC')
            ->join('products', 'products.category_id', '=', 'categories.id')
            ->where('categories.is_active', true)
            ->where('categories.parent_id', null)
            ->where('products.is_active', true)
            ->whereNotIn('products.brand_id', $brand_p_id)
            ->select('categories.id', 'categories.name')
            ->distinct('categories.name')
            ->limit(5)
            ->get();

        $carts = Cart::where('user_ip', request()->ip())->where('session', $session)->latest()->get();
        $subtotal = Cart::all()->where('user_ip', request()->ip())->where('session', $session)->sum(function($t){
            return $t->product_price * $t->product_quantity;
        });
        $brands_product = Product::orderBy('products.id', 'DESC')
            ->join('brands','brands.id', 'products.brand_id')
            ->where('brands.parent_id','=', '43')
            ->where('products.is_active', true)
            ->whereNotIn('products.brand_id', $brand_p_id)
            ->select('products.*','brands.*','products.image AS pimage', 'products.id AS pid')
            // ->where('brand_id', $id)
            // ->whereNotIn('products.category_id', $cat_p_id)
            ->get();
        // dd($brands_product);
        $products = Product::where('is_active', true)
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get();
        $next_products = Product::where('is_active', true)
            ->orderBy('id', 'DESC')
            ->skip(3)
            ->take(3)
            ->get();
        return view('eshop.brands_product_other', compact('quick_view','product_details_info','brands','categories', 'carts', 'subtotal', 'brands_product', 'products', 'next_products', 'brand_name'));

    }






    //detail page view
    public function detail($id)
    {
        $session = \Session::getId();
        $product_details_info = null;
        $quick_view = null ;

        $cat_parent_id = Category::where('name','=','Sample')->first()->id;
        $catgory_parent = Category::where('parent_id', $cat_parent_id)->get();

        foreach ($catgory_parent as $row){
            $cat_p_id[] = $row->id;
        }

        $brand_parent_id = Brand::where('title','=','Invisible')->first()->id;
        $brand_parent = Brand::where('parent_id', $brand_parent_id)->get();

        foreach ($brand_parent as $row){
            $brand_p_id[] = $row->id;
        }


        $brands     = Brand::orderBy('title', 'ASC')->where('is_active', true)->where('title','!=','OTHERS')->where('parent_id', NULL)->get();
        $products   = Product::orderBy('id', 'DESC')
            ->whereNotIn('category_id', $cat_p_id)
            ->whereNotIn('brand_id', $brand_p_id)
            ->where('is_active', true)
            ->limit(3)->get();
        $categories = Category::orderBy('categories.id', 'DESC')
            ->join('products', 'products.category_id', '=', 'categories.id')
            ->where('categories.is_active', true)
            ->where('categories.parent_id', null)
            ->where('products.is_active', true)
            ->whereNotIn('products.brand_id', $brand_p_id)
            ->select('categories.id', 'categories.name')
            ->distinct('categories.name')
            ->limit(5)
            ->get();
        $carts = Cart::where('user_ip', request()->ip())->where('session', $session)->latest()->get();
        $subtotal = Cart::all()->where('user_ip', request()->ip())->where('session', $session)->sum(function($t){
            return $t->product_price * $t->product_quantity;
        });
        $product    = Product::orderBy('id', 'DESC')
            // ->join('brands', 'brands.id', '=', 'products.brand_id')
            ->where('id',$id)
            ->where('is_active', true)
            ->select('products.*')
            ->first();

        if ($product->brand_id != null){
            $all_products = Product::orderBy('id', 'DESC')
                ->where('is_active', true)
                ->where('brand_id', $product->brand_id)
                ->limit(10)
                ->get();
         //   dd($all_products);
        }else{
            $all_products = Product::orderBy('id', 'DESC')
                ->where('is_active', true)
                ->whereNotIn('category_id', $cat_p_id)
                ->whereNotIn('brand_id', $brand_p_id)
                ->limit(10)->get();
        }



        $next_products = Product::where('is_active', true)
            ->orderBy('id', 'DESC')
            ->skip(3)
            ->take(3)
            ->get();
        return view('eshop.detail', compact('quick_view','product_details_info','brands','categories', 'product', 'carts', 'subtotal', 'products', 'all_products', 'next_products'));
    }




    //detail page view
    public function details($id ,$name)
    {
        $session = \Session::getId();
        $product_details_info = null;
        $quick_view = null ;

        $cat_parent_id = Category::where('name','=','Sample')->first()->id;
        $catgory_parent = Category::where('parent_id', $cat_parent_id)->get();

        foreach ($catgory_parent as $row){
            $cat_p_id[] = $row->id;
        }

        $brand_parent_id = Brand::where('title','=','Invisible')->first()->id;
        $brand_parent = Brand::where('parent_id', $brand_parent_id)->get();

        foreach ($brand_parent as $row){
            $brand_p_id[] = $row->id;
        }


        $brands     = Brand::orderBy('title', 'ASC')->where('is_active', true)->where('title','!=','OTHERS')->where('parent_id', NULL)->get();
        $products   = Product::orderBy('id', 'DESC')
            ->whereNotIn('category_id', $cat_p_id)
            ->whereNotIn('brand_id', $brand_p_id)
            ->where('is_active', true)
            ->limit(3)->get();
        $categories = Category::orderBy('categories.id', 'DESC')
            ->join('products', 'products.category_id', '=', 'categories.id')
            ->where('categories.is_active', true)
            ->where('categories.parent_id', null)
            ->where('products.is_active', true)
            ->whereNotIn('products.brand_id', $brand_p_id)
            ->select('categories.id', 'categories.name')
            ->distinct('categories.name')
            ->limit(5)
            ->get();
        $carts = Cart::where('user_ip', request()->ip())->where('session', $session)->latest()->get();
        $subtotal = Cart::all()->where('user_ip', request()->ip())->where('session', $session)->sum(function($t){
            return $t->product_price * $t->product_quantity;
        });
        $product    = Product::orderBy('id', 'DESC')
            // ->join('brands', 'brands.id', '=', 'products.brand_id')
            ->where('id',$id)
            ->where('is_active', true)
            ->select('products.*')
            ->first();

        if ($product->brand_id != null){
            $all_products = Product::orderBy('id', 'DESC')
                ->where('is_active', true)
                ->where('brand_id', $product->brand_id)
                ->limit(10)
                ->get();
            //   dd($all_products);
        }else{
            $all_products = Product::orderBy('id', 'DESC')
                ->where('is_active', true)
                ->whereNotIn('category_id', $cat_p_id)
                ->whereNotIn('brand_id', $brand_p_id)
                ->limit(10)->get();
        }



        $next_products = Product::where('is_active', true)
            ->orderBy('id', 'DESC')
            ->skip(3)
            ->take(3)
            ->get();
        return view('eshop.detail', compact('quick_view','product_details_info','brands','categories', 'product', 'carts', 'subtotal', 'products', 'all_products', 'next_products'));
    }


    public function detail_name($name)
    {
        $id= Product::where('name',$name)->first()->id;
        $session = \Session::getId();
        $product_details_info = null;
        $quick_view = null ;

        $cat_parent_id = Category::where('name','=','Sample')->first()->id;
        $catgory_parent = Category::where('parent_id', $cat_parent_id)->get();

        foreach ($catgory_parent as $row){
            $cat_p_id[] = $row->id;
        }

        $brand_parent_id = Brand::where('title','=','Invisible')->first()->id;
        $brand_parent = Brand::where('parent_id', $brand_parent_id)->get();

        foreach ($brand_parent as $row){
            $brand_p_id[] = $row->id;
        }


        $brands     = Brand::orderBy('title', 'ASC')->where('is_active', true)->where('title','!=','OTHERS')->where('parent_id', NULL)->get();
        $products   = Product::orderBy('id', 'DESC')
            ->whereNotIn('category_id', $cat_p_id)
            ->whereNotIn('brand_id', $brand_p_id)
            ->where('is_active', true)
            ->limit(3)->get();
        $categories = Category::orderBy('categories.id', 'DESC')
            ->join('products', 'products.category_id', '=', 'categories.id')
            ->where('categories.is_active', true)
            ->where('categories.parent_id', null)
            ->where('products.is_active', true)
            ->whereNotIn('products.brand_id', $brand_p_id)
            ->select('categories.id', 'categories.name')
            ->distinct('categories.name')
            ->limit(5)
            ->get();
        $carts = Cart::where('user_ip', request()->ip())->where('session', $session)->latest()->get();
        $subtotal = Cart::all()->where('user_ip', request()->ip())->where('session', $session)->sum(function($t){
            return $t->product_price * $t->product_quantity;
        });
        $product    = Product::orderBy('id', 'DESC')
            // ->join('brands', 'brands.id', '=', 'products.brand_id')
            ->where('id',$id)
            ->where('is_active', true)
            ->select('products.*')
            ->first();

        if ($product->brand_id != null){
            $all_products = Product::orderBy('id', 'DESC')
                ->where('is_active', true)
                ->where('brand_id', $product->brand_id)
                ->limit(10)
                ->get();
            //   dd($all_products);
        }else{
            $all_products = Product::orderBy('id', 'DESC')
                ->where('is_active', true)
                ->whereNotIn('category_id', $cat_p_id)
                ->whereNotIn('brand_id', $brand_p_id)
                ->limit(10)->get();
        }



        $next_products = Product::where('is_active', true)
            ->orderBy('id', 'DESC')
            ->skip(3)
            ->take(3)
            ->get();
        return view('eshop.detail', compact('quick_view','product_details_info','brands','categories', 'product', 'carts', 'subtotal', 'products', 'all_products', 'next_products'));
    }






    //detail page view
    public function detail_quick(Request $request)
    {
        $session = \Session::getId();
        $id = $request->pro_id;

        if ($request->quick_id == null) {

            $product_details_info = null;
            $quick_view = null ;
        }else{
            $product_details_info  = Product::orderBy('id', 'DESC')
                ->join('brands', 'brands.id', '=', 'products.brand_id')
                ->where('products.id', '=', $request->quick_id)
                ->where('products.is_active', true)
                ->select('products.*')
                ->first();
            $quick_view = 9 ;

        }


        $cat_parent_id = Category::where('name','=','Sample')->first()->id;
        $catgory_parent = Category::where('parent_id', $cat_parent_id)->get();

        foreach ($catgory_parent as $row){
            $cat_p_id[] = $row->id;
        }


        $brand_parent_id = Brand::where('title','=','Invisible')->first()->id;
        $brand_parent = Brand::where('parent_id', $brand_parent_id)->get();

        foreach ($brand_parent as $row){
            $brand_p_id[] = $row->id;
        }


        $brands     = Brand::orderBy('title', 'ASC')->where('is_active', true)->where('title','!=','OTHERS')->where('parent_id', NULL)->get();
        $products   = Product::orderBy('id', 'DESC')
            ->whereNotIn('category_id', $cat_p_id)
            ->whereNotIn('brand_id', $brand_p_id)
            ->where('is_active', true)
            ->limit(3)->get();
        $categories = Category::orderBy('categories.id', 'DESC')
            ->join('products', 'products.category_id', '=', 'categories.id')
            ->where('categories.is_active', true)
            ->where('categories.parent_id', null)
            ->where('products.is_active', true)
            ->whereNotIn('products.brand_id', $brand_p_id)
            ->select('categories.id', 'categories.name')
            ->distinct('categories.name')
            ->limit(5)
            ->get();
        $carts = Cart::where('user_ip', request()->ip())->where('session', $session)->latest()->get();
        $subtotal = Cart::all()->where('user_ip', request()->ip())->where('session', $session)->sum(function($t){
            return $t->product_price * $t->product_quantity;
        });
        $product    = Product::orderBy('id', 'DESC')
            // ->join('brands', 'brands.id', '=', 'products.brand_id')
            ->where('id',$id)
            ->whereNotIn('products.brand_id', $brand_p_id)
            ->where('is_active', true)
            ->select('products.*')
            ->first();

        if ($product->brand_id != null){
            $all_products = Product::orderBy('id', 'DESC')
                ->where('is_active', true)
                ->where('brand_id', $product->brand_id)
                ->limit(10)
                ->get();
            //   dd($all_products);
        }else{
            $all_products = Product::orderBy('id', 'DESC')
                ->where('is_active', true)
                ->whereNotIn('category_id', $cat_p_id)
                ->whereNotIn('brand_id', $brand_p_id)
                ->limit(10)->get();
        }



        $next_products = Product::where('is_active', true)
            ->orderBy('id', 'DESC')
            ->skip(3)
            ->take(3)
            ->get();
        return view('eshop.detail', compact('quick_view','product_details_info','brands','categories', 'product', 'carts', 'subtotal', 'products', 'all_products', 'next_products'));
    }


    //add to cart
    public function add_to_cart(Request $request, $product_id)
    {

        $session = \Session::getId();
        $check = Cart::where('product_id', $product_id)->where('user_ip', request()->ip())->where('session',$session)->first();

        if($check)
        {
            Cart::where('product_id', $product_id)->increment('product_quantity');
            return back()->with('modal', 5);
        }
        else
        {
            if ($request->promotion_price == null){
                $price = $request->product_price;
            }else{
                $price = $request->promotion_price;
            }

            Cart::insert([
                'product_id'       => $product_id,
                'product_quantity' => 1,
                'product_price'    => $price,
                'user_ip'          => request()->ip(),
                'session'          => $session,
            ]);
            return back()->with('modal', 5);
        }

    }

    //add to cart
    public function add_to_cart_search(Request $request, $id)
    {

        $session = \Session::getId();
        $check = Cart::where('product_id', $id)->where('user_ip', request()->ip())->where('session',$session)->first();
        if($check)
        {
            Cart::where('product_id', $id)->increment('product_quantity');
            return back()->with('modal', 5);
        }
        else
        {
            if ($request->promotion_price == null){
                $price = $request->product_price;
            }else{
                $price = $request->promotion_price;
            }

            Cart::insert([
                'product_id'       => $id,
                'product_quantity' => 1,
                'product_price'    => $price,
                'user_ip'          => request()->ip(),
                'session'          => $session,
            ]);
            return back()->with('modal', 5);
        }

    }

    //add to cart from detail page with product quantity
    public function add_cart_quantity(Request $request, $product_id)
    {
        $session = \Session::getId();
        $check = Cart::where('product_id', $product_id)->where('user_ip', request()->ip())->where('session',$session)->first();

        if($check)
        {
            Cart::where('product_id', $product_id)->increment('product_quantity', $request->quantity);


            return back()->with('modal', 5);
        }
        else
        {

            if ($request->promotion_price == null){
                $price = $request->product_price;
            }else{
                $price = $request->promotion_price;
            }

            Cart::insert([
                'product_id'       => $product_id,
                'product_quantity' => $request->quantity,
                'product_price'    => $price,
                'user_ip'          => request()->ip(),
                'session'          => $session,
            ]);

            return back()->with('modal', 5);
        }

    }

    // view cart page
    public function cart_page()
    {
        $session = \Session::getId();
        $brands     = Brand::orderBy('title', 'ASC')->where('is_active', true)->where('title','!=','OTHERS')->where('parent_id', NULL)->get();
        $brand_parent_id = Brand::where('title','=','Invisible')->first()->id;
        $brand_parent = Brand::where('parent_id', $brand_parent_id)->get();
        foreach ($brand_parent as $row){
            $brand_p_id[] = $row->id;
        }

        $categories = Category::orderBy('categories.id', 'DESC')
            ->join('products', 'products.category_id', '=', 'categories.id')
            ->where('categories.is_active', true)
            ->where('categories.parent_id', null)
            ->where('products.is_active', true)
            ->whereNotIn('products.brand_id', $brand_p_id)
            ->select('categories.id', 'categories.name')
            ->distinct('categories.name')
            ->limit(5)
            ->get();

        $carts = Cart::where('user_ip', request()->ip())->where('session', $session)->latest()->get();
        $subtotal = Cart::all()->where('user_ip', request()->ip())->where('session', $session)->sum(function($t){
            return $t->product_price * $t->product_quantity;
        });
        $carts_row = $carts->count();
        if($carts_row > 0){
            return view('eshop.cart', compact('brands','categories', 'carts', 'subtotal'));

        }
        else{

            return view('eshop.cart', compact('brands','categories', 'carts', 'subtotal'))->with('clear_cart', 5);
            // echo "string";
        }

    }


    //quantity update in cart
    public function cart_quantity_update(Request $request, $id)
    {
        // return $request;exit();
        $session = \Session::getId();
        Cart::where('id', $id)->where('user_ip', request()->ip())->where('session', $session)->update([

            'product_quantity' => $request->product_quantity
        ]);

        return back()->with('qty_update', 5);
    }

    // cart delete page
    public function cart_destroy($id)
    {
        $session = \Session::getId();
        $carts = Cart::where('user_ip', request()->ip())->where('session', $session)->latest()->get();
        $carts_row = $carts->count();


        Cart::where('id', $id)->where('user_ip', request()->ip())->where('session', $session)->delete();

        if($carts_row > 0)
        {
            return back();
        }
        else{
            return redirect('/cart-page/')->with('clear', 4);
            // echo "string";
        }

    }


    // cart destroy from master blade
    public function cart_destroy_master($id)
    {
        $session = \Session::getId();
        $carts = Cart::where('user_ip', request()->ip())->where('session', $session)->latest()->get();
        $carts_row = $carts->count();


        Cart::where('id', $id)->where('user_ip', request()->ip())->where('session', $session)->delete();

        if($carts_row > 0)
        {
            return redirect('/cart-page/');
        }
        else{
            return redirect('/cart-page/')->with('clear', 4);
            // echo "string";
        }
    }
    //clear cart
    public function clear_cart()
    {
        $session = \Session::getId();
        Cart::where('user_ip', request()->ip())->where('session', $session)->delete();
        return redirect('/cart-page/')->with('clear_cart', 5);
    }
    //checkout page view
    public function checkout(Request $request ,$user_ip)
    {
        $session = \Session::getId();
        $brand_parent_id = Brand::where('title','=','Invisible')->first()->id;
        $brand_parent = Brand::where('parent_id', $brand_parent_id)->get();

        foreach ($brand_parent as $row){
            $brand_p_id[] = $row->id;
        }

        $shipping_cost = $request->shipping_cost;
        $warehouse_id = $request->warehouse_id;
        $warehouse_shipping_id = $request->warehouse_shipping;
        $hub_id = $request->hub_id;
        $pro_id = $request->pro_id;
        $sellItem = $request->sellItem;
        $ip = request()->ip();

        $brands     = Brand::orderBy('title', 'ASC')->where('is_active', true)->where('title','!=','OTHERS')->where('parent_id', NULL)->get();
        $categories = Category::orderBy('categories.id', 'DESC')
            ->join('products', 'products.category_id', '=', 'categories.id')
            ->where('categories.is_active', true)
            ->where('categories.parent_id', null)
            ->where('products.is_active', true)
            ->whereNotIn('products.brand_id', $brand_p_id)
            ->select('categories.id', 'categories.name')
            ->distinct('categories.name')
            ->limit(5)
            ->get();

        $carts = Cart::where('user_ip', request()->ip())->where('session', $session)->latest()->get();
       // dd($carts);

        $subtotal = Cart::all()->where('user_ip', request()->ip())->where('session', $session)->sum(function($t){
            return $t->product_price * $t->product_quantity;
        });
        $count = Cart::where('user_ip', '=', request()->ip())->where('session', $session)->count('id');
        return view('eshop.checkout', compact('ip','sellItem','pro_id','warehouse_shipping_id','hub_id','warehouse_id','brands','categories', 'carts', 'subtotal', 'count', 'shipping_cost'));
    }

    //checkout Check page view
    public function checkoutCheck(Request $request)
    {

        $session = \Session::getId();
        $carts = Cart::where('user_ip',$request->ip)->where('session', $session)->latest()->get();

        foreach ($carts as $val){
            $product_id[]= $val->product_id;
        }
        $product_info = Product_Warehouse::whereIn('product_id',$product_id)->where('warehouse_id',$request->w_id)->get();
        // dd($product_info);

        if (count($product_info) > 0 )
        {
            foreach ($product_info as $row){
                $other_pro_id[]= $row->product_id;
            }

            $leak_w_product = Cart::join('products', 'carts.product_id', '=', 'products.id')
                ->whereNotIn('carts.product_id',$other_pro_id)->where('carts.user_ip',$request->ip)->where('carts.session',$session)
                ->select('carts.*','products.name')
                ->latest()
                ->get();

            $leak_product_details = $leak_w_product;
            $leak_w_product = count($leak_w_product);
            return [$product_info, $leak_w_product ,$leak_product_details];
        }else{
            $product_info = 0 ;
            $leak_w_product = 0 ;
            $leak_product_details = 0 ;
            return [$product_info, $leak_w_product,$leak_product_details];
        }



    }

    public function shipping_cost(Request $request)
    {
        $s_cost = $request->s_cost;
        return $s_cost;
    }
    public function shipping_warwehouse(Request $request)
    {
        $w_id = $request->w_id;
        return $w_id;
    }

    public function get_area(Request $request)
    {
        $hub_id = $request->hub_id;
        $areas =  Area::where('hub_id',$hub_id)->get();
        return $areas;
    }

    public function cartOrderBooking(Request $request)
    {
        $product_info = Product_Warehouse::where('product_id',$request->pro_id)->where('warehouse_id',$request->w_id)->first();
        if ($product_info == null){
            $product_info = 0;
            return $product_info;
        }else{
            return $product_info;
        }


    }




//    // place order from checkout page
//    public function place_order(Request $request)
//    {
//        //dd($request->all());
//
//        $shipping_cost = $request->shipping_cost;
//        $warehouse_id = $request->warehouse_id;
//        $sellItem = $request->sellItem;
//
//        $carts  =   Cart::where('user_ip', $request->user_ip)->get();
////        foreach ($carts as $val){
////            $product_id[]= $val->product_id;
////            $product_quantity[]= $val->product_quantity;
////        }
////        $product_info = Product_Warehouse::whereIn('product_id',$product_id)->where('warehouse_id',$warehouse_id)->get();
////        if (count($product_info) > 0 )
////        {
////            foreach ($product_info as $row){
////                $other_pro_id[]= $row->product_id;
////            }
////            $leak_w_product = Cart::whereNotIn('product_id',$other_pro_id)->where('user_ip', $request->user_ip)->get();
////            //$leak_product_details = $leak_w_product;
////            //$leak_w_product = count($leak_w_product);
////        }
////
//////         foreach ($product_info as $row){
//////            $pro_info[] = Product_Warehouse::where('product_id',$row->product_id)->where('warehouse_id',$warehouse_id)->where('qty','>', $row->product_quantity )->first();
//////         }
//////        foreach ($pro_info as $result){
//////            if ($result == null) {
//////                $sellItem == null ;
//////            }else{
//////                $sellItem =  $result->qty;
//////        }
//////        dd($sellItem);
//
//        $pro_id = $request->pro_id;
//        $shipping_method = $request->shipping_method;
//      $request->validate([
//            'name'           => 'required',
//            'phone_number'   => 'required',
//            'address'        => 'required'
//
//        ]);
//        if ($shipping_method == null && $sellItem == null ) {
//            if(!Auth::user()) {
//                $check = User::where('email', $request->email)->first();
//                if ($check) {
//                    $auth_customer = Customer::orderBy('customers.id', 'DESC')
//                        ->join('users', 'users.id', '=', 'customers.user_id')
//                        ->where('customers.user_id', '=', $check->id)
//                        ->select('customers.id')
//                        ->first();
//                    $customer = Customer::find($auth_customer->id);
//                    $customer->name = $request->name;
//                    $customer->email = $request->email;
//                    $customer->phone_number = $request->phone_number;
//                    $customer->address = $request->address;
//                    $customer->city = $request->city;
//                    $customer->save();
//                    $count = Cart::where('user_ip', '=', request()->ip())->count('id');
//                    $quantity = Cart::where('user_ip', request()->ip())->sum('product_quantity');
//                    $subtotal = Cart::all()->where('user_ip', request()->ip())->sum(function ($t) {
//                        return $t->product_price * $t->product_quantity;
//                    });
//
//                    $quatation = new Quotation();
//                    $quatation->reference_no = 'qr-' . date("Ymd") . '-' . date("his");
//                    $quatation->user_id = $check->id;
//                    $quatation->customer_id = $auth_customer->id;
//                    $quatation->warehouse_id = $request->warehouse_id;
//                    $quatation->biller_id = 1;
//                    $quatation->item = $count;
//                    $quatation->total_qty = $quantity;
//                    $quatation->total_discount = 0;
//                    $quatation->total_tax = 0;
//                    $quatation->order_tax_rate = 0;
//                    $quatation->order_tax = 0;
//                    $quatation->order_discount = 0;
//                    $quatation->total_price = $subtotal;
//                    $quatation->grand_total = $subtotal + $request->shipping_cost;
//                    $quatation->shipping_cost = $request->shipping_cost;
//                    $quatation->quotation_status = 1;
//                    $quatation->save();
//
//                    //product sales add
//                    $cart_info = Cart::where('user_ip', $request->cart_ip)->get();
//                    $quatation = Quotation::orderBy('id', 'DESC')->first();
//                    foreach ($cart_info as $row) {
//                        $product_quatation = new ProductQuotation();
//                        $product_quatation->quotation_id = $quatation->id;
//                        $product_quatation->product_id = $row->product_id;
//                        $product_quatation->qty = $row->product_quantity;
//                        $product_quatation->sale_unit_id = 1;
//                        $product_quatation->net_unit_price = $row->product_price;
//                        $product_quatation->discount = 0;
//                        $product_quatation->tax_rate = 0;
//                        $product_quatation->tax = 0;
//                        $product_quatation->total = $row->product_price * $row->product_quantity;
//                        // $order->user_ip              = $row->user_ip;
//                        $product_quatation->save();
//                    }
//                    //cart delete
//                    Cart::where('user_ip', $request->user_ip)->delete();
//                    return redirect('/eshop/confirmation/');
//                } else {
//                    $name_without_space = str_replace(' ', '', $request->name);
//                    $user_name = substr($name_without_space, 0, 3);
//
//                    $rand_user_name = $user_name . rand(10, 100);
//                    //user add
//                    $user = new User;
//                    $user->name = $rand_user_name;
//                    $user->email = $request->email;
//                    $user->phone = $request->phone_number;
//                    $user->role_id = 5;
//                    $user->is_active = 1;
//                    $user->is_deleted = 0;
//                    $user->password = Hash::make('12345678');
//                    $user->save();
//
//                    $user_id = User::orderBy('id', 'DESC')->first();
//
//                    $customer = new Customer;
//                    $customer->customer_group_id = 1;
//                    $customer->name = $request->name;
//                    $customer->user_id = $user_id->id;
//                    $customer->email = $request->email;
//                    $customer->phone_number = $request->phone_number;
//                    $customer->address = $request->address;
//                    $customer->city = $request->city;
//                    $customer->is_active = 1;
//                    $customer->save();
//
//                    $customers = Customer::orderBy('id', 'DESC')->first();
//                    $count = Cart::where('user_ip', '=', request()->ip())->count('id');
//                    $quantity = Cart::where('user_ip', request()->ip())->sum('product_quantity');
//                    $subtotal = Cart::all()->where('user_ip', request()->ip())->sum(function ($t) {
//                        return $t->product_price * $t->product_quantity;
//                    });
//
//
//                    $quatation = new Quotation();
//                    $quatation->reference_no = 'qr-' . date("Ymd") . '-' . date("his");
//                    $quatation->user_id = $user_id->id;
//                    $quatation->customer_id = $customers->id;
//                    $quatation->warehouse_id = $request->warehouse_id;
//                    $quatation->biller_id = 1;
//                    $quatation->item = $count;
//                    $quatation->total_qty = $quantity;
//                    $quatation->total_discount = 0;
//                    $quatation->total_tax = 0;
//                    $quatation->order_tax_rate = 0;
//                    $quatation->order_tax = 0;
//                    $quatation->order_discount = 0;
//                    $quatation->total_price = $subtotal;
//                    $quatation->grand_total = $subtotal + $request->shipping_cost;
//                    $quatation->shipping_cost = $request->shipping_cost;
//                    $quatation->quotation_status = 1;
//                    $quatation->save();
//
//                    //product sales add
//                    $cart_info = Cart::where('user_ip', $request->cart_ip)->get();
//                    $quatation = Quotation::orderBy('id', 'DESC')->first();
//
//                    foreach ($cart_info as $row) {
//                        $product_quatation = new ProductQuotation();
//                        $product_quatation->quotation_id = $quatation->id;
//                        $product_quatation->product_id = $row->product_id;
//                        $product_quatation->qty = $row->product_quantity;
//                        $product_quatation->sale_unit_id = 1;
//                        $product_quatation->net_unit_price = $row->product_price;
//                        $product_quatation->discount = 0;
//                        $product_quatation->tax_rate = 0;
//                        $product_quatation->tax = 0;
//                        $product_quatation->total = $row->product_price * $row->product_quantity;
//                        // $order->user_ip              = $row->user_ip;
//                        $product_quatation->save();
//                    }
//                    //cart delete
//                    Cart::where('user_ip', $request->user_ip)->delete();
//                    return redirect('/eshop/confirmation/');
//                }
//
//            }
//
//
//
//
//            if(Auth::user()){
//                if(Auth::user()->role_id == 5){
//                    $auth_customer = Customer::orderBy('customers.id', 'DESC')
//                        ->join('users', 'users.id', '=', 'customers.user_id')
//                        ->where('customers.user_id', '=', Auth::user()->id)
//                        ->select('customers.id')
//                        ->first();
//
//                    $customer = Customer::find($auth_customer->id);
//
//                    $customer->name              = $request->name;
//                    $customer->user_id           =  Auth::user()->id;
//                    $customer->email             = $request->email;
//                    $customer->phone_number      = $request->phone_number;
//                    $customer->address           = $request->address;
//                    $customer->city              = $request->city;
//                    $customer->save();
//
//                    $count    = Cart::where('user_ip', '=', request()->ip())->count('id');
//                    $quantity = Cart::where('user_ip', request()->ip())->sum('product_quantity');
//
//                    $subtotal = Cart::all()->where('user_ip', request()->ip())->sum(function($t){
//                        return $t->product_price * $t->product_quantity;
//                    });
//
//                    $quatation = new Quotation();
//                    $quatation->reference_no = 'qr-' . date("Ymd") . '-' . date("his");
//                    $quatation->user_id = Auth::user()->id;
//                    $quatation->customer_id = $auth_customer->id;
//                    $quatation->warehouse_id = $request->warehouse_id;
//                    $quatation->biller_id = 1;
//                    $quatation->item = $count;
//                    $quatation->total_qty = $quantity;
//                    $quatation->total_discount = 0;
//                    $quatation->total_tax = 0;
//                    $quatation->order_tax_rate = 0;
//                    $quatation->order_tax = 0;
//                    $quatation->order_discount = 0;
//                    $quatation->total_price = $subtotal;
//                    $quatation->grand_total = $subtotal + $request->shipping_cost;
//                    $quatation->shipping_cost = $request->shipping_cost;
//                    $quatation->quotation_status = 1;
//                    $quatation->save();
//                }
//                elseif(Auth::user()->role_id != 5) {
//
//                    $customer = new Customer;
//                    $customer->customer_group_id = 1;
//                    $customer->name              = $request->name;
//                    $customer->user_id           =  Auth::user()->id;
//                    $customer->email             = $request->email;
//                    $customer->phone_number      = $request->phone_number;
//                    $customer->address           = $request->address;
//                    $customer->city              = $request->city;
//                    $customer->is_active         = 1;
//                    $customer->save();
//
//                    //sales add
//                    $customer = Customer::orderBy('id', 'DESC')->first();
//                    $count    = Cart::where('user_ip', '=', request()->ip())->count('id');
//                    $quantity = Cart::where('user_ip', request()->ip())->sum('product_quantity');
//                    $subtotal = Cart::all()->where('user_ip', request()->ip())->sum(function($t){
//                        return $t->product_price * $t->product_quantity;
//                    });
//
//
//
//                    $quatation = new Quotation();
//                    $quatation->reference_no = 'qr-' . date("Ymd") . '-' . date("his");
//                    $quatation->user_id = Auth::user()->id;
//                    $quatation->customer_id = $customer->id;
//                    $quatation->warehouse_id = $request->warehouse_id;
//                    $quatation->biller_id = 1;
//                    $quatation->item = $count;
//                    $quatation->total_qty = $quantity;
//                    $quatation->total_discount = 0;
//                    $quatation->total_tax = 0;
//                    $quatation->order_tax_rate = 0;
//                    $quatation->order_tax = 0;
//                    $quatation->order_discount = 0;
//                    $quatation->total_price = $subtotal;
//                    $quatation->grand_total = $subtotal + $request->shipping_cost;
//                    $quatation->shipping_cost = $request->shipping_cost;
//                    $quatation->quotation_status = 1;
//                    $quatation->save();
//                }
//
//
//                //product sales add
//                $cart_info = Cart::where('user_ip', $request->cart_ip)->get();
//                $quatation = Quotation::orderBy('id', 'DESC')->first();
//
//                foreach ($cart_info as $row) {
//                    $product_quatation = new ProductQuotation();
//                    $product_quatation->quotation_id = $quatation->id;
//                    $product_quatation->product_id = $row->product_id;
//                    $product_quatation->qty = $row->product_quantity;
//                    $product_quatation->sale_unit_id = 1;
//                    $product_quatation->net_unit_price = $row->product_price;
//                    $product_quatation->discount = 0;
//                    $product_quatation->tax_rate = 0;
//                    $product_quatation->tax = 0;
//                    $product_quatation->total = $row->product_price * $row->product_quantity;
//                    // $order->user_ip              = $row->user_ip;
//                    $product_quatation->save();
//                }
//                //cart delete
//                Cart::where('user_ip', $request->user_ip)->delete();
//                return redirect('/eshop/confirmation/');
//            }
//        }else{
//
//            if ( $shipping_cost == 0 && $warehouse_id > 0 ) {
//                $ware_id = $request->warehouse_id;
//            }else{
//                $ware_id = 2 ;
//            }
//            if(!Auth::user()){
//                $check = User::where('email', $request->email)->first();
//                if($check){
//                    $auth_customer = Customer::orderBy('customers.id', 'DESC')
//                        ->join('users', 'users.id', '=', 'customers.user_id')
//                        ->where('customers.user_id', '=', $check->id)
//                        ->select('customers.id')
//                        ->first();
//                    $customer = Customer::find($auth_customer->id);
//                    $customer->name              = $request->name;
//                    $customer->email             = $request->email;
//                    $customer->phone_number      = $request->phone_number;
//                    $customer->address           = $request->address;
//                    $customer->city              = $request->city;
//                    $customer->save();
//
//                    $count    = Cart::where('user_ip', '=', request()->ip())->count('id');
//                    $quantity = Cart::where('user_ip', request()->ip())->sum('product_quantity');
//                    $subtotal = Cart::all()->where('user_ip', request()->ip())->sum(function($t){
//                        return $t->product_price * $t->product_quantity;
//                    });
//
//                    $sale = new Sale;
//                    $sale->reference_no = 'ecom-' . date("Ymd") . '-'. date("his");
//                    $sale->user_id      = $check->id;
//                    $sale->customer_id  = $auth_customer->id;
//                    $sale->warehouse_id = $ware_id;
//                    $sale->hub_id = $request->hub_id;
//                    $sale->biller_id    = $ware_id;
//                    $sale->item         = $count;
//                    $sale->total_qty    = $quantity;
//                    $sale->total_discount    = 0;
//                    $sale->total_tax         = 0;
//                    $sale->total_price       = $subtotal;
//                    $sale->grand_total       = $subtotal + $request->shipping_cost;
//                    $sale->paid_amount       = 0 ;
//
//                    $sale->shipping_cost     = $request->shipping_cost;
//                    $sale->sale_status       = 2;
//                    $sale->payment_status    = 1 ;
//                    $sale->save();
//
//                    //product sales add
//                    $cart_info = Cart::where('user_ip', $request->cart_ip)->get();
//                    $sale = Sale::orderBy('id', 'DESC')->first();
//                    foreach($cart_info as $row){
//
//                        $product_sale = new Product_sale;
//                        $product_sale->sale_id          = $sale->id;
//                        $product_sale->product_id       = $row->product_id;
//                        $product_sale->qty              = $row->product_quantity;
//                        $product_sale->sale_unit_id     = 1;
//                        $product_sale->net_unit_price   = $row->product_price;
//                        $product_sale->discount         = 0;
//                        $product_sale->tax_rate         = 0;
//                        $product_sale->tax              = 0;
//                        $product_sale->total            = $row->product_price * $row->product_quantity;
//                        // $order->user_ip              = $row->user_ip;
//                        $product_sale->save();
//
//
//                    }
//
//
//                    $product_warehouse = Product_Warehouse::where('product_id',$pro_id)->where('warehouse_id',$ware_id)->first();
//                    $product_warehouse->qty  -= $quantity;
//                    $product_warehouse->save();
//
//                    $product = Product::where('id',$pro_id)->first();
//                    $product->qty  -= $quantity ;
//                    $product->save();
//
//
//
////                    $lims_payment_data = new Payment();
////                    $data['payment_reference'] = 'spr-' . date("Ymd") . '-'. date("his");
////                    $lims_payment_data->payment_reference = $data['payment_reference'];
////                    $lims_payment_data->user_id = $check->id;
////                    $lims_payment_data->sale_id = $sale->id;
////                    $lims_payment_data->cash_register_id = 1 ;
////                    $lims_payment_data->account_id = 1 ;
////                    $lims_payment_data->amount = $sale->grand_total;
////                    $lims_payment_data->change = 0 ;
////                    $lims_payment_data->paying_method = $request->shipping_method;
////                    $lims_payment_data->payment_note = $request->payment_note;
////                    $lims_payment_data->save();
//                    //cart delete
//                    Cart::where('user_ip', $request->user_ip)->delete();
//                    return redirect('/eshop/confirmation/');
//                }
//                else{
//
//
//                    $name_without_space = str_replace(' ', '', $request->name);
//                    $user_name = substr($name_without_space, 0, 3);
//
//                    $rand_user_name = $user_name.rand(10,100);
//                    //user add
//                    $user = new User;
//
//                    $user->name     = $rand_user_name;
//                    $user->email    = $request->email;
//                    $user->phone    = $request->phone_number;
//                    $user->role_id  = 5;
//                    $user->is_active  = 1;
//                    $user->is_deleted = 0;
//                    $user->password   = Hash::make('12345678');
//                    $user->save();
//                    $user_id = User::orderBy('id', 'DESC')->first();
//                    //customer add
//                    $customer = new Customer;
//                    $customer->customer_group_id = 1;
//                    $customer->user_id           = $user_id->id;
//                    $customer->name              = $request->name;
//                    //$customer->company_name      = $request->company_name;
//                    $customer->email             = $request->email;
//                    $customer->phone_number      = $request->phone_number;
//                    $customer->address           = $request->address;
//                    $customer->city              = $request->city;
//                    $customer->is_active         = 1;
//                    $customer->save();
//                    //sales add
//                    $customer = Customer::orderBy('id', 'DESC')->first();
//                    $count    = Cart::where('user_ip', '=', request()->ip())->count('id');
//                    $quantity = Cart::where('user_ip', request()->ip())->sum('product_quantity');
//
//                    $subtotal = Cart::all()->where('user_ip', request()->ip())->sum(function($t){
//                        return $t->product_price * $t->product_quantity;
//                    });
//                    $sale = new Sale;
//                    $sale->reference_no = 'ecom-' . date("Ymd") . '-'. date("his");
//                    $sale->user_id      = $user_id->id;
//                    $sale->customer_id  = $customer->id;
//                    $sale->warehouse_id = $ware_id;
//                    $sale->hub_id = $request->hub_id;
//                    $sale->biller_id    = $ware_id;
//                    $sale->item         = $count;
//                    $sale->total_qty    = $quantity;
//                    $sale->total_discount    = 0;
//                    $sale->total_tax         = 0;
//                    $sale->total_price       = $subtotal;
//                    $sale->grand_total       = $subtotal + $request->shipping_cost;
//                  //  $sale->paid_amount       = $subtotal + $request->shipping_cost;
//                    $sale->paid_amount       = 0 ;
//                    $sale->shipping_cost     = $request->shipping_cost;
//                    $sale->sale_status       = 2;
//                    $sale->payment_status    = 1;
//                    $sale->save();
//                    //product sales add
//                    $cart_info = Cart::where('user_ip', $request->cart_ip)->get();
//
//                    $sale = Sale::orderBy('id', 'DESC')->first();
//
//                    foreach($cart_info as $row){
//                        $product_sale = new Product_sale;
//                        $product_sale->sale_id          = $sale->id;
//                        $product_sale->product_id       = $row->product_id;
//                        $product_sale->qty              = $row->product_quantity;
//                        $product_sale->sale_unit_id     = 1;
//                        $product_sale->net_unit_price   = $row->product_price;
//                        $product_sale->discount         = 0;
//                        $product_sale->tax_rate         = 0;
//                        $product_sale->tax              = 0;
//                        $product_sale->total            = $row->product_price * $row->product_quantity;
//                        // $order->user_ip              = $row->user_ip;
//                        $product_sale->save();
//
//                    }
//
//                    $product_warehouse = Product_Warehouse::where('product_id',$pro_id)->where('warehouse_id',$ware_id)->first();
//                   // dd($product_warehouse);
//                    $product_warehouse->qty  -= $quantity;
//                    $product_warehouse->save();
//
//                    $product = Product::where('id',$pro_id)->first();
//                    $product->qty  -= $quantity ;
//                    $product->save();
//
////                    $lims_payment_data = new Payment();
////                    $data['payment_reference'] = 'spr-' . date("Ymd") . '-'. date("his");
////                    $lims_payment_data->payment_reference = $data['payment_reference'];
////                    $lims_payment_data->user_id = $user_id->id;
////                    $lims_payment_data->sale_id = $sale->id;
////                    $lims_payment_data->cash_register_id = 1 ;
////                    $lims_payment_data->account_id = 1 ;
////                    $lims_payment_data->amount = $sale->grand_total;
////                    $lims_payment_data->change = 0 ;
////                    $lims_payment_data->paying_method = $request->shipping_method;
////                    $lims_payment_data->payment_note = $request->payment_note;
////                    $lims_payment_data->save();
//                    //cart delete
//                    Cart::where('user_ip', $request->user_ip)->delete();
//                    return redirect('/eshop/confirmation/');
//
//                }
//
//            }
//
//
//            if(Auth::user()){
//                if(Auth::user()->role_id == 5){
//                    $auth_customer = Customer::orderBy('customers.id', 'DESC')
//                        ->join('users', 'users.id', '=', 'customers.user_id')
//                        ->where('customers.user_id', '=', Auth::user()->id)
//                        ->select('customers.id')
//                        ->first();
//                    // return $auth_customer; exit();
//                    $customer = Customer::find($auth_customer->id);
//
//                    $customer->name              = $request->name;
//                    $customer->user_id           =  Auth::user()->id;
//                    $customer->email             = $request->email;
//                    $customer->phone_number      = $request->phone_number;
//                    $customer->address           = $request->address;
//                    $customer->city              = $request->city;
//                    $customer->save();
//
//                    $count    = Cart::where('user_ip', '=', request()->ip())->count('id');
//                    $quantity = Cart::where('user_ip', request()->ip())->sum('product_quantity');
//
//                    $subtotal = Cart::all()->where('user_ip', request()->ip())->sum(function($t){
//                        return $t->product_price * $t->product_quantity;
//                    });
//
//                    $sale = new Sale;
//                    $sale->reference_no = 'ecom-' . date("Ymd") . '-'. date("his");
//                    $sale->user_id      = Auth::user()->id;
//                    $sale->customer_id  = $auth_customer->id;
//                    $sale->warehouse_id = $ware_id;
//                    $sale->hub_id = $request->hub_id;
//                    $sale->biller_id    = $ware_id;
//                    $sale->item         = $count;
//                    $sale->total_qty    = $quantity;
//                    $sale->total_discount    = 0;
//                    $sale->total_tax         = 0;
//                    $sale->total_price       = $subtotal;
//                    $sale->grand_total       = $subtotal + $request->shipping_cost;
//                   // $sale->paid_amount       = $subtotal + $request->shipping_cost;
//                    $sale->paid_amount       = 0 ;
//                    $sale->shipping_cost     = $request->shipping_cost;
//                    $sale->sale_status       = 2;
//                    $sale->payment_status    = 1;
//                    $sale->save();
//                }
//                elseif(Auth::user()->role_id != 5) {
//                    $customer = new Customer;
//                    $customer->customer_group_id = 1;
//                    $customer->name              = $request->name;
//                    $customer->user_id           =  Auth::user()->id;
//                    $customer->email             = $request->email;
//                    $customer->phone_number      = $request->phone_number;
//                    $customer->address           = $request->address;
//                    $customer->city              = $request->city;
//                    $customer->is_active         = 1;
//                    $customer->save();
//
//                    //sales add
//                    $customer = Customer::orderBy('id', 'DESC')->first();
//                    $count    = Cart::where('user_ip', '=', request()->ip())->count('id');
//                    $quantity = Cart::where('user_ip', request()->ip())->sum('product_quantity');
//                    $subtotal = Cart::all()->where('user_ip', request()->ip())->sum(function($t){
//                        return $t->product_price * $t->product_quantity;
//                    });
//                    $sale = new Sale;
//                    $sale->reference_no = 'ecom-' . date("Ymd") . '-'. date("his");
//                    $sale->user_id      = Auth::user()->id;
//                    $sale->customer_id  = $customer->id;
//                    $sale->warehouse_id = $ware_id;
//                    $sale->hub_id = $request->hub_id;
//                    $sale->biller_id    = $ware_id;
//                    $sale->item         = $count;
//                    $sale->total_qty    = $quantity;
//                    $sale->total_discount    = 0;
//                    $sale->total_tax         = 0;
//                    $sale->total_price       = $subtotal;
//                    $sale->grand_total       = $subtotal + $request->shipping_cost;
//                    $sale->paid_amount       = 0 ;
//                    $sale->shipping_cost     = $request->shipping_cost;
//                    $sale->sale_status       = 2;
//                    $sale->payment_status    = 1;
//                    // $sale->shipping_cost    = 2;
//                    $sale->save();
//                }
//
//                //product sales add
//
//                $count    = Cart::where('user_ip', '=', request()->ip())->count('id');
//                $quantity = Cart::where('user_ip', request()->ip())->sum('product_quantity');
//                $subtotal = Cart::all()->where('user_ip', request()->ip())->sum(function($t){
//                    return $t->product_price * $t->product_quantity;
//                });
//
//                $cart_info = Cart::where('user_ip', $request->cart_ip)->get();
//                $sale = Sale::orderBy('id', 'DESC')->first();
//                foreach($cart_info as $row){
//                    $product_sale = new Product_sale;
//                    $product_sale->sale_id          = $sale->id;
//                    $product_sale->product_id       = $row->product_id;
//                    $product_sale->qty              = $row->product_quantity;
//                    $product_sale->sale_unit_id     = 1;
//                    $product_sale->net_unit_price   = $row->product_price;
//                    $product_sale->discount         = 0;
//                    $product_sale->tax_rate         = 0;
//                    $product_sale->tax              = 0;
//                    $product_sale->total            = $row->product_price * $row->product_quantity;
//                    // $order->user_ip              = $row->user_ip;
//                    $product_sale->save();
//
//
//                }
//
//                $product_warehouse = Product_Warehouse::where('product_id',$pro_id)->where('warehouse_id',$ware_id)->first();
//                $product_warehouse->qty  -= $quantity;
//                $product_warehouse->save();
//
//                $product = Product::where('id',$pro_id)->first();
//                $product->qty  -= $quantity ;
//                $product->save();
//
////                $lims_payment_data = new Payment();
////                $data['payment_reference'] = 'spr-' . date("Ymd") . '-'. date("his");
////                $lims_payment_data->payment_reference = $data['payment_reference'];
////                $lims_payment_data->user_id = Auth::user()->id;
////                $lims_payment_data->sale_id = $sale->id;
////                $lims_payment_data->cash_register_id = 1 ;
////                $lims_payment_data->account_id = 1 ;
////                $lims_payment_data->amount = $sale->grand_total;
////                $lims_payment_data->change = 0 ;
////                $lims_payment_data->paying_method = $request->shipping_method;
////                $lims_payment_data->payment_note = $request->payment_note;
////                $lims_payment_data->save();
//                //cart delete
//                Cart::where('user_ip', $request->user_ip)->delete();
//                return redirect('/eshop/confirmation/');
//            }
//
//        }
//
//
//    }
//

    public function place_order(Request $request)
    {
        $session = \Session::getId();
        $payment_note = $request->payment_note;
        $payment_note = str_replace(["\r\n", "\r", "\n"], " , ", $payment_note);

        $shipping_cost = $request->shipping_cost;
        $warehouse_id = $request->warehouse_id;
        $sellItem = $request->sellItem;
        $carts  =   Cart::where('user_ip', $request->user_ip)->where('session', $session)->get();
        $pro_id = $request->pro_id;
        $shipping_method = $request->payment_method;

          $request->validate([
            'name'           => 'required',
            'phone_number'   => 'required',
            'address'        => 'required'

        ]);

        if ( $shipping_cost == 0 && $warehouse_id > 0 ) {
            $ware_id = $request->warehouse_id;
        }else{
            $ware_id = 6 ;
        }

        if(!Auth::user()) {
            $check = User::where('email', $request->email)->first();
            if ($check) {
                $auth_customer = Customer::orderBy('customers.id', 'DESC')
                    ->join('users', 'users.id', '=', 'customers.user_id')
                    ->where('customers.user_id', '=', $check->id)
                    ->select('customers.id')
                    ->first();
                if ($auth_customer != null){
                    $customer = Customer::find($auth_customer->id);
                    $customer->name = $request->name;
                    $customer->email = $request->email;
                    $customer->phone_number = $request->phone_number;
                    $customer->address = $request->address;
                    $customer->city = $request->city;
                    $customer->is_active = 1;
                    $customer->save();
                }else{
                    $customer = new Customer;
                    $customer->customer_group_id = 1;
                    $customer->name = $request->name;
                    $customer->user_id = $check->id;
                    $customer->email = $request->email;
                    $customer->phone_number = $request->phone_number;
                    $customer->address = $request->address;
                    $customer->city = $request->city;
                    $customer->is_active = 1;
                    $customer->save();
                }


                $customer = Customer::where('user_id',$check->id)->first();

               // dd($customer);


                $count = Cart::where('user_ip', '=', request()->ip())->where('session', $session)->count('id');
                $quantity = Cart::where('user_ip', request()->ip())->where('session', $session)->sum('product_quantity');
                $subtotal = Cart::all()->where('user_ip', request()->ip())->where('session', $session)->sum(function ($t) {
                    return $t->product_price * $t->product_quantity;
                });

                $quatation = new Quotation();
                $quatation->reference_no = 'ecom-qr-' . date("Ymd") . '-' . date("his");
                $quatation->user_id = $check->id;
                $quatation->customer_id = $customer->id;
                $quatation->warehouse_id =$ware_id;
                $quatation->biller_id = $ware_id;
                $quatation->item = $count;
                $quatation->total_qty = $quantity;
                $quatation->total_discount = 0;
                $quatation->total_tax = 0;
                $quatation->order_tax_rate = 0;
                $quatation->order_tax = 0;
                $quatation->order_discount = 0;
                $quatation->total_price = $subtotal;
                $quatation->grand_total = $subtotal + $request->shipping_cost;
                $quatation->shipping_cost = $request->shipping_cost;
                $quatation->quotation_status = 2;
                $quatation->note = $payment_note;
                $quatation->save();

                //product sales add
                $cart_info = Cart::where('user_ip', $request->cart_ip)->where('session', $session)->get();
                $quatation = Quotation::orderBy('id', 'DESC')->first();

                foreach ($cart_info as $row) {
                    $product_quatation = new ProductQuotation();
                    $product_quatation->quotation_id = $quatation->id;
                    $product_quatation->product_id = $row->product_id;
                    $product_quatation->qty = $row->product_quantity;
                    $product_quatation->sale_unit_id = 1;
                    $product_quatation->net_unit_price = $row->product_price;
                    $product_quatation->discount = 0;
                    $product_quatation->tax_rate = 0;
                    $product_quatation->tax = 0;
                    $product_quatation->total = $row->product_price * $row->product_quantity;
                    // $order->user_ip              = $row->user_ip;
                    $product_quatation->save();
                }
                $quatation = Quotation::orderBy('id', 'DESC')->first();
                $message = 'Your Order Successfully Done';
                if($request->email){
                    $mail_data['name'] = $request->name;
                    $mail_data['email'] = $request->email;
                    $mail_data['city'] = $request->city;
                    $mail_data['address'] = $request->address;
                    $mail_data['phone_number'] = $request->phone_number;
                    $mail_data['reference_no'] = $quatation->reference_no;
                    $mail_data['id'] = $quatation->id;
                    $mail_data['warehouse_id'] = $quatation->warehouse_id;
                    $mail_data['total_qty'] = $quatation->total_qty;
                    $mail_data['total_discount'] = $quatation->total_discount;
                    $mail_data['order_discount'] = $quatation->order_discount;
                    $mail_data['order_tax'] = $quatation->order_tax;
                    $mail_data['order_tax_rate'] = $quatation->order_tax_rate;
                    $mail_data['shipping_cost'] = $quatation->shipping_cost;
                    $mail_data['total_price'] = $quatation->total_price;
                    $mail_data['grand_total'] = $quatation->grand_total;
                    $mail_data['payment_method'] = $shipping_method;
                    $mail_data['payment_note'] = $payment_note;;
                    $mail_data['created_at'] = $quatation->created_at;
                    try{
                        Mail::send( 'mail.order_details', $mail_data, function( $message ) use ($mail_data)
                        {
                            $message->to( $mail_data['email'] )->subject( 'Kosmetica - Order Details' );
                        });
                    }
                    catch(\Exception $e){
                        $message = 'Payment updated successfully. Please setup your <a href="setting/mail_setting">mail setting</a> to send mail.';
                    }
                }
                //cart delete
                Cart::where('user_ip', $request->user_ip)->where('session', $session)->delete();
                //return redirect('confirmation')->with('message', $message);
                return View::make('eshop.confirmation')->with(compact('shipping_method','payment_note', 'message'));

            } else {
                $name_without_space = str_replace(' ', '', $request->name);
                $user_name = substr($name_without_space, 0, 3);

                $rand_user_name = $user_name . rand(10, 100);
                //user add
                $user = new User;
                $user->name = $rand_user_name;
                $user->email = $request->email;
                $user->phone = $request->phone_number;
                $user->role_id = 5;
                $user->is_active = 1;
                $user->is_deleted = 0;
                $user->password = Hash::make('12345678');
                $user->save();

                $user_id = User::orderBy('id', 'DESC')->first();

                $customer = new Customer;
                $customer->customer_group_id = 1;
                $customer->name = $request->name;
                $customer->user_id = $user_id->id;
                $customer->email = $request->email;
                $customer->phone_number = $request->phone_number;
                $customer->address = $request->address;
                $customer->city = $request->city;
                $customer->is_active = 1;
                $customer->save();

                $customers = Customer::orderBy('id', 'DESC')->first();
                $count = Cart::where('user_ip', '=', request()->ip())->where('session', $session)->count('id');
                $quantity = Cart::where('user_ip', request()->ip())->where('session', $session)->sum('product_quantity');
                $subtotal = Cart::all()->where('user_ip', request()->ip())->where('session', $session)->sum(function ($t) {
                    return $t->product_price * $t->product_quantity;
                });


                $quatation = new Quotation();
                $quatation->reference_no = 'ecom-qr-' . date("Ymd") . '-' . date("his");
                $quatation->user_id = $user_id->id;
                $quatation->customer_id = $customers->id;
                $quatation->warehouse_id = $ware_id;
                $quatation->biller_id = $ware_id;
                $quatation->item = $count;
                $quatation->total_qty = $quantity;
                $quatation->total_discount = 0;
                $quatation->total_tax = 0;
                $quatation->order_tax_rate = 0;
                $quatation->order_tax = 0;
                $quatation->order_discount = 0;
                $quatation->total_price = $subtotal;
                $quatation->grand_total = $subtotal + $request->shipping_cost;
                $quatation->shipping_cost = $request->shipping_cost;
                $quatation->quotation_status = 2;
                $quatation->note = $payment_note;
                $quatation->save();

                //product sales add
                $cart_info = Cart::where('user_ip', $request->cart_ip)->where('session', $session)->get();
                $quatation = Quotation::orderBy('id', 'DESC')->first();

                foreach ($cart_info as $row) {
                    $product_quatation = new ProductQuotation();
                    $product_quatation->quotation_id = $quatation->id;
                    $product_quatation->product_id = $row->product_id;
                    $product_quatation->qty = $row->product_quantity;
                    $product_quatation->sale_unit_id = 1;
                    $product_quatation->net_unit_price = $row->product_price;
                    $product_quatation->discount = 0;
                    $product_quatation->tax_rate = 0;
                    $product_quatation->tax = 0;
                    $product_quatation->total = $row->product_price * $row->product_quantity;
                    // $order->user_ip              = $row->user_ip;
                    $product_quatation->save();
                }

                $quatation = Quotation::orderBy('id', 'DESC')->first();
                $customer = Customer::orderBy('id', 'DESC')->first();
                $message = 'Your Order Successfully Done';
                if($customer->email){
                    $mail_data['name'] = $customer->name;
                    $mail_data['email'] = $customer->email;
                    $mail_data['city'] = $customer->city;
                    $mail_data['address'] = $customer->address;
                    $mail_data['phone_number'] = $customer->phone_number;
                    $mail_data['reference_no'] = $quatation->reference_no;
                    $mail_data['id'] = $quatation->id;
                    $mail_data['warehouse_id'] = $quatation->warehouse_id;
                    $mail_data['total_qty'] = $quatation->total_qty;
                    $mail_data['total_discount'] = $quatation->total_discount;
                    $mail_data['order_discount'] = $quatation->order_discount;
                    $mail_data['order_tax'] = $quatation->order_tax;
                    $mail_data['order_tax_rate'] = $quatation->order_tax_rate;
                    $mail_data['shipping_cost'] = $quatation->shipping_cost;
                    $mail_data['total_price'] = $quatation->total_price;
                    $mail_data['grand_total'] = $quatation->grand_total;
                    $mail_data['payment_method'] = $shipping_method;
                    $mail_data['payment_note'] = $payment_note;
                    $mail_data['created_at'] = $quatation->created_at;
                    try{
                        Mail::send( 'mail.order_details', $mail_data, function( $message ) use ($mail_data)
                        {
                            $message->to( $mail_data['email'] )->subject( 'Kosmetica - Order Details' );
                        });
                    }
                    catch(\Exception $e){
                        $message = 'Payment updated successfully. Please setup your <a href="setting/mail_setting">mail setting</a> to send mail.';
                    }
                }

                //cart delete
                Cart::where('user_ip', $request->user_ip)->where('session', $session)->delete();
               // return redirect('confirmation')->with('message', $message);
                return View::make('eshop.confirmation')->with(compact('shipping_method','payment_note', 'message'));
            }

        }




        if(Auth::user()){
            if(Auth::user()->role_id == 5){
                $auth_customer = Customer::orderBy('customers.id', 'DESC')
                    ->join('users', 'users.id', '=', 'customers.user_id')
                    ->where('customers.user_id', '=', Auth::user()->id)
                    ->select('customers.id')
                    ->first();
                $customer = Customer::find($auth_customer->id);
                $customer->name              = $request->name;
                $customer->user_id           =  Auth::user()->id;
                $customer->email             = $request->email;
                $customer->phone_number      = $request->phone_number;
                $customer->address           = $request->address;
                $customer->city              = $request->city;
                $customer->save();

                $count    = Cart::where('user_ip', '=', request()->ip())->where('session', $session)->count('id');
                $quantity = Cart::where('user_ip', request()->ip())->where('session', $session)->sum('product_quantity');

                $subtotal = Cart::all()->where('user_ip', request()->ip())->where('session', $session)->sum(function($t){
                    return $t->product_price * $t->product_quantity;
                });

                $quatation = new Quotation();
                $quatation->reference_no = 'ecom-qr-' . date("Ymd") . '-' . date("his");
                $quatation->user_id = Auth::user()->id;
                $quatation->customer_id = $auth_customer->id;
                $quatation->warehouse_id = $ware_id;
                $quatation->biller_id = $ware_id;
                $quatation->item = $count;
                $quatation->total_qty = $quantity;
                $quatation->total_discount = 0;
                $quatation->total_tax = 0;
                $quatation->order_tax_rate = 0;
                $quatation->order_tax = 0;
                $quatation->order_discount = 0;
                $quatation->total_price = $subtotal;
                $quatation->grand_total = $subtotal + $request->shipping_cost;
                $quatation->shipping_cost = $request->shipping_cost;
                $quatation->quotation_status = 2;
                $quatation->note = $payment_note;
                $quatation->save();
            }
            elseif(Auth::user()->role_id != 5) {
                $customer = new Customer;
                $customer->customer_group_id = 1;
                $customer->name              = $request->name;
                $customer->user_id           =  Auth::user()->id;
                $customer->email             = $request->email;
                $customer->phone_number      = $request->phone_number;
                $customer->address           = $request->address;
                $customer->city              = $request->city;
                $customer->is_active         = 1;
                $customer->save();

                //sales add
                $customer = Customer::orderBy('id', 'DESC')->first();
                $count    = Cart::where('user_ip', '=', request()->ip())->where('session', $session)->count('id');
                $quantity = Cart::where('user_ip', request()->ip())->where('session', $session)->sum('product_quantity');
                $subtotal = Cart::all()->where('user_ip', request()->ip())->where('session', $session)->sum(function($t){
                    return $t->product_price * $t->product_quantity;
                });



                $quatation = new Quotation();
                $quatation->reference_no = 'ecom-qr-' . date("Ymd") . '-' . date("his");
                $quatation->user_id = Auth::user()->id;
                $quatation->customer_id = $customer->id;
                $quatation->warehouse_id =$ware_id;
                $quatation->biller_id = $ware_id;
                $quatation->item = $count;
                $quatation->total_qty = $quantity;
                $quatation->total_discount = 0;
                $quatation->total_tax = 0;
                $quatation->order_tax_rate = 0;
                $quatation->order_tax = 0;
                $quatation->order_discount = 0;
                $quatation->total_price = $subtotal;
                $quatation->grand_total = $subtotal + $request->shipping_cost;
                $quatation->shipping_cost = $request->shipping_cost;
                $quatation->quotation_status = 2;
                $quatation->note = $payment_note;
                $quatation->save();
            }


            //product sales add
            $cart_info = Cart::where('user_ip', $request->cart_ip)->where('session', $session)->get();
            $quatation = Quotation::orderBy('id', 'DESC')->first();

            foreach ($cart_info as $row) {
                $product_quatation = new ProductQuotation();
                $product_quatation->quotation_id = $quatation->id;
                $product_quatation->product_id = $row->product_id;
                $product_quatation->qty = $row->product_quantity;
                $product_quatation->sale_unit_id = 1;
                $product_quatation->net_unit_price = $row->product_price;
                $product_quatation->discount = 0;
                $product_quatation->tax_rate = 0;
                $product_quatation->tax = 0;
                $product_quatation->total = $row->product_price * $row->product_quantity;
                // $order->user_ip              = $row->user_ip;
                $product_quatation->save();
            }
            $quatation = Quotation::orderBy('id', 'DESC')->first();
            $message = 'Your Order Successfully Done';
            if($customer->email){

                $mail_data['name'] = $customer->name;
                $mail_data['email'] = $customer->email;
                $mail_data['city'] = $customer->city;
                $mail_data['address'] = $customer->address;
                $mail_data['phone_number'] = $customer->phone_number;
                $mail_data['reference_no'] = $quatation->reference_no;
                $mail_data['id'] = $quatation->id;
                $mail_data['warehouse_id'] = $quatation->warehouse_id;
                $mail_data['total_qty'] = $quatation->total_qty;
                $mail_data['total_discount'] = $quatation->total_discount;
                $mail_data['order_discount'] = $quatation->order_discount;
                $mail_data['order_tax'] = $quatation->order_tax;
                $mail_data['order_tax_rate'] = $quatation->order_tax_rate;
                $mail_data['shipping_cost'] = $quatation->shipping_cost;
                $mail_data['total_price'] = $quatation->total_price;
                $mail_data['grand_total'] = $quatation->grand_total;
                $mail_data['payment_method'] = $shipping_method;
                $mail_data['payment_note'] = $payment_note;
                $mail_data['created_at'] = $quatation->created_at;
                try{
                    Mail::send( 'mail.order_details', $mail_data, function( $message ) use ($mail_data)
                    {
                        $message->to( $mail_data['email'] )->subject( 'Kosmetica - Order Details' );
                    });
                }
                catch(\Exception $e){
                    $message = 'Payment updated successfully. Please setup your <a href="setting/mail_setting">mail setting</a> to send mail.';
                }
            }

            Cart::where('user_ip', $request->user_ip)->where('session', $session)->delete();
           // return redirect('confirmation')->with('message', $message);
            return View::make('eshop.confirmation')->with(compact('shipping_method','payment_note', 'message'));
        }

    }


//    //checkout page view
//    public function confirmation()
//    {
//        $brands     = Brand::orderBy('title', 'ASC')->where('is_active', true)->get();
//        $categories = Category::orderBy('categories.id', 'DESC')
//            ->join('products', 'products.category_id', '=', 'categories.id')
//            ->where('categories.is_active', true)
//            ->where('categories.parent_id', null)
//            ->where('products.is_active', true)
//            ->select('categories.id', 'categories.name')
//            ->distinct('categories.name')
//            ->limit(5)
//            ->get();
//        $carts = Cart::where('user_ip', request()->ip())->latest()->get();
//
//        $subtotal = Cart::all()->where('user_ip', request()->ip())->sum(function($t){
//            return $t->product_price * $t->product_quantity;
//        });
//
//        $sale = Sale::orderBy('id', 'DESC')->first();
//        $quatation = Quotation::orderBy('id', 'DESC')->first();
//
//
//        $customer = Customer::join('sales', 'sales.customer_id', '=', 'customers.id')
//            ->where('sales.id', $sale->id)
//            ->select('customers.*')
//            ->first();
//
//        $q_customer = Customer::join('quotations', 'quotations.customer_id', '=', 'customers.id')
//            ->where('quotations.id', $quatation->id)
//            ->select('customers.*')
//            ->first();
//
//
//        $products = Product_sale::join('sales', 'sales.id', '=', 'product_sales.sale_id')
//            ->join('products', 'products.id', '=', 'product_sales.product_id')
//            ->where('sales.id', $sale->id)
//            ->select('product_sales.*', 'products.name')
//            ->get();
//
//
////        $q_products = ProductQuotation::join('quotations', 'quotations.id', '=', 'product_quotation.quotation_id')
////            ->join('products', 'products.id', '=', 'product_quotation.product_id')
////            ->where('quotations.id', $quatation->id)
////            ->select('product_quotation.*', 'products.name')
////            ->get();
//
//        $payment = Payment::where('sale_id',$sale->id)->first();
//        // dd($payment);
//
//        // $sum = Product_sale::all()
//        //                     ->join('sales', 'sales.id', '=', 'product_sales.sale_id')
//        //                     ->where('sales.id', $sale->id)
//
//
//        //                         ->sum(function($t){
//        //     return $t->net_unit_price * $t->qty;
//        // });
//        $sum = Product_sale::all()
//            ->where('sale_id', $sale->id)
//            ->sum(function($t){
//                return $t->net_unit_price * $t->qty;
//            });
//
////        $q_sum = ProductQuotation::all()
////            ->where('quotation_id', $quatation->id)
////            ->sum(function($t){
////                return $t->net_unit_price * $t->qty;
////            });
//
//        $user = User::orderBy('id', 'DESC')
//            ->where('id', $customer->user_id)
//            ->first();
//
//
//        $sale_count = Sale::where('customer_id', $customer->id)->count();
//
//
//        // return $sale_count; exit();
//
//        $name_without_space = str_replace(' ', '', $user->name);
//
//        $user_name = substr($name_without_space, 0, 3);
//
//        $rand_user_name = $user_name.rand(10,100);
//
//        // return $result; exit();
//        return view('eshop.confirmation', compact('brands','payment','categories', 'carts', 'subtotal', 'sale', 'customer', 'products', 'sum', 'user', 'sale_count'));
//    }


    //checkout page view
    public function confirmation()
    {

        $session = \Session::getId();
        $brands     = Brand::orderBy('title', 'ASC')->where('is_active', true)->where('title','!=','OTHERS')->where('parent_id', NULL)->get();

        $brand_parent_id = Brand::where('title','=','Invisible')->first()->id;
        $brand_parent = Brand::where('parent_id', $brand_parent_id)->get();

        foreach ($brand_parent as $row){
            $brand_p_id[] = $row->id;
        }



        $categories = Category::orderBy('categories.id', 'DESC')
            ->join('products', 'products.category_id', '=', 'categories.id')
            ->where('categories.is_active', true)
            ->where('categories.parent_id', null)
            ->where('products.is_active', true)
            ->whereNotIn('products.brand_id', $brand_p_id)
            ->select('categories.id', 'categories.name')
            ->distinct('categories.name')
            ->limit(5)
            ->get();
        $carts = Cart::where('user_ip', request()->ip())->where('session', $session)->latest()->get();

        $subtotal = Cart::all()->where('user_ip', request()->ip())->where('session', $session)->sum(function($t){
            return $t->product_price * $t->product_quantity;
        });

        $quatation = Quotation::orderBy('id', 'DESC')->first();

        $customer = Customer::join('quotations', 'quotations.customer_id', '=', 'customers.id')
            ->where('quotations.id', $quatation->id)
            ->select('customers.*')
            ->first();

        $products = ProductQuotation::join('quotations', 'quotations.id', '=', 'product_quotation.quotation_id')
            ->join('products', 'products.id', '=', 'product_quotation.product_id')
            ->where('quotations.id', $quatation->id)
            ->select('product_quotation.*', 'products.name')
            ->get();


        $sum = ProductQuotation::all()
            ->where('quotation_id', $quatation->id)
            ->sum(function($t){
                return $t->net_unit_price * $t->qty;
            });


        $user = User::orderBy('id', 'DESC')
            ->where('id', $customer->user_id)
            ->first();


        $quation_count = Quotation::where('customer_id', $customer->id)->count();


        // return $sale_count; exit();

        $name_without_space = str_replace(' ', '', $user->name);

        $user_name = substr($name_without_space, 0, 3);

        $rand_user_name = $user_name.rand(10,100);
        $message = '' ;
        $shipping_method  = '';
        $payment_note = '';

        // return $result; exit();
        return view('eshop.confirmation', compact('payment_note','shipping_method','message','brands','categories', 'carts', 'subtotal', 'quatation', 'customer', 'products', 'sum', 'user', 'quation_count'));
    }


    //contact page view
    public function contact()
    {
        // return Auth::user(); exit();
        $session = \Session::getId();
        $brands     = Brand::orderBy('title', 'ASC')->where('is_active', true)->where('title','!=','OTHERS')->where('parent_id', NULL)->get();
        $brand_parent_id = Brand::where('title','=','Invisible')->first()->id;
        $brand_parent = Brand::where('parent_id', $brand_parent_id)->get();

        foreach ($brand_parent as $row){
            $brand_p_id[] = $row->id;
        }
        $categories = Category::orderBy('categories.id', 'DESC')
            ->join('products', 'products.category_id', '=', 'categories.id')
            ->where('categories.is_active', true)
            ->where('categories.parent_id', null)
            ->where('products.is_active', true)
            ->whereNotIn('products.brand_id', $brand_p_id)
            ->select('categories.id', 'categories.name')
            ->distinct('categories.name')
            ->limit(5)
            ->get();
        $carts = Cart::where('user_ip', request()->ip())->where('session', $session)->latest()->get();
        $subtotal = Cart::all()->where('user_ip', request()->ip())->where('session', $session)->sum(function($t){
            return $t->product_price * $t->product_quantity;
        });
        return view('eshop.contact', compact('brands','categories', 'carts', 'subtotal'));
    }

    //login page view
    public function login()
    {
        $session = \Session::getId();
        $brands     = Brand::orderBy('title', 'ASC')->where('is_active', true)->where('title','!=','OTHERS')->where('parent_id', NULL)->get();
        $brand_parent_id = Brand::where('title','=','Invisible')->first()->id;
        $brand_parent = Brand::where('parent_id', $brand_parent_id)->get();

        foreach ($brand_parent as $row){
            $brand_p_id[] = $row->id;
        }

        $categories = Category::orderBy('categories.id', 'DESC')
            ->join('products', 'products.category_id', '=', 'categories.id')
            ->where('categories.is_active', true)
            ->where('categories.parent_id', null)
            ->where('products.is_active', true)
            ->whereNotIn('products.brand_id', $brand_p_id)
            ->select('categories.id', 'categories.name')
            ->distinct('categories.name')
            ->limit(5)
            ->get();
        $carts = Cart::where('user_ip', request()->ip())->where('session', $session)->latest()->get();
        $subtotal = Cart::all()->where('user_ip', request()->ip())->where('session', $session)->sum(function($t){
            return $t->product_price * $t->product_quantity;
        });
        return view('eshop.login', compact('brands','categories', 'carts', 'subtotal'));
    }

    //profile page view
    public function profile()
    {

        $session = \Session::getId();
        $brands     = Brand::orderBy('title', 'ASC')->where('is_active', true)->where('title','!=','OTHERS')->where('parent_id', NULL)->get();
        $categories = Category::orderBy('categories.id', 'DESC')
            ->join('products', 'products.category_id', '=', 'categories.id')
            ->where('categories.is_active', true)
            ->where('categories.parent_id', null)
            ->where('products.is_active', true)
            ->select('categories.id', 'categories.name')
            ->distinct('categories.name')
            ->limit(5)
            ->get();
        $carts = Cart::where('user_ip', request()->ip())->where('session', $session)->latest()->get();
        $subtotal = Cart::all()->where('user_ip', request()->ip())->where('session', $session)->sum(function($t){
            return $t->product_price * $t->product_quantity;
        });
        $customer = Customer::select('id')->where('user_id', Auth::id())->first();
        $lims_sale_data = Sale::with('warehouse')->where('customer_id', $customer->id)->orderBy('created_at', 'desc')->get();

        $order_count = Quotation::where('customer_id', $customer->id)->count();

        // return $order_count; exit();

        return view('eshop.profile', compact('brands','categories', 'carts', 'subtotal', 'customer', 'lims_sale_data', 'order_count'));
    }

    protected function guard()
    {
        return Auth::guard();
    }

    //customer logut
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/eshop/login');
    }
    protected function loggedOut(Request $request)
    {

    }

    //contact post
    public function post_contact(Request $request)
    {
        $contact = new Contact;
        $contact->name              = $request->name;
        $contact->email             = $request->email;
        $contact->phone_number      = $request->phone_number;
        $contact->message           = $request->message;
        $contact->save();
        return back()->with('success', 'Message is Successfully Sent!');
    }

    //customer profile edit
    public function edit_profile($id)
    {
        $session = \Session::getId();
        $brands     = Brand::orderBy('title', 'ASC')->where('is_active', true)->where('title','!=','OTHERS')->where('parent_id', NULL)->get();
        $categories = Category::orderBy('categories.id', 'DESC')
            ->join('products', 'products.category_id', '=', 'categories.id')
            ->where('categories.is_active', true)
            ->where('categories.parent_id', null)
            ->where('products.is_active', true)
            ->select('categories.id', 'categories.name')
            ->distinct('categories.name')
            ->limit(5)
            ->get();
        $carts = Cart::where('user_ip', request()->ip())->where('session', $session)->latest()->get();
        $subtotal = Cart::all()->where('user_ip', request()->ip())->where('session', $session)->sum(function($t){
            return $t->product_price * $t->product_quantity;
        });
        $profile = User::orderBy('users.id', 'DESC')
            ->join('customers', 'customers.user_id', '=', 'users.id')
            ->where('users.id', '=', $id)
            ->select('customers.user_id','customers.name', 'customers.company_name', 'customers.email', 'customers.phone_number', 'customers.tax_no', 'customers.address', 'customers.other_phone_one','customers.other_phone_two','customers.other_address_one', 'customers.other_address_two', 'customers.city', 'customers.state', 'customers.postal_code','customers.country', 'users.name AS user_name', 'users.email as user_email' )
            ->first();
        return view('eshop.edit_profile', compact('brands','categories', 'carts', 'subtotal', 'profile'));
    }

    //update customer profile
    public function update_profile(Request $request)
    {


        $user = User::find($request->id);
        $user->name  = $request->user_name;
        $user->email = $request->email;
        $user->save();

        $customer_id = User::join('customers', 'customers.user_id', '=', 'users.id')
            ->where('users.id', '=', $request->id)
            ->first();

        $customer = Customer::find($customer_id->id);
        $customer->name         = $request->name;
        $customer->email        = $request->email;
        $customer->phone_number = $request->phone_number;
        $customer->tax_no       = $request->tax_no;
        $customer->address      = $request->address;
        $customer->city         = $request->city;
        $customer->other_phone_one    = $request->other_phone_one;
        $customer->other_phone_two    = $request->other_phone_two;
        $customer->other_address_one  = $request->other_address_one;
        $customer->other_address_two  = $request->other_address_two;
        $customer->save();
        return back()->with('success', 'Update Successful!');
    }


    //password update
    public function update_password(Request $request)
    {
        // return $request; exit();
        if($request->new_password != $request->confirm_password){
            return back()->with('alert', 'Confirmation Password Not Match!');
        }

        $user = User::find($request->id);

        if (Hash::check($request->old_password, $user->password)) {
            $user->password = bcrypt($request->new_password);
        }
        else{
            return back()->with('alert', 'Current Password is Wrong!');
        }
        $user->save();
        return back()->with('success', 'Update Successful!');
    }

    public function orders()
    {
        $session = \Session::getId();
        $brands     = Brand::orderBy('title', 'ASC')->where('is_active', true)->where('title','!=','OTHERS')->where('parent_id', NULL)->get();

        $brand_parent_id = Brand::where('title','=','Invisible')->first()->id;
        $brand_parent = Brand::where('parent_id', $brand_parent_id)->get();

        foreach ($brand_parent as $row){
            $brand_p_id[] = $row->id;
        }

        $categories = Category::orderBy('categories.id', 'DESC')
            ->join('products', 'products.category_id', '=', 'categories.id')
            ->where('categories.is_active', true)
            ->where('categories.parent_id', null)
            ->where('products.is_active', true)
            ->whereNotIn('products.brand_id', $brand_p_id)
            ->select('categories.id', 'categories.name')
            ->distinct('categories.name')
            ->limit(5)
            ->get();
        $carts = Cart::where('user_ip', request()->ip())->where('session', $session)->latest()->get();
        $subtotal = Cart::all()->where('user_ip', request()->ip())->where('session', $session)->sum(function($t){
            return $t->product_price * $t->product_quantity;
        });
        $customer = Customer::select('id')->where('user_id', Auth::id())->first();
        $lims_sale_data = Quotation::with('warehouse')->where('customer_id', $customer->id)->orderBy('created_at', 'desc')->get();
        return view('eshop.orders', compact('brands','categories', 'carts', 'subtotal', 'customer', 'lims_sale_data'));
    }


    public function my_wishlist()
    {
        $session = \Session::getId();
        $brands     = Brand::orderBy('title', 'ASC')->where('is_active', true)->where('title','!=','OTHERS')->where('parent_id', NULL)->get();
        $categories = Category::orderBy('categories.id', 'DESC')
            ->join('products', 'products.category_id', '=', 'categories.id')
            ->where('categories.is_active', true)
            ->where('categories.parent_id', null)
            ->where('products.is_active', true)
            ->select('categories.id', 'categories.name')
            ->distinct('categories.name')
            ->limit(5)
            ->get();
        $carts = Cart::where('user_ip', request()->ip())->where('session', $session)->latest()->get();
        $subtotal = Cart::all()->where('user_ip', request()->ip())->where('session', $session)->sum(function($t){
            return $t->product_price * $t->product_quantity;
        });
        $customer = Customer::select('id')->where('user_id', Auth::id())->first();

        $lims_sale_data = Wishlist::where('customer_id', $customer->id)->orderBy('created_at', 'desc')->get();

        return view('eshop.wishlist', compact('brands','categories', 'carts', 'subtotal', 'customer', 'lims_sale_data'));
    }

    public function my_review()
    {
        $session = \Session::getId();
        $brands     = Brand::orderBy('title', 'ASC')->where('is_active', true)->where('title','!=','OTHERS')->where('parent_id', NULL)->get();
        $categories = Category::orderBy('categories.id', 'DESC')
            ->join('products', 'products.category_id', '=', 'categories.id')
            ->where('categories.is_active', true)
            ->where('categories.parent_id', null)
            ->where('products.is_active', true)
            ->select('categories.id', 'categories.name')
            ->distinct('categories.name')
            ->limit(5)
            ->get();
        $carts = Cart::where('user_ip', request()->ip())->where('session', $session)->latest()->get();
        $subtotal = Cart::all()->where('user_ip', request()->ip())->where('session', $session)->sum(function($t){
            return $t->product_price * $t->product_quantity;
        });
        $customer = Customer::select('id')->where('user_id', Auth::id())->first();

        $lims_review_data = Review::where('customer_id', $customer->id)->orderBy('created_at', 'desc')->get();

        return view('eshop.review', compact('brands','categories', 'carts', 'subtotal', 'customer', 'lims_review_data'));
    }

    public function search(Request $request)
    {
        $session = \Session::getId();
        $product_details_info = null;
        $quick_view = null ;

        $search_title =  $request->search;
        $brand_parent_id = Brand::where('title','=','Invisible')->first()->id;
        $brand_parent = Brand::where('parent_id', $brand_parent_id)->get();
        foreach ($brand_parent as $row){
            $brand_p_id[] = $row->id;
        }

        $cat_parent_id = Category::where('name','=','Sample')->first()->id;

        $catgory_parent = Category::where('parent_id', $cat_parent_id)->get();

        foreach ($catgory_parent as $row){
            $cat_p_id[] = $row->id;
        }
        $brands = DB::table('brands')
            ->where('is_active', true)
            ->where('title','!=','OTHERS')
            ->orderBy('title', 'ASC')
            ->where('parent_id', NULL)
            ->whereNotIn('id', $brand_p_id)
            ->get();

        $categories = Category::orderBy('categories.id', 'DESC')
            ->join('products', 'products.category_id', '=', 'categories.id')
            ->where('categories.is_active', true)
            ->where('products.is_active', true)
            ->whereNotIn('products.category_id', $cat_p_id)
            ->select('categories.id', 'categories.name')
            ->distinct('categories.name')
            ->get();

        $carts = Cart::where('user_ip', request()->ip())->where('session', $session)->latest()->get();
        $subtotal = Cart::all()->where('user_ip', request()->ip())->where('session', $session)->sum(function($t){
            return $t->product_price * $t->product_quantity;
        });

         $tags_id = Tags::where('tag_name', 'like', '%'.$request->search.'%')->first();

         if ($tags_id != null){
             $tag_id =  $tags_id->id;

             $product_tag = ProductTag::where('tag_id', $tag_id)->get();
             foreach ($product_tag as $row){
                 $pro_tag_id[] = $row->product_id;
             }
//
//             $search = Product::join('brands', 'products.brand_id', '=', 'brands.id')
//                 ->join('categories', 'products.category_id', '=', 'categories.id')
//                 ->where('products.name', 'like', '%'.$request->search.'%')
//                 ->orWhere('products.product_details', 'like', '%'.$request->search.'%')
//                 ->orWhere('brands.title', 'like', '%'.$request->search.'%')
//                 ->orWhere('categories.name', 'like', '%'.$request->search.'%')
//                 ->whereNotIn('products.brand_id', $brand_p_id)
//                 ->whereNotIn('products.category_id', $cat_p_id)
//                 ->orWhereIn('products.id',$pro_tag_id)
//                 ->select('products.*')
//                 ->get();


             $search_product = Product::join('brands', 'products.brand_id', '=', 'brands.id')
                 ->join('categories', 'products.category_id', '=', 'categories.id')
                 ->where('products.name', 'like', '%'.$request->search.'%')
                 ->orWhere('products.product_details', 'like', '%'.$request->search.'%')
                 ->orWhere('brands.title', 'like', '%'.$request->search.'%')
                 ->orWhere('categories.name', 'like', '%'.$request->search.'%')
                 ->where('products.is_active', true)
                 ->select('products.*')
                 ->get();
             foreach ($search_product as $row){
                 $search_p_id[] = $row->id;
             }

             $search = Product::join('brands', 'products.brand_id', '=', 'brands.id')
                 ->join('categories', 'products.category_id', '=', 'categories.id')
                 ->whereIn('products.id',$search_p_id)
                 ->whereIn('products.id',$pro_tag_id)
                 ->whereNotIn('products.brand_id', $brand_p_id)
                 ->whereNotIn('products.category_id', $cat_p_id)
                 ->where('products.is_active', true)
                 ->select('products.*')
                 ->get();

         }else{

             $search_product = Product::join('brands', 'products.brand_id', '=', 'brands.id')
                 ->join('categories', 'products.category_id', '=', 'categories.id')
                 ->where('products.name', 'like', '%'.$request->search.'%')
                 ->orWhere('products.product_details', 'like', '%'.$request->search.'%')
                 ->orWhere('brands.title', 'like', '%'.$request->search.'%')
                 ->orWhere('categories.name', 'like', '%'.$request->search.'%')
                 ->where('products.is_active', true)
                 ->select('products.*')
                 ->get();
             foreach ($search_product as $row){
                 $search_p_id[] = $row->id;
             }

             $search = Product::join('brands', 'products.brand_id', '=', 'brands.id')
                 ->join('categories', 'products.category_id', '=', 'categories.id')
                 ->whereIn('products.id',$search_p_id)
                 ->whereNotIn('products.brand_id', $brand_p_id)
                 ->whereNotIn('products.category_id', $cat_p_id)
                 ->where('products.is_active', true)
                 ->select('products.*')
                 ->get();
         }

        $products = Product::where('is_active', true)
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get();
        $next_products = Product::where('is_active', true)
            ->orderBy('id', 'DESC')
            ->skip(3)
            ->take(3)
            ->get();
        return view('eshop.search', compact('quick_view','product_details_info','search_title','search', 'categories', 'carts', 'subtotal', 'brands', 'products', 'next_products'));
    }




    public function search_quick(Request $request,$id)
    {
        $session = \Session::getId();
        if ($id== null) {

            $product_details_info = null;
            $quick_view = null ;
        }else{
            $product_details_info  = Product::orderBy('id', 'DESC')
                ->join('brands', 'brands.id', '=', 'products.brand_id')
                ->where('products.id', '=', $id)
                ->where('products.is_active', true)
                ->select('products.*')
                ->first();
            $quick_view = 9 ;

        }


        $search_title =  $request->search;
        $brand_parent_id = Brand::where('title','=','Invisible')->first()->id;
        $brand_parent = Brand::where('parent_id', $brand_parent_id)->get();
        foreach ($brand_parent as $row){
            $brand_p_id[] = $row->id;
        }

        $cat_parent_id = Category::where('name','=','Sample')->first()->id;

        $catgory_parent = Category::where('parent_id', $cat_parent_id)->get();

        foreach ($catgory_parent as $row){
            $cat_p_id[] = $row->id;
        }
        $brands = DB::table('brands')
            ->where('is_active', true)
            ->where('title','!=','OTHERS')
            ->orderBy('title', 'ASC')
            ->where('parent_id', NULL)
            ->whereNotIn('id', $brand_p_id)
            ->get();

        $categories = Category::orderBy('categories.id', 'DESC')
            ->join('products', 'products.category_id', '=', 'categories.id')
            ->where('categories.is_active', true)
            ->where('products.is_active', true)
            ->whereNotIn('products.category_id', $cat_p_id)
            ->select('categories.id', 'categories.name')
            ->distinct('categories.name')
            ->get();

        $carts = Cart::where('user_ip', request()->ip())->where('session', $session)->latest()->get();
        $subtotal = Cart::all()->where('user_ip', request()->ip())->where('session', $session)->sum(function($t){
            return $t->product_price * $t->product_quantity;
        });

        $tags_id = Tags::where('tag_name', 'like', '%'.$request->search.'%')->first();

        if ($tags_id != null){
            $tag_id =  $tags_id->id;

            $product_tag = ProductTag::where('tag_id', $tag_id)->get();
            foreach ($product_tag as $row){
                $pro_tag_id[] = $row->product_id;
            }
//
//             $search = Product::join('brands', 'products.brand_id', '=', 'brands.id')
//                 ->join('categories', 'products.category_id', '=', 'categories.id')
//                 ->where('products.name', 'like', '%'.$request->search.'%')
//                 ->orWhere('products.product_details', 'like', '%'.$request->search.'%')
//                 ->orWhere('brands.title', 'like', '%'.$request->search.'%')
//                 ->orWhere('categories.name', 'like', '%'.$request->search.'%')
//                 ->whereNotIn('products.brand_id', $brand_p_id)
//                 ->whereNotIn('products.category_id', $cat_p_id)
//                 ->orWhereIn('products.id',$pro_tag_id)
//                 ->select('products.*')
//                 ->get();


            $search_product = Product::join('brands', 'products.brand_id', '=', 'brands.id')
                ->join('categories', 'products.category_id', '=', 'categories.id')
                ->where('products.name', 'like', '%'.$request->search.'%')
                ->orWhere('products.product_details', 'like', '%'.$request->search.'%')
                ->orWhere('brands.title', 'like', '%'.$request->search.'%')
                ->orWhere('categories.name', 'like', '%'.$request->search.'%')
                ->where('products.is_active', true)
                ->select('products.*')
                ->get();
            foreach ($search_product as $row){
                $search_p_id[] = $row->id;
            }

            $search = Product::join('brands', 'products.brand_id', '=', 'brands.id')
                ->join('categories', 'products.category_id', '=', 'categories.id')
                ->whereIn('products.id',$search_p_id)
                ->whereIn('products.id',$pro_tag_id)
                ->whereNotIn('products.brand_id', $brand_p_id)
                ->whereNotIn('products.category_id', $cat_p_id)
                ->where('products.is_active', true)
                ->select('products.*')
                ->get();

        }else{

            $search_product = Product::join('brands', 'products.brand_id', '=', 'brands.id')
                ->join('categories', 'products.category_id', '=', 'categories.id')
                ->where('products.name', 'like', '%'.$request->search.'%')
                ->orWhere('products.product_details', 'like', '%'.$request->search.'%')
                ->orWhere('brands.title', 'like', '%'.$request->search.'%')
                ->orWhere('categories.name', 'like', '%'.$request->search.'%')
                ->where('products.is_active', true)
                ->select('products.*')
                ->get();
            foreach ($search_product as $row){
                $search_p_id[] = $row->id;
            }

            $search = Product::join('brands', 'products.brand_id', '=', 'brands.id')
                ->join('categories', 'products.category_id', '=', 'categories.id')
                ->whereIn('products.id',$search_p_id)
                ->whereNotIn('products.brand_id', $brand_p_id)
                ->whereNotIn('products.category_id', $cat_p_id)
                ->where('products.is_active', true)
                ->select('products.*')
                ->get();
        }

        $products = Product::where('is_active', true)
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get();
        $next_products = Product::where('is_active', true)
            ->orderBy('id', 'DESC')
            ->skip(3)
            ->take(3)
            ->get();

        return view('eshop.search', compact('product_details_info','quick_view','search_title','search', 'categories', 'carts', 'subtotal', 'brands', 'products', 'next_products'));
    }



//    public function offer()
//    {
//        $session = \Session::getId();
//        $brands     = Brand::orderBy('title', 'ASC')->where('is_active', true)->where('title','!=','OTHERS')->where('parent_id', NULL)->get();
//        $categories = Category::orderBy('categories.id', 'DESC')
//            ->join('products', 'products.category_id', '=', 'categories.id')
//            ->where('categories.is_active', true)
//            ->where('categories.parent_id', null)
//            ->where('products.is_active', true)
//            ->select('categories.id', 'categories.name')
//            ->distinct('categories.name')
//            ->limit(5)
//            ->get();
//        $carts = Cart::where('user_ip', request()->ip())->where('session', $session)->latest()->get();
//        $subtotal = Cart::all()->where('user_ip', request()->ip())->where('session', $session)->sum(function($t){
//            return $t->product_price * $t->product_quantity;
//        });
//
//        $discount = Product::orderBy('id', 'DESC')
//            ->where('promotion', 1)
//            ->where('is_active', true)
//            ->get();
//        $products = Product::where('is_active', true)
//            ->orderBy('id', 'DESC')
//            ->limit(3)
//            ->get();
//        $next_products = Product::where('is_active', true)
//            ->orderBy('id', 'DESC')
//            ->skip(3)
//            ->take(3)
//            ->get();
//        return view('eshop.offer', compact('brands','discount','categories', 'carts', 'subtotal', 'products', 'next_products'));
//    }

    //newsletter post
    public function newsletter(Request $request)
    {

        $request->validate([
            'email'           => 'required'
        ]);

        $newsletter = new Newsletter;

        $newsletter->email = $request->email;

        $newsletter->save();

        // return redirect('/eshop');

        return back()->with('newsletter_modal', 1);
    }

    //blog post
    public function blog_post($id)
    {
        // echo "string";
        $session = \Session::getId();
        $brands     = Brand::orderBy('title', 'ASC')->where('is_active', true)->where('title','!=','OTHERS')->where('parent_id', NULL)->get();
        $categories = Category::orderBy('categories.id', 'DESC')
            ->join('products', 'products.category_id', '=', 'categories.id')
            ->where('categories.is_active', true)
            ->where('categories.parent_id', null)
            ->where('products.is_active', true)
            ->select('categories.id', 'categories.name')
            ->distinct('categories.name')
            ->limit(5)
            ->get();
        $carts = Cart::where('user_ip', request()->ip())->where('session', $session)->latest()->get();
        $subtotal = Cart::all()->where('user_ip', request()->ip())->where('session', $session)->sum(function($t){
            return $t->product_price * $t->product_quantity;
        });

        $blog  = Blog::orderBy('id', 'DESC')
            ->where('id', $id)
            ->first();
        $blogs = Blog::orderBy('id', 'DESC')
            ->get();
        $recent_blog = Blog::orderBy('id', 'DESC')
            ->limit(2)
            ->get();

        return view('eshop.blog_post', compact('brands','categories', 'carts', 'subtotal', 'blog', 'blogs', 'recent_blog'));
    }

    // MINI-Shop


    public function mini_shop()
    {

        $session = \Session::getId();
        $product_details_info = null;
        $quick_view = null ;


        $brands     = Brand::orderBy('title', 'ASC')->where('is_active', true)->where('title','!=','OTHERS')->where('parent_id', NULL)->get();
        $products   = Product::orderBy('id', 'DESC')->where('is_active', true)->limit(3)->get();
        $cat_name = Category::where('id', '=', 1)->first();




        $brand_parent_id = Brand::where('title','=','Invisible')->first()->id;
        $brand_parent = Brand::where('parent_id', $brand_parent_id)->get();

        foreach ($brand_parent as $row){
            $brand_p_id[] = $row->id;
        }



        $cat = Category::orderBy('id', 'DESC')
            ->where('is_active', true)
            ->get();
        $brands_product = DB::table('brands')
            ->join('products', 'products.brand_id', '=', 'brands.id')
            ->where('brands.is_active', true)
            ->where('products.is_active', true)
            ->whereNotIn('products.brand_id', $brand_p_id)
            ->where('products.category_id', '=', 1)
            ->distinct('products.brand_id')
            ->select('brands.title', 'brands.id','brands.image')
            ->get();

        // return $brands; exit();
        $categories = Category::orderBy('categories.id', 'DESC')
            ->join('products', 'products.category_id', '=', 'categories.id')
            ->where('categories.is_active', true)
            ->where('categories.parent_id', null)
            ->where('products.is_active', true)
            ->select('categories.id', 'categories.name')
            ->distinct('categories.name')
            ->limit(5)
            ->get();
        $carts = Cart::where('user_ip', request()->ip())->where('session', $session)->latest()->get();
        $subtotal = Cart::all()->where('user_ip', request()->ip())->where('session', $session)->sum(function($t){
            return $t->product_price * $t->product_quantity;
        });
        $product_category   = Product::orderBy('id', 'DESC')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('brands', 'products.brand_id', '=', 'brands.id')
            ->where('products.mini_shop_featured', 1)
            ->whereNotIn('products.brand_id', $brand_p_id)
            ->select('products.*')
            ->paginate(8);

        $next_products = Product::where('is_active', true)
            ->orderBy('id', 'DESC')
            ->skip(3)
            ->take(3)
            ->get();
        $category_id = 1;

        return view('eshop.mini_shop', compact('quick_view','product_details_info','brands_product','categories', 'product_category', 'carts', 'subtotal', 'brands', 'category_id', 'cat_name', 'cat', 'products', 'next_products'));
    }


    public function mini_shop_quick(Request $request)
    {
        $session = \Session::getId();
        if ($request->quick_id == null) {

            $product_details_info = null;
            $quick_view = null ;
        }else{
            $product_details_info  = Product::orderBy('id', 'DESC')
                ->join('brands', 'brands.id', '=', 'products.brand_id')
                ->where('products.id', '=', $request->quick_id)
                ->where('products.is_active', true)
                ->select('products.*')
                ->first();
            $quick_view = 9 ;

        }


        $brands     = Brand::orderBy('title', 'ASC')->where('is_active', true)->where('title','!=','OTHERS')->where('parent_id', NULL)->get();
        $products   = Product::orderBy('id', 'DESC')->where('is_active', true)->limit(3)->get();
        $cat_name = Category::where('id', '=', 1)->first();


        $brand_parent_id = Brand::where('title','=','Invisible')->first()->id;
        $brand_parent = Brand::where('parent_id', $brand_parent_id)->get();

        foreach ($brand_parent as $row){
            $brand_p_id[] = $row->id;
        }


        $cat = Category::orderBy('id', 'DESC')
            ->where('is_active', true)
            ->get();
        $brands_product = DB::table('brands')
            ->join('products', 'products.brand_id', '=', 'brands.id')
            ->where('brands.is_active', true)
            ->where('products.is_active', true)
            ->where('products.category_id', '=', 1)
            ->whereNotIn('products.brand_id', $brand_p_id)
            ->distinct('products.brand_id')
            ->select('brands.title', 'brands.id','brands.image')
            ->get();

        // return $brands; exit();
        $categories = Category::orderBy('categories.id', 'DESC')
            ->join('products', 'products.category_id', '=', 'categories.id')
            ->where('categories.is_active', true)
            ->where('categories.parent_id', null)
            ->where('products.is_active', true)
            ->select('categories.id', 'categories.name')
            ->distinct('categories.name')
            ->limit(5)
            ->get();
        $carts = Cart::where('user_ip', request()->ip())->where('session', $session)->latest()->get();
        $subtotal = Cart::all()->where('user_ip', request()->ip())->where('session', $session)->sum(function($t){
            return $t->product_price * $t->product_quantity;
        });
        $product_category   = Product::orderBy('id', 'DESC')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('brands', 'products.brand_id', '=', 'brands.id')
            ->where('products.mini_shop_featured', 1)
            ->whereNotIn('products.brand_id', $brand_p_id)
            ->where('products.is_active', true)
            ->select('products.*')
            ->paginate(8);

        $next_products = Product::where('is_active', true)
            ->orderBy('id', 'DESC')
            ->skip(3)
            ->take(3)
            ->get();
        $category_id = 1;

        return view('eshop.mini_shop', compact('quick_view','product_details_info','brands_product','categories', 'product_category', 'carts', 'subtotal', 'brands', 'category_id', 'cat_name', 'cat', 'products', 'next_products'));
    }





    public function offer()
    {

        $now = Carbon::now();
        $offer_date = Carbon::parse($now)->format('Y-m-d');

        $session = \Session::getId();
        $product_details_info = null;
        $quick_view = null ;
        $brands     = Brand::orderBy('title', 'ASC')->where('is_active', true)->where('title','!=','OTHERS')->where('parent_id', NULL)->get();
        $products   = Product::orderBy('id', 'DESC')->where('is_active', true)->limit(3)->get();
        $cat_name = Category::where('id', '=', 1)->first();

        $brand_parent_id = Brand::where('title','=','Invisible')->first()->id;
        $brand_parent = Brand::where('parent_id', $brand_parent_id)->get();

        foreach ($brand_parent as $row){
            $brand_p_id[] = $row->id;
        }
        $cat = Category::orderBy('id', 'DESC')
            ->where('is_active', true)
            ->get();
        $brands_product = DB::table('brands')
            ->join('products', 'products.brand_id', '=', 'brands.id')
            ->where('brands.is_active', true)
            ->where('products.is_active', true)
            ->whereNotIn('products.brand_id', $brand_p_id)
            ->where('products.category_id', '=', 1)
            ->distinct('products.brand_id')
            ->select('brands.title', 'brands.id','brands.image')
            ->get();

        // return $brands; exit();
        $categories = Category::orderBy('categories.id', 'DESC')
            ->join('products', 'products.category_id', '=', 'categories.id')
            ->where('categories.is_active', true)
            ->where('categories.parent_id', null)
            ->where('products.is_active', true)
            ->select('categories.id', 'categories.name')
            ->distinct('categories.name')
            ->limit(5)
            ->get();
        $carts = Cart::where('user_ip', request()->ip())->where('session', $session)->latest()->get();
        $subtotal = Cart::all()->where('user_ip', request()->ip())->where('session', $session)->sum(function($t){
            return $t->product_price * $t->product_quantity;
        });
        $offer_products   = Product::orderBy('id', 'DESC')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('brands', 'products.brand_id', '=', 'brands.id')
            ->where('products.promotion', '!=', null)
             ->where('products.qty','>', 0)
            ->whereDate('last_date', '>=' , $offer_date)
            ->whereNotIn('products.brand_id', $brand_p_id)
            ->select('products.*')
            ->get();


        $next_products = Product::where('is_active', true)
            ->orderBy('id', 'DESC')
            ->skip(3)
            ->take(3)
            ->get();
        $category_id = 1;

        return view('eshop.offer', compact('quick_view','product_details_info','brands_product','categories', 'offer_products', 'carts', 'subtotal', 'brands', 'category_id', 'cat_name', 'cat', 'products', 'next_products'));
    }


    public function offer_quick(Request $request)
    {

        $now = Carbon::now();
        $offer_date = Carbon::parse($now)->format('Y-m-d');


        $session = \Session::getId();
        if ($request->quick_id == null) {

            $product_details_info = null;
            $quick_view = null ;
        }else{
            $product_details_info  = Product::orderBy('id', 'DESC')
                ->join('brands', 'brands.id', '=', 'products.brand_id')
                ->where('products.id', '=', $request->quick_id)
                ->where('products.is_active', true)
                ->select('products.*')
                ->first();
            $quick_view = 9 ;

        }


        $brands     = Brand::orderBy('title', 'ASC')->where('is_active', true)->where('title','!=','OTHERS')->where('parent_id', NULL)->get();
        $products   = Product::orderBy('id', 'DESC')->where('is_active', true)->limit(3)->get();
        $cat_name = Category::where('id', '=', 1)->first();


        $brand_parent_id = Brand::where('title','=','Invisible')->first()->id;
        $brand_parent = Brand::where('parent_id', $brand_parent_id)->get();

        foreach ($brand_parent as $row){
            $brand_p_id[] = $row->id;
        }


        $cat = Category::orderBy('id', 'DESC')
            ->where('is_active', true)
            ->get();
        $brands_product = DB::table('brands')
            ->join('products', 'products.brand_id', '=', 'brands.id')
            ->where('brands.is_active', true)
            ->where('products.is_active', true)
            ->where('products.category_id', '=', 1)
            ->whereNotIn('products.brand_id', $brand_p_id)
            ->distinct('products.brand_id')
            ->select('brands.title', 'brands.id','brands.image')
            ->get();

        // return $brands; exit();
        $categories = Category::orderBy('categories.id', 'DESC')
            ->join('products', 'products.category_id', '=', 'categories.id')
            ->where('categories.is_active', true)
            ->where('categories.parent_id', null)
            ->where('products.is_active', true)
            ->select('categories.id', 'categories.name')
            ->distinct('categories.name')
            ->limit(5)
            ->get();
        $carts = Cart::where('user_ip', request()->ip())->where('session', $session)->latest()->get();
        $subtotal = Cart::all()->where('user_ip', request()->ip())->where('session', $session)->sum(function($t){
            return $t->product_price * $t->product_quantity;
        });

        $offer_products   = Product::orderBy('id', 'DESC')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('brands', 'products.brand_id', '=', 'brands.id')
            ->where('products.promotion', '!=', null)
              ->where('products.qty','>', 0)
            ->whereDate('last_date', '>=' , $offer_date)
            ->whereNotIn('products.brand_id', $brand_p_id)
            ->select('products.*')
            ->get();

        $next_products = Product::where('is_active', true)
            ->orderBy('id', 'DESC')
            ->skip(3)
            ->take(3)
            ->get();
        $category_id = 1;

        return view('eshop.offer', compact('quick_view','product_details_info','brands_product','categories', 'offer_products', 'carts', 'subtotal', 'brands', 'category_id', 'cat_name', 'cat', 'products', 'next_products'));
    }



    //all blogs
    public function blogs()
    {
        $session = \Session::getId();
        $brands     = Brand::orderBy('title', 'ASC')->where('is_active', true)->where('title','!=','OTHERS')->where('parent_id', NULL)->get();
        $categories = Category::orderBy('categories.id', 'DESC')
            ->join('products', 'products.category_id', '=', 'categories.id')
            ->where('categories.is_active', true)
            ->where('categories.parent_id', null)
            ->where('products.is_active', true)
            ->select('categories.id', 'categories.name')
            ->distinct('categories.name')
            ->limit(5)
            ->get();
        $carts = Cart::where('user_ip', request()->ip())->where('session', $session)->latest()->get();
        $subtotal = Cart::all()->where('user_ip', request()->ip())->where('session', $session)->sum(function($t){
            return $t->product_price * $t->product_quantity;
        });

        $blogs = Blog::orderBy('id', 'DESC')
            ->get();
        $recent_blog = Blog::orderBy('id', 'DESC')
            ->limit(2)
            ->get();

        return view('eshop.blogs', compact('brands','categories', 'carts', 'subtotal', 'blogs', 'recent_blog'));
    }




    //all blogs
    public function right_now()
    {
        $session = \Session::getId();
        $brands     = Brand::orderBy('title', 'ASC')->where('is_active', true)->where('title','!=','OTHERS')->where('parent_id', NULL)->get();
        $categories = Category::orderBy('categories.id', 'DESC')
            ->join('products', 'products.category_id', '=', 'categories.id')
            ->where('categories.is_active', true)
            ->where('categories.parent_id', null)
            ->where('products.is_active', true)
            ->select('categories.id', 'categories.name')
            ->distinct('categories.name')
            ->limit(5)
            ->get();
        $carts = Cart::where('user_ip', request()->ip())->where('session', $session)->latest()->get();
        $subtotal = Cart::all()->where('user_ip', request()->ip())->where('session', $session)->sum(function($t){
            return $t->product_price * $t->product_quantity;
        });

        $blogs = Blog::orderBy('id', 'DESC')->where('featured',1)
            ->get();

        $recent_blog = Blog::orderBy('id', 'DESC')
            ->limit(2)
            ->get();

        return view('eshop.right-now', compact('brands','categories', 'carts', 'subtotal', 'blogs', 'recent_blog'));
    }



    //Price Filter page view
    public function filter_search(Request $request)
    {
        $session = \Session::getId();
        $cat_id = $request->cat_id;
        $min = $request->min;
        $max = $request->max;

        $brands     = Brand::orderBy('title', 'ASC')->where('is_active', true)->where('title','!=','OTHERS')->where('parent_id', NULL)->get();
        $products   = Product::orderBy('id', 'DESC')->where('is_active', true)->limit(3)->get();
        $cat_name = Category::where('id', '=', $cat_id)->first();

        $cat = Category::orderBy('id', 'DESC')
            ->where('is_active', true)
            ->get();

        $brands_product = DB::table('brands')
            ->join('products', 'products.brand_id', '=', 'brands.id')
            ->where('brands.is_active', true)
            ->where('products.is_active', true)
            ->where('products.category_id', '=', $cat_id)
            ->distinct('products.brand_id')
            ->select('brands.title', 'brands.id','brands.image')
            ->get();
        $categories = Category::orderBy('categories.id', 'DESC')
            ->join('products', 'products.category_id', '=', 'categories.id')
            ->where('categories.is_active', true)
            ->where('categories.parent_id', null)
            ->where('products.is_active', true)
            ->select('categories.id', 'categories.name')
            ->distinct('categories.name')
            ->limit(5)
            ->get();
        $carts = Cart::where('user_ip', request()->ip())->where('session', $session)->latest()->get();
        $subtotal = Cart::all()->where('user_ip', request()->ip())->where('session', $session)->sum(function($t){
            return $t->product_price * $t->product_quantity;
        });
        $product_category   = Category::orderBy('categories.id', 'DESC')
            ->join('products', 'products.category_id', '=', 'categories.id')
            ->where('products.category_id', '=', $cat_id)
            ->where('products.price', '>=', $min)
            ->where('products.price', '<=', $max)
            ->where('products.is_active', true)
            ->select('products.*')
            ->paginate(8);
        $next_products = Product::where('is_active', true)
            ->orderBy('id', 'DESC')
            ->skip(3)
            ->take(3)
            ->get();

        return view('eshop.price_search', compact('brands_product','categories', 'product_category', 'carts', 'subtotal', 'brands', 'cat_id', 'cat_name', 'cat', 'products', 'next_products'));


    }




    public function tag_product(Request $request)
    {

        $cat_parent_id = Category::where('name','=','Sample')->first()->id;
        $catgory_parent = Category::where('parent_id', $cat_parent_id)->get();

        foreach ($catgory_parent as $row){
            $cat_p_id[] = $row->id;
        }


        $brand_parent_id = Brand::where('title','=','Invisible')->first()->id;
        $brand_parent = Brand::where('parent_id', $brand_parent_id)->get();

        foreach ($brand_parent as $row){
            $brand_p_id[] = $row->id;
        }


        $tag_id = $request->tag_id;
        $tags_product = ProductTag::join('products', 'product_tags.product_id', '=', 'products.id')
            ->where('product_tags.tag_id',$tag_id)
            ->whereNotIn('products.category_id', $cat_p_id)
            ->whereNotIn('products.brand_id', $brand_p_id)
            ->where('products.is_active', true)
            ->select('products.*')
            ->get();
        $data = array();
        if(!empty($tags_product))
        {
            foreach ($tags_product as $key=>$row)
            {

                $image =  $row->image;
                $image = explode(',',$image);
                $first_image = $image[0];

                $brands = Brand:: where('id',$row->brand_id)->first();
                $cat_names = \App\Category::where('id',$row->category_id)->first();

                $nestedData['id'] = $row->id;
                $nestedData['name'] = $row->name;
                $nestedData['cat_name'] = $cat_names->name;
                //$nestedData['image']    = '<img src="'.url('public/images/product', $first_image).'"height: auto; width: auto; margin: auto;">';
                $nestedData['image']        = $first_image;
                //  $nestedData['brand_image']  = '<img src="' .url('public/images/brand', $brands->image).'" alt="product" >';
                $nestedData['brand_image']  = $first_image;
                $nestedData['price'] = $row->price;
                $nestedData['qty'] = $row->qty;
                $nestedData['promotion'] = $row->promotion;
                $nestedData['promotion_price'] = $row->promotion_price;
                // $nestedData['product'] = array( '[ "'.$row->id.'"', ' "'.$row->name.'"', ' "'.$nestedData['cat_name'].'"', ' "'.$nestedData['image'].'"', ' "'.$nestedData['brand_image'].'"', ' "'.$row->price.'"',' "'.$row->qty.'"]');
                $data[] = $nestedData;

            }
        }

        return  $data ;
    }



    public function brand_filter_search(Request $request)
    {


        $session = \Session::getId();
        $brand_id = $request->brand_id;
        $min = $request->min;
        $max = $request->max;
        $brands     = Brand::orderBy('title', 'ASC')->where('is_active', true)->where('title','!=','OTHERS')->where('parent_id', NULL)->get();
        $brand_name = Brand::where('id', $brand_id)->first();
        // dd($brand_name);
        $categories = Category::orderBy('categories.id', 'DESC')
            ->join('products', 'products.category_id', '=', 'categories.id')
            ->where('categories.is_active', true)
            ->where('categories.parent_id', null)
            ->where('products.is_active', true)
            // ->where('products.is_active', 1)
            ->select('categories.id', 'categories.name')
            ->distinct('categories.name')
            ->limit(5)
            ->get();
        $carts = Cart::where('user_ip', request()->ip())->where('session', $session)->latest()->get();
        $subtotal = Cart::all()->where('user_ip', request()->ip())->where('session', $session)->sum(function($t){
            return $t->product_price * $t->product_quantity;
        });
        $brands_product = Product::orderBy('id', 'DESC')
            ->where('is_active', true)
            ->where('brand_id', $brand_id)
            ->where('price', '>=', $min)
            ->where('price', '<=', $max)
            ->get();
        // dd($brands_product);
        $products = Product::where('is_active', true)
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get();
        $next_products = Product::where('is_active', true)
            ->orderBy('id', 'DESC')
            ->skip(3)
            ->take(3)
            ->get();
        return view('eshop.brand-price-search', compact('brands','categories', 'carts', 'subtotal', 'brands_product', 'products', 'next_products', 'brand_name'));

    }






    public function wishlist_login_check()
    {

//        if (Auth::user() == null){
        return back()->with('wishlist_login', 6);

//        }else{
//            return back()->with('wishlist', 7);
//        }



    }

    public function quick_view_check()
    {
//        if (Auth::user() == null){
        return back()->with('quick_view', 8);

//        }else{
//            return back()->with('wishlist', 7);
//        }



    }


    public function quick_view($id)
    {


        $product  = Product::orderBy('id', 'DESC')
            ->join('brands', 'brands.id', '=', 'products.brand_id')
            ->where('products.id', '=', $id)
            ->select('products.*')
            ->first();

        return back()->with( [
            'quick_view' => 9,
            'product_details_info' => $product,
        ]);
    }


    public function wishlist($id)
    {

        $data['product_id']  = $id;
        $user_id = Auth::user()->id;
       // dd($user_id);
        $data['customer_id'] = Customer::where('user_id',$user_id)->first()->id;
        $data['date']        = Carbon::now()->format('Y-m-d');
        Wishlist::create($data);
        return back()->with('wishlist', 7);
    }


}



