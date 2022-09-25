<?php $__env->startSection('home_content'); ?>
    <main class="main">
        <div class="banner banner-cat" style="background-image: url('<?php echo e(asset('/')); ?>public/assets/frontend/images/sliderbackground.png'); height: 215px;">
            <div class="banner-content container">
                <!-- <h2 class="banner-subtitle">check out over <span>200+</span></h2> -->
                <h1 class="banner-title">
                  Offers
                </h1>
                <!-- <a href="#" class="btn btn-dark">Shop Now</a> -->
            </div><!-- End .banner-content -->
        </div><!-- End .banner -->

        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <div class="container">
                <ol class="breadcrumb mt-0">
                    <li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">offer</li>
                </ol>
            </div><!-- End .container -->
        </nav>

        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row row-sm">
                        <?php $__currentLoopData = $offer_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $name =  str_replace(' ', '-', $row->name);
                                 $image =  $row->image;
                                   $image = explode(',',$image);
                                   $first_image = $image[0];
                            ?>
                            <div class="col-6 col-md-4 col-lg-3 col-xl-3">
                                <div class="product-default">
                                    <figure>
                                        <a href="<?php echo e(route('eshop-details',['id' => $row->id, 'name' => $name ])); ?>">
                                            <img src="<?php echo e(url('public/images/product', $first_image)); ?>" alt="product" style="height: auto; width: auto; margin: auto;">
                                        </a>
                                    </figure>
                                    <div class="product-details">
                                        <div class="price-box" style="display: inline-flex;margin-bottom: 5px;">
                                            <?php if($row->brand->title != null): ?>
                                                <span class="product-details"><?php echo e($row->brand->title); ?></span>
                                            <?php endif; ?>

                                        </div><!-- End .price-box -->

                                        <h2 class="product-title">
                                            <a  href="<?php echo e(route('eshop-details',['id' => $row->id, 'name' => $name ])); ?>"><?php echo e($row->name); ?></a>
                                        </h2>

                                        <div class="price-box">
                                            <?php if($row->promotion == null): ?>
                                                <span class="product-price">৳<?php echo e($row->price); ?></span>
                                            <?php else: ?>
                                                <span class="old-price">৳<?php echo e($row->price); ?></span>
                                                <span class="promotional-price">৳<?php echo e($row->promotion_price); ?></span>
                                            <?php endif; ?>
                                        </div><!-- End .price-box -->

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
                                                    <a href="<?php echo e(route('eshop-wishlist-login-check', $row->id)); ?>" class="paction add-wishlist" title="Add to Wishlist"></a>
                                                <?php else: ?>
                                                    <a href="<?php echo e(route('eshop-wishlist', $row->id)); ?>" class="paction add-wishlist" title="Add to Wishlist" ></a>
                                                <?php endif; ?>
                                            </form>
                                            <form action="<?php echo e(route('add-to-cart', $row->id)); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <?php if($row->qty > 0 ): ?>
                                                    <button type="submit" class="btn-icon btn-add-cart"><i class="icon-bag"></i>ADD TO CART</button>
                                                <?php else: ?>
                                                    <a href="<?php echo e(route('eshop-details',['id' => $row->id, 'name' => $name ])); ?>" class="btn-add-cart paction"><i class="fa fa-eye" aria-hidden="true"></i> View Details</a>
                                                <?php endif; ?>
                                                <input type="hidden" name="product_price" value="<?php echo e($row->price); ?>">
                                                <input type="hidden" name="promotion_price" value="<?php echo e($row->promotion_price); ?>">
                                            </form>
                                        <!--<?php echo e(Form::open(['route' => ['eshop-offer-quick'], 'method' => 'POST'] )); ?>-->
                                            <!--<div>-->
                                        <!--    <input type="hidden" name="quick_id" value="<?php echo e($row->id); ?>">-->
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
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </div>

                  
                </div><!-- End .col-lg-9 -->

                <aside class="sidebar-shop col-lg-3 order-lg-first" >
                    <div class="sidebar-wrapper">
                        <div class="widget">
                            <h3 class="widget-title">
                                <a data-toggle="collapse" href="#widget-body-2" role="button" aria-expanded="true" aria-controls="widget-body-2">Price</a>
                            </h3>
                            <div class="collapse show" id="widget-body-2">
                                <div class="widget-body">
                                    <?php echo Form::open(['route' => 'price.filter', 'method' => 'post', 'files' => true]); ?>

                                    <div class="row">
                                        <input type="hidden" name="cat_id" value="<?php echo e($cat_name->id); ?>">
                                        <input style="max-width: 70px;" type="number" min="0" placeholder="Min" value="" name="min" pattern="[0-9]*">
                                        <span class="c1DHiF"> - </span>
                                        <input  style="max-width: 70px;" type="number" min="0" placeholder="Max" name="max" value="" pattern="[0-9]*">
                                    </div>
                                    <div class="filter-price-action">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                    </div><!-- End .filter-price-action -->
                                    <?php echo e(Form::close()); ?>

                                </div><!-- End .widget-body -->
                            </div><!-- End .collapse -->
                        </div><!-- End .widget -->


                        <?php

                            $tagname = [];
                            $product_id = [];
                            $tags = [];

                           foreach ($offer_products as $pro){
                               $product_id[] = $pro->id;
                           }

                           if ($product_id){

                           $tags = \App\ProductTag::join('tags', 'product_tags.tag_id', '=', 'tags.id')
                                                     ->whereIn('product_tags.product_id',$product_id)
                                                     ->select('tags.*')
                                                     ->get();
                           }


                           if(count($tags) > 0){

                             foreach ($tags as $pro){
                               $tag_id[] = $pro->id;
                           }

                           $tagname = \App\Tags::whereIn('id',$tag_id)->get();
                           }
                        ?>


                        <div>
                            <level><strong style="color:black">Tags</strong>
                                <?php if(count($tagname) > 0 ): ?>
                                    <?php $__currentLoopData = $tagname; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><a href="<?php echo e(route('tag.product', $val->id)); ?>"><strong> <?php echo e($val->tag_name); ?></strong></a></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>

                            </level>

                        </div><!-- End .widget -->

                        <div class="widget widget-featured">
                            <h3 class="widget-title">Featured Products</h3>

                            <div class="widget-body"><div class="owl-carousel widget-featured-products">
                                    <div class="featured-col">
                                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $name =  str_replace(' ', '-', $row->name);
                                                   $image =  $row->image;
                                                     $image = explode(',',$image);
                                                     $first_image = $image[0];
                                            ?>
                                            <div class="product-default left-details product-widget">
                                                <figure>
                                                    <a href="<?php echo e(route('eshop-details',['id' => $row->id, 'name' => $name ])); ?>">
                                                        <img src="<?php echo e(url('public/images/product', $first_image)); ?>">
                                                    </a>
                                                </figure>
                                                <div class="product-details">

                                                    <?php
                                                        $brand_name = \App\Brand:: where('id',$row->brand_id)->first();
                                                    ?>
                                                    <?php if($brand_name): ?>
                                                        <div class="cat-box">
                                                            <span  style="font-size: 13px;" class="product-cat"><?php echo e($brand_name->title); ?></span>
                                                        </div><!-- End .price-box -->
                                                    <?php endif; ?>

                                                    <h2 class="product-title">
                                                        <a href="<?php echo e(route('eshop-details',['id' => $row->id, 'name' => $name ])); ?>"><?php echo e($row->name); ?></a>
                                                    </h2>
                                                    <div class="price-box">
                                                        <span class="product-price">৳<?php echo e($row->price); ?></span>
                                                    </div><!-- End .price-box -->
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
                                                </div><!-- End .product-details -->
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div><!-- End .featured-col -->

                                    <div class="featured-col">

                                        <?php $__currentLoopData = $next_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $name =  str_replace(' ', '-', $row->name);
                                                 $image =  $row->image;
                                                   $image = explode(',',$image);
                                                   $first_image = $image[0];
                                            ?>
                                            <div class="product-default left-details product-widget">
                                                <figure>
                                                    <a href="<?php echo e(route('eshop-details',['id' => $row->id, 'name' => $name ])); ?>">
                                                        <img src="<?php echo e(url('public/images/product',$first_image)); ?>">
                                                    </a>
                                                </figure>
                                                <div class="product-details">

                                                    <?php
                                                        $brand_name = \App\Brand:: where('id',$row->brand_id)->first();
                                                    ?>
                                                    <?php if($brand_name): ?>
                                                        <div class="cat-box">
                                                            <span  style="font-size: 13px;" class="product-cat"><?php echo e($brand_name->title); ?></span>
                                                        </div><!-- End .price-box -->
                                                    <?php endif; ?>

                                                    <h2 class="product-title">
                                                        <a href="<?php echo e(route('eshop-details',['id' => $row->id, 'name' => $name ])); ?>"><?php echo e($row->name); ?></a>
                                                    </h2>

                                                    <div class="price-box">
                                                        <span class="product-price">৳<?php echo e($row->price); ?></span>
                                                    </div><!-- End .price-box -->
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
                                                </div><!-- End .product-details -->
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </div><!-- End .featured-col -->
                                </div><!-- End .widget-featured-slider -->
                            </div><!-- End .widget-body -->
                        </div><!-- End .widget -->

                        <!--<div class="widget widget-block">
                            <h3 class="widget-title">Custom HTML Block</h3>
                            <h5>This is a custom sub-title.</h5>
                            <p>Lorem ipsum dolor sit amet, consectetur elitad adipiscing Cras non placerat mi. </p>
                        </div>
                        <!-- End .widget -->
                    </div><!-- End .sidebar-wrapper -->
                </aside><!-- End .col-lg-3 -->
            </div><!-- End .row -->
        </div><!-- End .container -->


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

                                        <h1 class="product-title"><?php echo e($product_details_info->name); ?> </h1>
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


                                        <form action="<?php echo e(route('add-to-cart', $product_details_info->id)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <div class="product-action">
                                                <?php if($product_details_info->qty > 0 ): ?>
                                                    <button type="submit" class="paction add-cart" title="Add to Cart"><span>Add to Cart</span></button>
                                                <?php else: ?>
                                                    <a href="<?php echo e(route('eshop-details',['id' => $product_details_info->id, 'name' => $name ])); ?>" class="btn-add-cart paction"><i class="fa fa-eye" aria-hidden="true"></i> View Details</a>
                                                <?php endif; ?>

                                                <input type="hidden" name="product_price" value="<?php echo e($product_details_info->price); ?>">

                                                <?php if(Auth::user() == null): ?>
                                                    <a href="<?php echo e(route('eshop-wishlist-login-check', $product_details_info->id)); ?>" class="paction add-wishlist" title="Add to Wishlist">

                                                    </a>
                                                <?php else: ?>
                                                    <a href="<?php echo e(route('eshop-wishlist', $product_details_info->id)); ?>" class="paction add-wishlist" title="Add to Wishlist" ></a>
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

        <div class="mb-5"></div><!-- margin -->
    </main><!-- End .main -->


    <script src="<?php echo asset('public/assets/frontend/js/jquery.min.js') ?>"></script>

    <?php if($quick_view != null && $quick_view  == 9): ?>
        <script>
            $(function() {
                $('#quickviewModal').modal('show');
            });
        </script>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.website', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\kosmetica\resources\views/eshop/offer.blade.php ENDPATH**/ ?>