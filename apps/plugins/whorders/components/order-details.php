<?php
$uid = $_GET['tid'];
$cpo = get_order_by_uinique_id($uid);

// myprint($cpo);
?>

<section>
    <div class="row">
        <div class="col-md-12">
            <h3 class="my-4">
                Warehouse Order Dashboard
            </h3>
            <div id="res"></div>
        </div>
    </div>
</section>
<section>

    <div class="row">
        <div class="col-md-12">
            <table class="text-end table table-sm table-bordered">
              

                <?php foreach ($cpo as $cp) :
                    $tamt = $cp['amount'] + $cp['discount_amt'];
                ?>
                  <thead>
                  <tr class="text-start">
                            <th colspan="7"><span class="text-muted">Order Number : </span><?php echo $cp['unique_id']; ?></th>
                        </tr>
                    <tr>
                        <th scope="col">DBID</th>
                        <th scope="col">Gross Amt.</th>
                        <th scope="col">Discount</th>
                        <th scope="col">Net Amt.</th>
                        <th scope="col">Disc. By</th>
                        <th scope="col">Disc. Ref.</th>
                        <th scope="col">Last action on</th>
                        
                    </tr>
                </thead>
                    <tbody style="border: 1px dotted black;">
                        
                        <tr>
                            <th><?php echo $cp['id']; ?></th>
                            <td><?php echo $tamt; ?></td>
                            <td><?php echo $cp['discount_amt']; ?></td>
                            <td><?php echo $cp['amount']; ?></td>
                            <td><?php echo $cp['discount_type']; ?></td>
                            <td ><?php echo $cp['discount_ref']; ?></td>
                            <td ><?php echo $cp['last_action_on']; ?></td>
                        
                        </tr>
                        <tr>
                            <th>Cust. Name</th>
                            <th>Mobile</th>
                            <th>City</th>
                            <th >Deliver Via</th>
                            <th scope="col">Delivery Date</th>
                            <th>Warehouse Status</th>
                            <th>Order Action</th>
                        </tr>
                        <tr>
                            <td><?php echo $cp['name']; ?></td>
                            <td><?php echo $cp['mobile']; ?></td>
                            <td><?php echo $cp['discount_amt']; ?></td>
                            <td ><?php echo $cp['deliver_via']; ?></td>
                            <td>
                            <?php if ($cp['deliver_via']=="salesman") { ?>
                            <b>Change Salesman</b>
                            <select name="salesperson_id" class="form-select dlvdt<?php echo $cp['id']; ?>">
                                <?php foreach (getSalesmanList() as $sm) { ?>
                                <option <?php if($cpo[0]['salesperson_id']==$sm['id']){echo "selected";} ?> value="<?php echo $sm['id']; ?>"><?php echo $sm['name']; ?> (ID:<?php echo $sm['id']; ?>)</option>
                                <?php } ?>
                            </select>
    
                               <?php } ?>
                           
                            <b>Change Deleviery Date</b>
                                <input type="datetime-local" class="form-control dlvdt<?php echo $cp['id']; ?>" value="<?php echo $cp['delivery_date']; ?>" name="delivery_date"> <br>
                                <button id="update-delv-date-btn<?php echo $cp['id']; ?>" class="btn btn-primary">Update</button>
                                <input type="hidden" class="dlvdt<?php echo $cp['id']; ?>" name="order_id" value="<?php echo $cp['id']; ?>">
                                <?php pkAjax("#update-delv-date-btn{$cp['id']}", "/admin/whorders/update-delivery-date-ajax", ".dlvdt{$cp['id']}", "#res", 'click'); ?>
                            </td>
                            <td>
                            Warehouse Status : <b><?php echo ucfirst($cp['wh_status']); ?></b>
                                <select id="change_order_status_select<?php echo $cp['id']; ?>" class="form-select ds<?php echo $cp['id']; ?>" name="wh_status">
                                    <option disabled>Change Warehouse Status</option>
                                    <option <?php echo $cp['wh_status'] == "new" ? "selected" : null; ?> value="new">New</option>
                                    <option <?php echo $cp['wh_status'] == "pending" ? "selected" : null; ?> value="pending">Pending</option>
                                    <option <?php echo $cp['wh_status'] == "accepted" ? "selected" : null; ?> value="accepted">Accepted</option>
                                    <option <?php echo $cp['wh_status'] == "ready" ? "selected" : null; ?> value="ready">Ready</option>
                                    <option <?php echo $cp['wh_status'] == "dispatched" ? "selected" : null; ?> value="dispatched">Dispatched</option>
                                    <option <?php echo $cp['wh_status'] == "rejected" ? "selected" : null; ?> value="rejected">Rejected</option>
                                </select>
                                <label for="">Cancellation Reason</label>
                                <textarea style="border:1px solid red; border-radius:0;" placeholder="Please specify the reason if order status is set to be cancelled" name="wh_info" class="form-control ds<?php echo $cp['id']; ?>"><?php echo $cp['wh_info']; ?></textarea>
                                <input type="hidden" class="ds<?php echo $cp['id']; ?>" name="order_id" value="<?php echo $cp['id']; ?>">
                                <?php pkAjax("#change_order_status_select{$cp['id']}", "/admin/whorders/change-order-status-update-ajax", ".ds{$cp['id']}", "#res", 'change'); ?>
                            </td>
                            <td >
                                <div class="d-grid">
                                    <a class="btn btn-dark" href="/<?php echo home; ?>/admin/whorders/order-list/?status=<?php echo $cp['wh_status']; ?>">Back</a>
                                </div>
                                <div class="d-grid my-3">
                                    <a class="btn btn-success" target="_blank" href="/<?php echo home; ?>/admin/whorders/print-invoice/?tid=<?php echo $cp['unique_id']; ?>">Genrate Invoice</a>
                                </div>
                            </td>

                        </tr>
                        <tr>
                            <div class="card shadow my-3">
                    <tbody>
                        <tr class="text-end">
                            <th colspan="4">Item Name</th>
                            <th>Cost/Item</th>
                            <th>Qty</th>
                            <!-- <th>Cart Status</th>
                            <th>Shipping Status</th> -->
                        </tr>
                        <?php
                        foreach ($cp['purchased_items'] as $cart) :
                            $cart_uid = uniqid('cart');
                            $cart_uid = $cart_uid . rand(0, 10000) . $cart['cart_id'];
                        ?>
                            <tr class="text-end">
                                <td colspan="4"><?php echo $cart['item_name']; ?></td>
                                <td><?php echo $cart['item_price']; ?></td>
                                <td><?php echo $cart['item_cart_qty']; ?></td>
                                <td class="hide">
                                    <select id="change_cart_status_select<?php echo $cart_uid; ?>" class="form-select cart<?php echo $cart_uid; ?>" name="status">
                                        <option <?php echo $cart['cart_status'] == "processing" ? "selected" : null; ?> value="processing">Processing</option>
                                        <option <?php echo $cart['cart_status'] == "completed" ? "selected" : null; ?> value="completed">Completed</option>
                                        <option <?php echo $cart['cart_status'] == "delivered" ? "selected" : null; ?> value="delivered">Delivered</option>
                                        <option <?php echo $cart['cart_status'] == "returned" ? "selected" : null; ?> value="returned">Returned</option>
                                        <option <?php echo $cart['cart_status'] == "restocked" ? "selected" : null; ?> value="restocked">Restocked</option>
                                    </select>
                                    <input type="hidden" class="cart<?php echo $cart_uid; ?>" name="cart_id" value="<?php echo $cart['cart_id']; ?>">
                                    <?php pkAjax("#change_cart_status_select{$cart_uid}", "/admin/whorders/change-cart-status-update", ".cart{$cart_uid}", "#res", 'change') ?>
                                </td>
                                <td class="hide">
                                    <select class="form-select" name="shipping_status">
                                        <option <?php echo $cart['shipping_status'] == "pending" ? "selected" : null; ?> value="pending">Pending</option>
                                        <option <?php echo $cart['shipping_status'] == "shipped" ? "selected" : null; ?> value="shipped">Shipped</option>
                                        <option <?php echo $cart['shipping_status'] == "transit" ? "selected" : null; ?> value="transit">In Transit</option>
                                        <option <?php echo $cart['shipping_status'] == "delivered" ? "selected" : null; ?> value="delivered">Delivered</option>
                                        <option <?php echo $cart['shipping_status'] == "returned" ? "selected" : null; ?> value="returned">Returned</option>
                                    </select>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
        </div>
        </tr>

        </tbody>
    <?php endforeach; ?>

    </table>
    </div>
    </div>

</section>