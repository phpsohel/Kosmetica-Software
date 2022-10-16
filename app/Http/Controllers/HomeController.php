<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductTag;
use App\Tags;
use Illuminate\Http\Request;
use App\Sale;
use App\Returns;
use App\ReturnPurchase;
use App\Purchase;
use App\Expense;
use App\Payroll;
use App\Quotation;
use App\Payment;
use App\Account;
use App\Product_Sale;
use App\Customer;
use App\Blog;
use DB;
use Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        return view('home');
    }

    public function expire()
    {
        return view('expire');
    }

    public function add_blog()
    {
        //dd('ok');
        return view('blog.add_blog');
    }

    public function save_blog(Request $request)
    {
//     dd($request->all());
        $request->validate([
            'blog_title'  => 'required',
            'blog_title_ar'  => 'required',
            'blog'=> 'required',
            'blog_ar'=> 'required',
            'blog_image'=> 'required|mimes:jpg,jpeg,png'
        ]);
        $blog_image = $request->file('blog_image');

        $name_generator  = hexdec(uniqid());
        $image_extension = strtolower($blog_image->getClientOriginalExtension());
        $image_name      = $name_generator.'.'.$image_extension;
        $up_location     = 'public/images/blogs/';
        $last_image      = $up_location.$image_name;

        $blog_image->move($up_location,$image_name);

        $blog = new Blog;

        $blog->blog_title            = $request->blog_title;
        $blog->blog_title_ar         = $request->blog_title_ar;
        $blog->blog                  = $request->blog;
        $blog->blog_ar                  = $request->blog_ar;
        $blog->featured              = $request->featured;
        $blog->blog_image            = $last_image;
        $blog->save();
        return redirect('/blog-list');
    }

    //blog list
    public function blog_list()
    {
        $blogs = Blog::orderBy('id', 'DESC')->get();
        return view('blog.blog_list', compact('blogs'));
    }
    //edit blog
    public function edit_blog($id)
    {
        $blog = Blog::orderBy('id', 'DESC')
            ->where('id', $id)
            ->first();
        return view('blog.edit_blog', compact('blog'));
    }
    //updeate blog
    public function update_blog(Request $request)
    {
        // return $request; exit();
        $request->validate([

            'blog_title'  => 'required',
            'blog_title_ar'  => 'required',
            'blog'=> 'required',
            'blog_ar'=> 'required'
            // 'blog_image'=> 'required|mimes:jpg,jpeg,png'

        ]);

        $blog_image_old = $request->blog_image_old;

        $blog_image = $request->file('blog_image');

        if($blog_image){

            $name_generator  = hexdec(uniqid());
            $image_extension = strtolower($blog_image->getClientOriginalExtension());
            $image_name      = $name_generator.'.'.$image_extension;
            $up_location     = 'public/images/blogs/';
            $last_image      = $up_location.$image_name;


            $blog_image->move($up_location,$image_name);


            unlink($blog_image_old);

            $blog = Blog::find($request->id);

            $blog->blog_title            = $request->blog_title;
            $blog->blog_title_ar         = $request->blog_title_ar;
            $blog->blog                  = $request->blog;
            $blog->blog_ar               = $request->blog_ar;
            $blog->blog_image            = $last_image;

            $blog->save();
        }

        else{

            $blog = Blog::find($request->id);

            $blog->blog_title            = $request->blog_title;
            $blog->blog_title_ar            = $request->blog_title_ar;
            $blog->blog                  = $request->blog;
            $blog->blog_ar                  = $request->blog_ar;

            $blog->save();
        }

        return redirect('/blog-list');
    }
    //delete blog
    public function delete_blog($id)
    {
        $blog = Blog::find($id);

        $blog_image_old = $blog->blog_image;
        unlink($blog_image_old);


        $blog->delete();

        return redirect('/blog-list');
    }

    public function index()
    {
        if(Auth::user()->role_id == 5) {
            $customer = Customer::select('id')->where('user_id', Auth::id())->first();
            $lims_sale_data = Sale::with('warehouse')->where('customer_id', $customer->id)->orderBy('created_at', 'desc')->get();
            // return view('customer_index', compact('lims_sale_data'));
            return redirect('/eshop/profile');
        }

        $start_date = date("Y").'-'.date("m").'-'.'01';
        $end_date = date("Y").'-'.date("m").'-'.date('t', mktime(0, 0, 0, date("m"), 1, date("Y")));
        $yearly_sale_amount = [];

        $general_setting = DB::table('general_settings')->latest()->first();

        if(Auth::user()->role_id > 2 && $general_setting->staff_access == 'own') {
            $revenue = Sale::whereDate('created_at', '>=' , $start_date)->where('user_id', Auth::id())->whereDate('created_at', '<=' , $end_date)->sum('grand_total');
            $return = Returns::whereDate('created_at', '>=' , $start_date)->where('user_id', Auth::id())->whereDate('created_at', '<=' , $end_date)->sum('grand_total');
            $purchase_return = ReturnPurchase::whereDate('created_at', '>=' , $start_date)->where('user_id', Auth::id())->whereDate('created_at', '<=' , $end_date)->sum('grand_total');
            $revenue = $revenue - $return;
            $purchase = Purchase::whereDate('created_at', '>=' , $start_date)->where('user_id', Auth::id())->whereDate('created_at', '<=' , $end_date)->sum('grand_total');
            $profit = $revenue + $purchase_return - $purchase;
            $expense = Expense::whereDate('created_at', '>=' , $start_date)->where('user_id', Auth::id())->whereDate('created_at', '<=' , $end_date)->sum('amount');
            $recent_sale = Sale::orderBy('id', 'desc')->where('user_id', Auth::id())->take(5)->get();
            $recent_purchase = Purchase::orderBy('id', 'desc')->where('user_id', Auth::id())->take(5)->get();
            $recent_quotation = Quotation::orderBy('id', 'desc')->where('user_id', Auth::id())->take(5)->get();
            $recent_payment = Payment::orderBy('id', 'desc')->where('user_id', Auth::id())->take(5)->get();
        }
        else {
            $revenue = Sale::whereDate('created_at', '>=' , $start_date)->whereDate('created_at', '<=' , $end_date)->sum('grand_total');
            $return = Returns::whereDate('created_at', '>=' , $start_date)->whereDate('created_at', '<=' , $end_date)->sum('grand_total');
            $purchase_return = ReturnPurchase::whereDate('created_at', '>=' , $start_date)->whereDate('created_at', '<=' , $end_date)->sum('grand_total');
            $revenue = $revenue - $return;
            $purchase = Purchase::whereDate('created_at', '>=' , $start_date)->whereDate('created_at', '<=' , $end_date)->sum('grand_total');
            $profit = $revenue + $purchase_return - $purchase;
            $expense = Expense::whereDate('created_at', '>=' , $start_date)->whereDate('created_at', '<=' , $end_date)->sum('amount');
            $recent_sale = Sale::orderBy('id', 'desc')->take(5)->get();
            $recent_purchase = Purchase::orderBy('id', 'desc')->take(5)->get();
            $recent_quotation = Quotation::orderBy('id', 'desc')->take(5)->get();
            $recent_payment = Payment::orderBy('id', 'desc')->take(5)->get();
        }

        $best_selling_qty = Product_Sale::select('products.code','products.name',DB::raw('product_sales.product_id, sum(product_sales.qty) as sold_qty'))
            ->join('products', 'products.id', '=', 'product_sales.product_id', 'left')
            ->whereDate('product_sales.created_at', '>=' , $start_date)
            ->whereDate('product_sales.created_at', '<=' , $end_date)
            ->groupBy('product_sales.product_id')
            ->groupBy('products.name')
            ->groupBy('products.code')
            ->orderBy('sold_qty', 'desc')
            ->take(5)
            ->get();

        // return  $best_selling_qty; exit();

        $yearly_best_selling_qty = Product_Sale::select(DB::raw('product_id, sum(qty) as sold_qty'))->whereDate('created_at', '>=' , date("Y").'-01-01')->whereDate('created_at', '<=' , date("Y").'-12-31')->groupBy('product_id')->orderBy('sold_qty', 'desc')->take(5)->get();

        // return  $yearly_best_selling_qty; exit();

        $yearly_best_selling_price = Product_Sale::select('products.code','products.name',DB::raw('product_sales.product_id, sum(product_sales.total) as total_price'))
            ->join('products', 'products.id', '=', 'product_sales.product_id', 'left')
            ->whereDate('product_sales.created_at', '>=' , date("Y").'-01-01')
            ->whereDate('product_sales.created_at', '<=' , date("Y").'-12-31')
            ->groupBy('product_sales.product_id')
            ->groupBy('products.name')
            ->groupBy('products.code')
            ->orderBy('total_price', 'desc')
            ->take(5)
            ->get();

        // return  $yearly_best_selling_price; exit();

        //cash flow of last 6 months
        $start = strtotime(date('Y-m-01', strtotime('-6 month', strtotime(date('Y-m-d') ))));
        $end = strtotime(date('Y-m-'.date('t', mktime(0, 0, 0, date("m"), 1, date("Y")))));

        while($start < $end)
        {
            $start_date = date("Y-m", $start).'-'.'01';
            $end_date = date("Y-m", $start).'-'.'31';

            if(Auth::user()->role_id > 2 && $general_setting->staff_access == 'own') {
                $recieved_amount = DB::table('payments')->whereNotNull('sale_id')->whereDate('created_at', '>=' , $start_date)->whereDate('created_at', '<=' , $end_date)->where('user_id', Auth::id())->sum('amount');
                $sent_amount = DB::table('payments')->whereNotNull('purchase_id')->whereDate('created_at', '>=' , $start_date)->whereDate('created_at', '<=' , $end_date)->where('user_id', Auth::id())->sum('amount');
                $return_amount = Returns::whereDate('created_at', '>=' , $start_date)->whereDate('created_at', '<=' , $end_date)->where('user_id', Auth::id())->sum('grand_total');
                $purchase_return_amount = ReturnPurchase::whereDate('created_at', '>=' , $start_date)->whereDate('created_at', '<=' , $end_date)->where('user_id', Auth::id())->sum('grand_total');
                $expense_amount = Expense::whereDate('created_at', '>=' , $start_date)->whereDate('created_at', '<=' , $end_date)->where('user_id', Auth::id())->sum('amount');
                $payroll_amount = Payroll::whereDate('created_at', '>=' , $start_date)->whereDate('created_at', '<=' , $end_date)->where('user_id', Auth::id())->sum('amount');
            }
            else {
                $recieved_amount = DB::table('payments')->whereNotNull('sale_id')->whereDate('created_at', '>=' , $start_date)->whereDate('created_at', '<=' , $end_date)->sum('amount');
                $sent_amount = DB::table('payments')->whereNotNull('purchase_id')->whereDate('created_at', '>=' , $start_date)->whereDate('created_at', '<=' , $end_date)->sum('amount');
                $return_amount = Returns::whereDate('created_at', '>=' , $start_date)->whereDate('created_at', '<=' , $end_date)->sum('grand_total');
                $purchase_return_amount = ReturnPurchase::whereDate('created_at', '>=' , $start_date)->whereDate('created_at', '<=' , $end_date)->sum('grand_total');
                $expense_amount = Expense::whereDate('created_at', '>=' , $start_date)->whereDate('created_at', '<=' , $end_date)->sum('amount');
                $payroll_amount = Payroll::whereDate('created_at', '>=' , $start_date)->whereDate('created_at', '<=' , $end_date)->sum('amount');
            }
            $sent_amount = $sent_amount + $return_amount + $expense_amount + $payroll_amount;

            $payment_recieved[] = number_format((float)($recieved_amount + $purchase_return_amount), 2, '.', '');
            $payment_sent[] = number_format((float)$sent_amount, 2, '.', '');
            $month[] = date("F", strtotime($start_date));
            $start = strtotime("+1 month", $start);
        }
        // yearly report
        $start = strtotime(date("Y") .'-01-01');
        $end = strtotime(date("Y") .'-12-31');
        while($start < $end)
        {
            $start_date = date("Y").'-'.date('m', $start).'-'.'01';
            $end_date = date("Y").'-'.date('m', $start).'-'.'31';
            if(Auth::user()->role_id > 2 && $general_setting->staff_access == 'own') {
                $sale_amount = Sale::whereDate('created_at', '>=' , $start_date)->whereDate('created_at', '<=' , $end_date)->where('user_id', Auth::id())->sum('grand_total');
                $purchase_amount = Purchase::whereDate('created_at', '>=' , $start_date)->whereDate('created_at', '<=' , $end_date)->where('user_id', Auth::id())->sum('grand_total');
            }
            else{
                $sale_amount = Sale::whereDate('created_at', '>=' , $start_date)->whereDate('created_at', '<=' , $end_date)->sum('grand_total');
                $purchase_amount = Purchase::whereDate('created_at', '>=' , $start_date)->whereDate('created_at', '<=' , $end_date)->sum('grand_total');
            }
            $yearly_sale_amount[] = number_format((float)$sale_amount, 2, '.', '');
            $yearly_purchase_amount[] = number_format((float)$purchase_amount, 2, '.', '');
            $start = strtotime("+1 month", $start);
        }
        //return $month;
        return view('index', compact('revenue', 'purchase', 'expense', 'return', 'purchase_return', 'profit', 'payment_recieved', 'payment_sent', 'month', 'yearly_sale_amount', 'yearly_purchase_amount', 'recent_sale', 'recent_purchase', 'recent_quotation', 'recent_payment', 'best_selling_qty', 'yearly_best_selling_qty', 'yearly_best_selling_price'));
    }

    public function dashboardFilter($start_date, $end_date)
    {
        $general_setting = DB::table('general_settings')->latest()->first();
        if(Auth::user()->role_id > 2 && $general_setting->staff_access == 'own') {
            $revenue = Sale::whereDate('created_at', '>=' , $start_date)->whereDate('created_at', '<=' , $end_date)->where('user_id', Auth::id())->sum('grand_total');
            $return = Returns::whereDate('created_at', '>=' , $start_date)->whereDate('created_at', '<=' , $end_date)->where('user_id', Auth::id())->sum('grand_total');
            $purchase_return = ReturnPurchase::whereDate('created_at', '>=' , $start_date)->whereDate('created_at', '<=' , $end_date)->where('user_id', Auth::id())->sum('grand_total');
            $revenue -= $return;
            $purchase = Purchase::whereDate('created_at', '>=' , $start_date)->whereDate('created_at', '<=' , $end_date)->where('user_id', Auth::id())->sum('grand_total');
            $profit = $revenue + $purchase_return - $purchase;

            $data[0] = $revenue;
            $data[1] = $return;
            $data[2] = $profit;
            $data[3] = $purchase_return;
        }
        else{
            $revenue = Sale::whereDate('created_at', '>=' , $start_date)->whereDate('created_at', '<=' , $end_date)->sum('grand_total');
            $return = Returns::whereDate('created_at', '>=' , $start_date)->whereDate('created_at', '<=' , $end_date)->sum('grand_total');
            $purchase_return = ReturnPurchase::whereDate('created_at', '>=' , $start_date)->whereDate('created_at', '<=' , $end_date)->sum('grand_total');
            $revenue -= $return;
            $purchase = Purchase::whereDate('created_at', '>=' , $start_date)->whereDate('created_at', '<=' , $end_date)->sum('grand_total');
            $profit = $revenue + $purchase_return - $purchase;

            $data[0] = $revenue;
            $data[1] = $return;
            $data[2] = $profit;
            $data[3] = $purchase_return;
        }

        return $data;
    }

    public function myTransaction($year, $month)
    {
        $start = 1;
        $number_of_day = date('t', mktime(0, 0, 0, $month, 1, $year));
        while($start <= $number_of_day)
        {
            if($start < 10)
                $date = $year.'-'.$month.'-0'.$start;
            else
                $date = $year.'-'.$month.'-'.$start;
            $sale_generated[$start] = Sale::whereDate('created_at', $date)->where('user_id', Auth::id())->count();
            $sale_grand_total[$start] = Sale::whereDate('created_at', $date)->where('user_id', Auth::id())->sum('grand_total');
            $purchase_generated[$start] = Purchase::whereDate('created_at', $date)->where('user_id', Auth::id())->count();
            $purchase_grand_total[$start] = Purchase::whereDate('created_at', $date)->where('user_id', Auth::id())->sum('grand_total');
            $quotation_generated[$start] = Quotation::whereDate('created_at', $date)->where('user_id', Auth::id())->count();
            $quotation_grand_total[$start] = Quotation::whereDate('created_at', $date)->where('user_id', Auth::id())->sum('grand_total');
            $start++;
        }
        $start_day = date('w', strtotime($year.'-'.$month.'-01')) + 1;
        $prev_year = date('Y', strtotime('-1 month', strtotime($year.'-'.$month.'-01')));
        $prev_month = date('m', strtotime('-1 month', strtotime($year.'-'.$month.'-01')));
        $next_year = date('Y', strtotime('+1 month', strtotime($year.'-'.$month.'-01')));
        $next_month = date('m', strtotime('+1 month', strtotime($year.'-'.$month.'-01')));
        return view('user.my_transaction', compact('start_day', 'year', 'month', 'number_of_day', 'prev_year', 'prev_month', 'next_year', 'next_month', 'sale_generated', 'sale_grand_total','purchase_generated', 'purchase_grand_total','quotation_generated', 'quotation_grand_total'));
    }


