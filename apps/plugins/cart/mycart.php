<?php $GLOBALS["title"] = "Product Details"; ?>
<?php import("apps/view/inc/header.php"); ?>
<?php import("apps/view/inc/nav.php"); ?>

<section class="my-5">
    <div class="container">
    <div id="show-cart">
    <div class="card p-2">
        <div class="row">
            
            <div class="col-md-8">
                
                <h3 class="text-center">Cart Items</h3>
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Name</th>
                            <th class="text-end">Qty</th>
                            <th class="text-end">Price/Unit</th>
                            <th class="text-end">Amount</th>
                            <th class="text-end">
                                Add
                            </th>
                            <th class="text-end">
                                Remove
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                         $total_qty = array();
                         $total_cost = array();
                        if (isset($_SESSION['cart'])) {
                            
                            // for ($i=0; $i < count($_SESSION['cart']); $i++) { 
                            //     echo $_SESSION['cart']['46']['id'] ;
                            // }
                           
                            $db = new Mydb('content');
                            foreach (array_keys($_SESSION['cart']) as $key => $value) { 
                                $id =  $_SESSION['cart'][$value]['id'];
                                $qty = $_SESSION['cart'][$value]['qty'];
                                $total_qty[] = $qty;
                                $db = new Mydb('content');
                                $prod = $db->pkData($id);
                                $sale_price = $prod['sale_price']==""?0:$prod['sale_price'];
                                $is_sale = (($prod['sale_price'])!="" && ($prod['sale_price'])>0)?true:false;
                                $net_price = $prod['price']-$sale_price;
                                $cost = $qty*$net_price;
                                $total_cost[] = $cost;
                                ?>
                           
                        <tr>
                            <td>
                                <?php echo $id; ?>
                            </td>
                            <td>
                                <?php echo $prod['title']; ?>
                            </td>
                            <td class="text-end">
                                <?php echo $qty; ?>
                            </td>
                            <td class="text-end">
                                <?php echo $prod['currency']; ?> <?php echo $net_price; ?>/-
                            </td>
                            <td class="text-end">
                            <?php echo $cost; ?>
                            </td>
                            
                            
                            <td class="text-end">
                                    <button class="btn btn-warning update-cart-icon<?php echo $prod['id']; ?>" id="add-to-cart_btn<?php echo $prod['id']; ?>" type="button"> 
                                        <i class="fas fa-plus"></i>
                                    </button>
                                <script>
                                    $(document).ready(function(){
                                        $(".update-cart-icon<?php echo $prod['id']; ?>").click(function(){
                                            $.ajax({
                                                url: "/<?php echo home; ?>/cart/ajax-add-to-cart",
                                                method: "post",
                                                data: {item_id: '<?php echo $prod['id']; ?>',action: 'add_to_cart'},
                                                dataType: "html",
                                                success: function(resultValue) {
                                                    // $('#show-cart').html(resultValue)
                                                    location.reload();
                                                }
                                            });
                                        });
                                    })
                                </script>
                            </td>
                            <td class="text-end">
                            
                                <button class="btn btn-sm btn-danger update-cart-icon-remove<?php echo $prod['id']; ?>" id="remove-my-cart<?php echo $prod['id']; ?>" type="button">
                                    <i class="fas fa-minus"></i>
                                </button>
                              
                                <script>
                                    $(document).ready(function(){
                                        $(".update-cart-icon-remove<?php echo $prod['id']; ?>").click(function(){
                                            $.ajax({
                                                url: "/<?php echo home; ?>/cart/ajax-remove-from-cart",
                                                method: "post",
                                                data: {item_id: '<?php echo $prod['id']; ?>'},
                                                dataType: "html",
                                                success: function(resultValue) {
                                                    // $('#show-cart').html(resultValue)
                                                    location.reload();
                                                }
                                            });
                                        });
                                    })
                                </script>
                            </td>
                        
                        </tr>
                        
                        <?php }
                        } 
                        // $_SESSION['cart_count'] = array_sum($total_qty);
                        ?>
                        <tr class="text-end">
                            <td></td>
                            <td></td>
                            <th>= <?php echo array_sum($total_qty); ?> Nos.</th>
                            <td></td>
                            <th>= JOD <?php echo array_sum($total_cost); ?>/-</th>
                            <td colspan="2">
                                <!-- <div class="d-grid">
                                    <button class="btn btn-sm btn-primary update-cart-icon" id="proceed_to_checkout" type="button">
                                    Proceed to checkout <i class="fa-solid fa-arrow-right"></i>
                                    </button>
                                </div> -->
                                
                            </td>
                        </tr>
                        
                    </tbody>
                </table>
        
            </div>
            <div class="col-md-4">
            
                <h3 class="text-center">Details</h3>
                <table class="table table-bordered border border-primary">
                    <tbody>
                        <tr class="text-end">
                            <th>
                                Total Unique Item = 
                            </th> 
                            <td>
                            <?php echo count($total_qty); ?> Nos.
                            </td> 
                        </tr>
                        <tr class="text-end">
                            <th>
                                Total Quantity = 
                            </th> 
                            <td>
                                <?php echo array_sum($total_qty); ?> Nos.
                            </td> 
                        </tr>
                        <tr class="text-end">
                            <th>
                                Total Amount = 
                            </th> 
                            <th class="bg-warning">
                                JOD <?php echo array_sum($total_cost); ?>/-
                            </th> 
                        </tr>
                        <tr class="text-end">
                        
                            <td colspan="2">
                                <div id="checkout-response"></div>
                                <div class="d-grid">
                                    <a href="/<?php echo home; ?>/checkout" class="btn btn-primary update-cart-icon btn-lg" id="proceed_to_checkout" type="button">
                                        Proceed to checkout <i class="fa-solid fa-arrow-right"></i>
                                    </a>
                                </div>
                            </td> 
                        </tr>
                        
                    </tbody>
                </table>
            </div>
            </div>
        </div>
        </div>


            </div>
</section>

  
 <?php import("apps/view/inc/footer.php"); ?>

