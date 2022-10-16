<?php $__env->startSection('home_content'); ?>
<style>
.ratings-table thead {
    display: contents;
}
.ratings-table tbody td {
    border-bottom: 1px solid #ebebeb !important;
}
@media  screen and (max-width: 600px) {
  .nav{
    flex-wrap: inherit;
     -webkit-overflow-scrolling: touch;
    }
    .nav.nav-tabs {
        overflow-y: scroll;
        overflow-x: auto;
    }
    .nav.nav-tabs .nav-item .nav-link {
        width:max-content;
    }
}

</style>
    <?php
         $cat_name = \App\Category::where('id',$product->category_id)->first();
           $name=  str_replace(' ', '-', $product->name);
    ?>
 <main class="main">
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb"style="float: right">
                        <li class="breadcrumb-item active" aria-current="page"><?php echo e($product->name_ar); ?></li>
                        <li class="breadcrumb-item"><a href="<?php echo e(route('all-categories.ar',$product->category_id)); ?>"><?php echo e($cat_name->name_ar); ?></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo e(route('eshop.ar')); ?>"><i class="icon-home"></i></a></li>
                    </ol>
                </div><!-- End .container -->
            </nav>

     <?php
             $name=  str_replace(' ', '-', $product->name);
             $image =  $product->image;
             $images = explode(',',$image);
     ?>
            <div class="container">
                <br>
                <br>
                <br>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product-single-container product-single-default">
                            <div class="row">

                                <?php
                                    $comments = \App\Review::where('product_id',$product->id)->where('comment' ,'!=', null)->orderBy('id','DESC')->get();
                                ?>
                                <?php if($product->brand_id != null): ?>

                                    <?php
                                        $brand_name = \App\Brand::where('id',$product->brand_id)->first();

                                         // dd($brand_name);
                                    ?>

                                <?php endif; ?>
                                <div class="col-lg-7 col-md-6">
                                    <div class="product-single-details">
                                        <p style='font-weight:bold;margin-bottom:0px;'><a href="<?php echo e(route('brands-product.ar', $product->brand_id)); ?>"><?php echo e($brand_name->title_ar); ?></a> </p>
                                        <span style="font-size: 20px;" class="product-title"><?php echo e($product->name_ar); ?></span>
                                        <br>
                                        <?php
                                            $full_rating = 0 ;
                                            $rating = \App\Review::where('product_id',$product->id)->select('ratings')->get();
                                            $total_rating = $rating->sum('ratings');
                                            $total_customer =count($rating);
                                            if ($total_customer > 0 ){
                                            $avg_rating = ($total_rating/$total_customer);
                                            $full_rating = $avg_rating;
                                            }else{
                                            $avg_rating = 0;
                                            }
                                            $half_rating = 0;
                                            $full_rating = (int)$full_rating;
                                            $half_rating = $avg_rating - $full_rating ;
                                            $un_rating = (int)(5 - $avg_rating) ;
                                        ?>

                                        <div>
                                            <?php for($i = 1 ; $i <= $full_rating ;$i++ ): ?>
                                                <span><i class="fa fa-star" style="font-size:18px"></i></span>
                                            <?php endfor; ?>

                                            <?php if( $half_rating > 0  && $half_rating < 1 ): ?>
                                                <i class="fa fa-star-half-o" style="font-size:18px" aria-hidden="true"></i>
                                            <?php endif; ?>
                                            <?php for($j = 1 ; $j <= $un_rating ;$j++ ): ?>
                                                <span><i class="fa fa-star-o" style="font-size:18px"></i></span>
                                            <?php endfor; ?>
                                            <p> (<?php echo e(count($comments)); ?> <?php if( count($comments) > 1 ): ?> reviews <?php else: ?> review )  <?php endif; ?>  </p>
                                        </div>

                                        <div class="price-box">
                                            <?php if($product->promotion == null): ?>
                                                <span class="product-price">৳<?php echo e($product->price); ?></span>
                                            <?php else: ?>
                                                <span class="old-price">৳<?php echo e($product->price); ?></span>
                                                <span class="product-price">৳<?php echo e($product->promotion_price); ?></span>
                                            <?php endif; ?>
                                        </div><!-- End .price-box -->

                                        <div class="product-desc">
                                            <textarea style="display: none;" id="editorCopy" name="body"><?php echo e(\Illuminate\Support\Str::limit($product->product_details, 260, '......')); ?></textarea>
                                            <textarea style="display: none;" id="editorCopy1" name="body"><?php echo e($product->product_details); ?></textarea>

                                            

                                            

                                        </div><!-- End .product-desc -->
                                        <?php if($product->type == 'combo' && $product->product_list != null && $product->qty_list !=null ): ?>
                                            <?php
                                                $com_pro_id = explode(',',$product->product_list);
                                                $com_pro_qty = explode(',',$product->qty_list);
                                            ?>

                                            <?php for($i = 0; $i < count($com_pro_id); $i++): ?>
                                                <?php
                                                    $combo[] =   \App\Product::where('id',$com_pro_id[$i])->where('qty','>=',$com_pro_qty[$i])->first();
                                                ?>

                                            <?php endfor; ?>

                                            <?php if(in_array(null, $combo, true)): ?>
                                                <p> <bold>التوفر : </bold> <strong style="color: red"> Stock Unavailable</strong> <?php if($brand_name->notes != null): ?><strong style="color: red"> (<?php echo e($brand_name->notes); ?>)</strong> <?php endif; ?></p>

                                            <?php else: ?>
                                                <p>  <bold>التوفر : </bold><strong  style="color: #eb6006"> كمية محدودة</strong></p>
                                                <form action="<?php echo e(route('add-cart-quantity.ar', $product->id)); ?>" method="post">
                                                    <?php echo csrf_field(); ?>
                                                    <div class="product-action product-all-icons">
                                                        <input type="hidden" name="product_price" value="<?php echo e($product->price); ?>">
                                                        <input type="hidden" name="promotion_price" value="<?php echo e($product->promotion_price); ?>">
                                                        <div class="product-single-qty">
                                                            <input class="horizontal-quantity form-control" type="number" value="1" min="1" name="quantity">
                                                        </div><!-- End .product-single-qty -->
                                                        <button type="submit" class="paction"><i class="icon-bag"></i>أضف إلى السلة</button>
                                                        <?php if(Auth::user() == null): ?>
                                                            <a href="<?php echo e(route('eshop-wishlist-login-check.ar', $product->id)); ?>" class=" paction add-wishlist btn-add-login icon-wish" title="أضف إلى قائمة الامنيات"></a>
                                                        <?php else: ?>
                                                            <a href="<?php echo e(route('eshop-wishlist.ar', $product->id)); ?>" class="paction add-wishlist icon-wish" title="أضف إلى قائمة الامنيات" ></a>
                                                        <?php endif; ?>
                                                    </div><!-- End .product-action -->
                                                </form>

                                            <?php endif; ?>

                                        <?php else: ?>

                                            <?php
                                                $stock_available = \App\Product_Warehouse::where('product_id',$product->id)->where('qty','>',0 )->get()->count();
                                            ?>

                                            <?php if($stock_available == 6): ?>

                                                <p > <bold>التوفر : </bold><strong style="color: green">مخزون متاح</strong></p>
                                            <?php elseif($stock_available > 0 && $stock_available < 6 ): ?>
                                                <p>  <bold>التوفر : </bold><strong  style="color: #eb6006"> كمية محدودة</strong></p>
                                            <?php else: ?>
                                                <p> <bold>التوفر : </bold> <strong style="color: red"> مخزون متاح</strong> <?php if($brand_name->notes != null): ?><strong style="color: red"> (<?php echo e($brand_name->notes); ?>)</strong> <?php endif; ?></p>
                                            <?php endif; ?>

                                            <form action="<?php echo e(route('add-cart-quantity.ar', $product->id)); ?>" method="post">
                                                <?php echo csrf_field(); ?>
                                                <div class="product-action product-all-icons">
                                                    <input type="hidden" name="product_price" value="<?php echo e($product->price); ?>">
                                                    <input type="hidden" name="promotion_price" value="<?php echo e($product->promotion_price); ?>">

                                                    <?php if($product->qty > 0): ?>
                                                        <div class="product-single-qty">
                                                            <input class="horizontal-quantity form-control" type="number" value="1" min="1" name="quantity">
                                                        </div><!-- End .product-single-qty -->
                                                        <button type="submit" class="paction"><i class="icon-bag"></i>أضف إلى السلة</button>
                                                    <?php else: ?>
                                                    <?php endif; ?>

                                                    <?php if(Auth::user() == null): ?>
                                                        <a href="<?php echo e(route('eshop-wishlist-login-check.ar', $product->id)); ?>" class=" paction add-wishlist btn-add-login icon-wish" title="Add to Wishlist"></a>
                                                    <?php else: ?>
                                                        <a href="<?php echo e(route('eshop-wishlist.ar', $product->id)); ?>" class="paction add-wishlist icon-wish" title="Add to Wishlist" ></a>
                                                    <?php endif; ?>
                                                </div><!-- End .product-action -->
                                            </form>

                                        <?php endif; ?>

                                        <div class="product-single-share" style="margin-bottom:30px;">
                                            <label>شارك:</label>
                                            <!-- www.addthis.com share plugin-->
                                            <div class="addthis_inline_share_toolbox"></div>
                                        </div><!-- End .product single-share -->
                                    </div><!-- End .product-single-details -->
                                    <div class="product-single-tabs">
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="product-tab-desc" data-toggle="tab" href="#product-desc-content" role="tab" aria-controls="product-desc-content" aria-selected="true">تفاصيل</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="product-tab-tags" data-toggle="tab" href="#product-ingredients-content" role="tab" aria-controls="product-ingredients-content" aria-selected="false">مكونات</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="product-tab-reviews" data-toggle="tab" href="#product-use-content" role="tab" aria-controls="product-use-content" aria-selected="false">كيف تستعمل</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="product-tab-reviews" data-toggle="tab" href="#product-stock-content" role="tab" aria-controls="product-stock-content" aria-selected="false">المخزون المتوفر</a>
                                            </li>

                                            <li class="nav-item">
                                                <a class="nav-link" id="product-tab-reviews" data-toggle="tab" href="#product-reviews-content" role="tab" aria-controls="product-reviews-content" aria-selected="false">المراجعات( <?php echo e(count($comments)); ?>)</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane fade show active" id="product-desc-content" role="tabpanel" aria-labelledby="product-tab-desc">
                                                <div class="product-desc-content">
                                                    <div id="editor1"></div>
                                                </div><!-- End .product-desc-content -->
                                            </div><!-- End .tab-pane -->

                                            <div class="tab-pane fade" id="product-ingredients-content" role="tabpanel" aria-labelledby="product-tab-tags">
                                                <div class="product-ingredients-content">
                                                    <?php echo $product->ingredients_ar; ?>

                                                </div><!-- End .product-tags-content -->
                                            </div><!-- End .tab-pane -->

                                            <div class="tab-pane fade" id="product-use-content" role="tabpanel" aria-labelledby="product-tab-reviews">
                                                <div class="product-use-content">
                                                    <?php echo $product->how_to_use_ar; ?>

                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="product-reviews-content" role="tabpanel" aria-labelledby="product-tab-reviews">
                                                <div class="product-reviews-content">

                                                    <div class="product-reviews-content">
                                                        <h3 class="reviews-title">  <?php echo e(count($comments)); ?> <?php if( count($comments) > 1 ): ?> reviews <?php else: ?> review  <?php endif; ?>  for  <span> <?php echo e($product->name); ?></h3>

                                                        <?php $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php
                                                                $date = $comment->date;
                                                              $format_date =  \Carbon\Carbon::parse($date)->format('M d ,Y');
                                                            ?>
                                                            <div class="comment-list">
                                                                <div class="comments">
                                                                    <div class="comment-block">
                                                                        <div class="comment-header">
                                                                            <div class="comment-arrow"></div>
                                                                            <span class="comment-by">
                                                    <strong><?php echo e($comment->customer->name); ?></strong>
                                                        </span>
                                                                        </div>

                                                                        <div class="comment-content">
                                                                            <p><?php echo e($comment->comment); ?></p>
                                                                        </div>
                                                                        <p> <?php echo e($format_date); ?></p>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                        <div class="divider"></div>

                                                        <div class="add-product-review">
                                                            <h3 class="review-title">Add a review</h3>
                                                            <?php if(Auth::user() == null): ?>
                                                                <span>لإضافة مراجعة ، الرجاء تسجيل الدخول أولا </span>
                                                                <br>
                                                                <a href="<?php echo e(route('eshop-login.ar')); ?>"><button class=" btn btn-primary">تسجيل الدخول</button></a>
                                                            <?php else: ?>
                                                                <form  method="POST" action="<?php echo e(route('review.store')); ?>" class="comment-form m-0">
                                                                    <?php echo csrf_field(); ?>
                                                                    <table class="ratings-table">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>&nbsp;</th>
                                                                            <th>1 star</th>
                                                                            <th>2 stars</th>
                                                                            <th>3 stars</th>
                                                                            <th>4 stars</th>
                                                                            <th>5 stars</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <tr>
                                                                            <td>Rating</td>
                                                                            <td>
                                                                                <input type="radio" name="ratings" id="Quality_1" value="1" class="radio">
                                                                            </td>
                                                                            <td>
                                                                                <input type="radio" name="ratings" id="Quality_2" value="2" class="radio">
                                                                            </td>
                                                                            <td>
                                                                                <input type="radio" name="ratings" id="Quality_3" value="3" class="radio">
                                                                            </td>
                                                                            <td>
                                                                                <input type="radio" name="ratings" id="Quality_4" value="4" class="radio">
                                                                            </td>
                                                                            <td>
                                                                                <input type="radio" name="ratings" id="Quality_5" value="5" class="radio">
                                                                            </td>
                                                                        </tr>


                                                                        </tbody>
                                                                    </table>

                                                                    <div class="form-group">
                                                                        <label> <strong>Your review</strong> <span class="required">*</span></label>
                                                                        <textarea cols="10" rows="6"  name="comment"  class="form-control form-control-sm"></textarea>
                                                                    </div>
                                                                    <input type="submit" class="btn btn-primary" value="Submit">
                                                                    <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                                                                </form>
                                                            <?php endif; ?>
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>

                                            <?php
                                                $warehouse = \App\Warehouse::where('id','!=',2)->where('id','!=',6)->get();
                                            ?>
                                            <div class="tab-pane fade" id="product-stock-content" role="tabpanel" aria-labelledby="product-tab-reviews">
                                                <div class="product-stock-content">
                                                    <table style="width: 95%;" class="ratings-table">
                                                        <thead>
                                                        <tr>
                                                            <th style='width:70%;'>اسم المحل</th>
                                                            <th style='width:30%;'>مخزون متاح</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php $__currentLoopData = $warehouse; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php
                                                                //$warehouse_id[] = $value->id;
                                                                $stock = \App\Product_Warehouse::where('product_id',$product->id)->where('warehouse_id',$value->id)->first();
                                                              // dd($stock);
                                                            ?>
                                                            <tr>
                                                                <td style="text-align: center;"><?php echo e($value->name); ?><br><span style='font-size:13px;font-weight:500;'> <?php echo e($value->address); ?></span></td>
                                                                <?php if($stock): ?>
                                                                    <?php if($stock->qty > 0): ?>
                                                                        <td> <i class="fa fa-check" style='color:green;' aria-hidden="true"></i></td>
                                                                    <?php else: ?>
                                                                        <td><i class="fa fa-times" style='color:#d1223e;' aria-hidden="true"></i></td>
                                                                    <?php endif; ?>
                                                                <?php else: ?>
                                                                    <td><i class="fa fa-times" style='color:#d1223e;' aria-hidden="true"></i></td>
                                                                <?php endif; ?>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </tbody>
                                                    </table>
                                                </div><!-- End .product-reviews-content -->
                                            </div><!-- End .tab-pane -->
                                        </div><!-- End .tab-content -->
                                    </div><!-- End .product-single-tabs -->
                                </div><!-- End .col-lg-5 -->

                                <div class="col-lg-5 col-md-6">
                                    <div class="product-single-gallery">
                                        <div class="product-slider-container product-item">
                                            <div class="product-single-carousel owl-carousel owl-theme">
                                                <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="product-item">
                                                    <img class="product-single-image" src="<?php echo e(url('public/images/product', $image)); ?>" data-zoom-image="<?php echo e(url('public/images/product', $image)); ?>"/>
                                                </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                            <!-- End .product-single-carousel -->
                                            <span class="prod-full-screen">
                                                <i class="icon-plus"></i>
                                            </span>
                                        </div>
                                        <div class="prod-thumbnail row owl-dots" id='carousel-custom-dots'>
                                            <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="col-3 owl-dot">
                                                <img src="<?php echo e(url('public/images/product', $image)); ?>"/>
                                            </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div><!-- End .product-single-gallery -->
                                </div><!-- End .col-lg-7 -->
                            </div><!-- End .row -->
                        </div><!-- End .product-single-container -->

                    </div><!-- End .col-lg-9 -->

                         <?php if($product->brand_id != null): ?>

                            <?php
                              $brand_name = \App\Brand::where('id',$product->brand_id)->first();

                               // dd($brand_name);
                          ?>

                          <?php endif; ?>

                </div><!-- End .row -->
            </div><!-- End .container -->

            <div class="featured-products-section carousel-section">
                <div class="container">
                    <h2 class="h3 title mb-2">منتجات ذات صله</h2>

                    <div class="featured-products owl-carousel owl-theme">

                        <?php $__currentLoopData = $all_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                 $name=  str_replace(' ', '-', $row->name);
                                  $image =  $row->image;
                                   $image = explode(',',$image);
                                   $first_image = $image[0];
                            ?>
                        <div class="product-default">
                            <figure>
                                <a href="<?php echo e(route('eshop-details.ar',['id' => $row->id, 'name' => $name ])); ?>">
                                    <img src="<?php echo e(url('public/images/product', $first_image)); ?>" alt="product" style="height: auto; width: auto; margin: auto;">
                                </a>
                            </figure>
                            <div class="product-details">
                                <?php
                                    $brand_name = \App\Brand:: where('id',$row->brand_id)->first();
                                ?>
                                <?php if($brand_name): ?>
                                    <div class="cat-box">
                                        <span  style="font-size: 13px;" class="product-cat"><?php echo e($brand_name->title_ar); ?></span>
                                    </div><!-- End .price-box -->
                                <?php endif; ?>

                                <h2 class="product-title">
                                    <a href="<?php echo e(route('eshop-details.ar',['id' => $row->id, 'name' => $name ])); ?>"><?php echo e($row->name_ar); ?></a>
                                </h2>

                                <div class="price-box">
                                    <?php if($row->promotion == null): ?>
                                        <span class="product-price">৳<?php echo e($row->price); ?></span>
                                    <?php else: ?>
                                        <span class="old-price">৳<?php echo e($row->price); ?></span>
                                        <span class="promotional-price">৳<?php echo e($row->promotion_price); ?></span>
                                    <?php endif; ?>
                                </div>
                                <?php
                                    $full_rating = 0 ;
                                    $rating = \App\Review::where('product_id',$row->id)->select('ratings')->get();
                                    $total_rating = $rating->sum('ratings');
                                    $total_customer =count($rating);
                                    if ($total_customer > 0 ){
                                    $avg_rating = ($total_rating/$total_customer);
                                    $full_rating = $avg_rating;
                                    }else{
                                    $avg_rating = 0;
                                    }
                                    $half_rating = 0;
                                    $full_rating = (int)$full_rating;
                                    $half_rating = $avg_rating - $full_rating ;
                                    $un_rating = (int)(5 - $avg_rating) ;
                                ?>

                                <div>
                                    <?php for($i = 1 ; $i <= $full_rating ;$i++ ): ?>
                                        <span><i class="fa fa-star" style="font-size:18px"></i></span>
                                    <?php endfor; ?>

                                    <?php if( $half_rating > 0  && $half_rating < 1 ): ?>
                                        <i class="fa fa-star-half-o" style="font-size:18px" aria-hidden="true"></i>
                                    <?php endif; ?>
                                    <?php for($j = 1 ; $j <= $un_rating ;$j++ ): ?>
                                        <span><i class="fa fa-star-o" style="font-size:18px"></i></span>
                                    <?php endfor; ?>
                                </div>
                                <div class="product-action">
                                    <form action="" method="">
                                        <?php if(Auth::user() == null): ?>
                                            <a href="<?php echo e(route('eshop-wishlist-login-check.ar', $row->id)); ?>" class="paction add-wishlist" title="Add to Wishlist"></a>
                                        <?php else: ?>
                                            <a href="<?php echo e(route('eshop-wishlist.ar', $row->id)); ?>" class="paction add-wishlist" title="Add to Wishlist" ></a>
                                        <?php endif; ?>
                                    </form>
                                    <form action="<?php echo e(route('add-to-cart.ar', $row->id)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <?php if($row->qty > 0 ): ?>
                                            <button type="submit" class="btn-icon btn-add-cart"><i class="icon-bag"></i>أضف إلى السلة</button>
                                        <?php else: ?>
                                            <a href="<?php echo e(route('eshop-details.ar',['id' => $row->id, 'name' => $name ])); ?>" class="btn-add-cart paction"><i class="fa fa-eye" aria-hidden="true"></i> عرض التفاصيل</a>
                                        <?php endif; ?>
                                        <input type="hidden" name="product_price" value="<?php echo e($row->price); ?>">
                                        <input type="hidden" name="promotion_price" value="<?php echo e($row->promotion_price); ?>">
                                    </form>
                                    <!--<?php echo e(Form::open(['route' => ['eshop-detail-quick'], 'method' => 'POST'] )); ?>-->
                                    <!--<div>-->
                                    <!--    <input type="hidden" name="quick_id" value="<?php echo e($row->id); ?>">-->
                                    <!--    <input type="hidden" name="pro_id" value="<?php echo e($row->id); ?>">-->
                                    <!--    <button type="submit" class="paction quick-view" title="Quick View"><i class="fas fa-external-link-alt"></i></button>-->
                                    <!--</div>-->
                                    <!--<?php echo e(Form::close()); ?>-->

                                     <!--<?php echo e(Form::open(['route' => ['brands-product-quick'], 'method' => 'POST'] )); ?>-->
                                            <form action="" method="">
                                            <div>
                                                <!--<input type="hidden" name="quick_id" value="<?php echo e($row->id); ?>">-->
                                                <!--<input type="hidden" name="brand_id" value="<?php echo e($row->brand_id); ?>">-->
                                                <button type="submit" class="paction quick-view" title="Quick View"><i class="fas fa-external-link-alt"></i></button>
                                            </div>
                                            <!--<?php echo e(Form::close()); ?>-->
                                              </form>
                                </div>


                            </div><!-- End .product-details -->
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div><!-- End .featured-proucts -->
                </div><!-- End .container -->
            </div><!-- End .featured-proucts-section -->
        </main><!-- End .main -->