// add tag
    public function add_tag()
    {
        return view('tag.add_tag');
    }


    public function store_tag(Request $request)
    {
        $tag_image = $request->file('image');
        $name_generator  = hexdec(uniqid());
        $image_extension = strtolower($tag_image->getClientOriginalExtension());
        $image_name      = $name_generator.'.'.$image_extension;
        $up_location     = 'public/images/tags/';
        $last_image      = $up_location.$image_name;
        $tag_image->move($up_location,$image_name);

        $tag        = new Tags();
        $tag->tag_name         = $request->tag_name;
        $tag->tag_name_ar         = $request->tag_name_ar;
        $tag->tag_parent_name  = $request->tag_parent_name;
        $tag->image            = $last_image;
        $tag->status            = 1;
        $tag->save();
        return redirect('/tag-list');

    }

    //tag list
    public function tag_list()
    {
        $tags = Tags::orderBy('id', 'DESC')->get();
        return view('tag.tag_list', compact('tags'));
    }



    //edit tag
    public function edit_tag($id)
    {
        $tag = Tags::where('id', $id)
            ->first();
        //dd($tag);
        return view('tag.edit_tag', compact('tag'));
    }

    //updeate tag
    public function update_tag(Request $request)
    {
        $image_old = $request->image_old;
        $tag_image = $request->file('image');
        if($tag_image){
            $name_generator  = hexdec(uniqid());
            $image_extension = strtolower($tag_image->getClientOriginalExtension());
            $image_name      = $name_generator.'.'.$image_extension;
            $up_location     = 'public/images/tags/';
            $last_image      = $up_location.$image_name;
            $tag_image->move($up_location,$image_name);
            unlink($image_old);
            $tag = Tags::find($request->id);
            $tag->tag_name         = $request->tag_name;
            $tag->tag_name_ar         = $request->tag_name_ar;
            $tag->tag_parent_name  = $request->tag_parent_name;
            $tag->image            = $last_image;
            $tag->status            = 1;
            $tag->save();
        }

        else{
            $tag = Tags::find($request->id);
            $tag->tag_name         = $request->tag_name;
            $tag->tag_name_ar         = $request->tag_name_ar;
            $tag->tag_parent_name  = $request->tag_parent_name;
            $tag->status            = 1;
            $tag->save();
        }
        return redirect('/tag-list');
    }

    //delete tag
    public function delete_tag($id)
    {
        $tag = Tags::find($id);
        $image_old = $tag->image;
        unlink($image_old);
        $tag->delete();
        return redirect('/tag-list');
    }