<?php if($product_details_info != null): ?>
    <?php
        $name=  str_replace(' ', '-', $product_details_info->name);
        $image =  $product_details_info->image;
        $image = explode(',',$image);
    ?>

    <div class="modal fade" id="quickviewModal" tabindex="-1" role="dialog" aria-labelledby="quickviewModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="product-single-container product-single-default product-quick-view container">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 product-single-gallery">
                            <div class="product-slider-container product-item">
                                <div class="product-single-carousel owl-carousel owl-theme">
                                    <?php $__currentLoopData = $image; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="product-item">
                                            <img class="product-single-image" src="<?php echo e(url('public/images/product', $img)); ?>" data-zoom-image="<?php echo e(url('public/images/product', $img)); ?>"/>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                                <!-- End .product-single-carousel -->
                            </div>
                            <div class="prod-thumbnail row owl-dots" id='carousel-custom-dots'>
                                <?php $__currentLoopData = $image; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-3 owl-dot">
                                        <img src="<?php echo e(url('public/images/product', $img)); ?>"/>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div><!-- End .col-lg-7 -->
                        <div class="col-lg-6 col-md-6">
                            <button type="button" class="close mobile_close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <br>
                            <div class="product-single-details">
                                <h1 class="product-title"><?php echo e($product_details_info->name_ar); ?> </h1>
                                <?php
                                    $comments = \App\Review::where('product_id',$product_details_info->id)->where('comment' ,'!=', null)->orderBy('id','DESC')->get();
                                     $full_rating = 0 ;
                                     $rating = \App\Review::where('product_id',$product_details_info->id)->select('ratings')->get();
                                     $total_rating = $rating->sum('ratings');
                                     $total_customer =count($rating);
                                     if ($total_customer > 0 ){
                                     $avg_rating = ($total_rating/$total_customer);
                                     $full_rating = $avg_rating;
                                     }else{
                                     $avg_rating = 0;
                                     }
                                     $half_rating = 0;
                                     $full_rating = (int)$full_rating;
                                     $half_rating = $avg_rating - $full_rating ;
                                     $un_rating = (int)(5 - $avg_rating) ;
                                ?>

                                <div>
                                    <?php for($i = 1 ; $i <= $full_rating ;$i++ ): ?>
                                        <span><i class="fa fa-star" style="font-size:18px"></i></span>
                                    <?php endfor; ?>

                                    <?php if( $half_rating > 0  && $half_rating < 1 ): ?>
                                        <i class="fa fa-star-half-o" style="font-size:18px" aria-hidden="true"></i>
                                    <?php endif; ?>
                                    <?php for($j = 1 ; $j <= $un_rating ;$j++ ): ?>
                                        <span><i class="fa fa-star-o" style="font-size:18px"></i></span>
                                    <?php endfor; ?>
                                    <p> (<?php echo e(count($comments)); ?> <?php if( count($comments) > 1 ): ?> reviews <?php else: ?> review )  <?php endif; ?>  </p>
                                </div>

                                <div class="price-box">
                                    <span class="product-price">৳ <?php echo e($product_details_info->price); ?></span>
                                </div><!-- End .price-box -->

                                <div class="product-desc">
                                    <p> <?php echo $product_details_info->product_details; ?></p>
                                </div><!-- End .product-desc -->

                                <form action="<?php echo e(route('add-to-cart.ar', $product_details_info->id)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <div class="product-action">
                                        <?php if($product_details_info->qty > 0 ): ?>
                                            <button type="submit" class="paction add-cart" title="Add to Cart"><span>أضف إلى السلة</span></button>
                                        <?php else: ?>
                                            <a href="<?php echo e(route('eshop-details.ar',['id' => $product_details_info->id, 'name' => $name ])); ?>" class="btn-add-cart paction"><i class="fa fa-eye" aria-hidden="true"></i> عرض التفاصيل</a>
                                        <?php endif; ?>

                                        <input type="hidden" name="product_price" value="<?php echo e($product_details_info->price); ?>">

                                        <?php if(Auth::user() == null): ?>
                                            <a href="<?php echo e(route('eshop-wishlist-login-check.ar', $product_details_info->id)); ?>" class="paction add-wishlist" title="أضف إلى قائمة الامنيات">

                                            </a>
                                        <?php else: ?>
                                            <a href="<?php echo e(route('eshop-wishlist.ar', $product_details_info->id)); ?>" class="paction add-wishlist" title="أضف إلى قائمة الامنيات" ></a>
                                        <?php endif; ?>
                                    </div><!-- End .product-action -->
                                </form>
                                <div class="product-single-share">
                                    <label>Share:</label>
                                    <!-- www.addthis.com share plugin-->
                                    <div class="addthis_inline_share_toolbox"></div>
                                </div><!-- End .product single-share -->
                            </div><!-- End .product-single-details -->
                        </div><!-- End .col-lg-5 -->
                    </div><!-- End .row -->
                </div><!-- End .product-single-container -->
            </div>
        </div>
    </div>
<?php endif; ?>


<script src="<?php echo asset('public/assets/frontend/js/jquery.min.js') ?>"></script>

<?php if($quick_view != null && $quick_view  == 9): ?>
    <script>
        $(function() {
            $('#quickviewModal').modal('show');
        });
    </script>
<?php endif; ?>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.ar_website', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\kosmetica\resources\views/eshop/ar/detail.blade.php ENDPATH**/ ?>