// add product tag
    public function add_product_tag()
    {
        $tags = Tags::get();
        $products = Product::where('is_active', true)->get();
       // $product_tag = ProductTag::where('id','DESC')->first();
        return view('product_tag.add_product_tag',compact('tags','products'));
    }

    // Product tag list
    public function product_tag_list()
    {
        $product_tags = ProductTag::orderBy('id', 'DESC')->get();
       // dd($product_tags);
        return view('product_tag.product_tag_list', compact('product_tags'));
    }


    public function getProduct($id)
    {
        $lims_product_data = Product::find($id);
        return $lims_product_data->code;
    }


    public function store_product_tag(Request $request)
    {

        $tag_id =$request->tag_id;
        if($tag_id){
            for($i=0;$i<count($request->tag_id);$i++){
                $data= New ProductTag();
                $data->tag_id=$request->tag_id[$i];
                $data->product_id=$request->product_id;
                $data->save();
            }
        }
        return redirect('/product/tag-list');

    }




    //edit Product tag
    public function edit_product_tag($id)
    {
        $tags = Tags::get();
        $products = Product::where('is_active', true)->get();
        $product_tag = ProductTag::where('id', $id)
            ->first();
        return view('product_tag.edit_product_tag', compact('product_tag','tags','products'));
    }



    //updeate tag
    public function update_product_tag(Request $request)
    {

        $tag_id =$request->tag_id;
        if($tag_id){
            for($i=0;$i<count($request->tag_id);$i++){
                $data= ProductTag::find($request->id);
                $data->tag_id=$request->tag_id[$i];
                $data->product_id=$request->product_id;
                $data->save();
            }
        }
        return redirect('/product/tag-list');

    }



    //delete tag
    public function delete_product_tag($id)
    {
        $product_tag = ProductTag::find($id);

        $product_tag->delete();
        return redirect('/product/tag-list');
    }











}
