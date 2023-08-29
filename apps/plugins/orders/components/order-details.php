<?php
$uid = $_GET['tid'];
$cp = get_order_by_uinique_id($uid);

// myprint($cpo);
?>
<style>
    .custom-radio input[type="radio"] {
        transform: scale(1.5);
        /* You can adjust the scale value as needed */
        margin-right: 5px;
        /* Add some spacing between the radio button and the label text */
    }

    .custom-radio {
        display: inline-block;
        margin-right: 15px;
        /* Add spacing between different radio button options */
    }
</style>
<section>
    <div class="row">
        <div class="col-md-12">
            <h3 class="my-4">
                Order Dashboard
            </h3>
            <div id="res"></div>
        </div>
    </div>
</section>
<section>

    <div class="row">
        <div class="col-md-12">
            <table class="text-end table table-sm table-bordered">


                <?php
                $drvrusrnam  = null;
                $user = getData('pk_user', $cp['user_id']);
                echo "User: {$user['first_name']} {$user['first_name']} - ({$user['email']})";


                $tamt = $cp['user_amount'];
                ?>
                <thead>
                    <tr class="text-start">
                        <th colspan="7"><span class="text-muted">Order Number : </span><?php echo $cp['unique_id']; ?></th>
                    </tr>
                    <tr>
                        <th scope="col">DBID</th>
                        <th colspan="3">User Price</th>
                        <th colspan="3" scope="col">Last action on</th>

                    </tr>
                </thead>
                <tbody style="border: 1px dotted black;">

                    <tr>
                        <th><?php echo $cp['id']; ?></th>
                        <th colspan="3"><?php echo $tamt; ?>/-</th>
                        <td colspan="3"><?php echo $cp['driver_amount'] > 0 ? "{$cp['driver_amount']}/-" : "Not assigned"; ?></td>

                    </tr>
                    <tr>
                        <th>Cust. Name</th>
                        <th>Mobile</th>

                        <th>Driver & Consignment</th>
                        <th scope="col">Pickup details</th>
                        <th>Order Status</th>
                        <th>Order Action</th>
                    </tr>
                    <tr>
                        <td><?php echo $user['name']; ?></td>
                        <td><?php echo $user['mobile']; ?></td>

                        <td>
                            <b><?php echo $drvrusrnam; ?></b>
                            <table class="table table-primary table-bordered border-white">
                                <tr>
                                    <th>Consignment Dimension (LxBxH)</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Via</th>
                                </tr>
                                <tr>
                                    <b>Dimension</b>
                                    <td>
                                        <?php echo "{$cp['length']}{$cp['length_unit']}X{$cp['width']}{$cp['width_unit']}X{$cp['height']}{$cp['height_unit']}" ?>
                                    </td>
                                    <td><?php echo "{$cp['from_address']}"; ?></td>
                                    <td><?php echo "{$cp['to_address']}"; ?></td>
                                    <td><?php echo "{$cp['delivery_method']}"; ?></td>
                                </tr>
                                <tr>

                                    <th>Weight</th>
                                    <td></td>
                                    <td></td>
                                    <td><?php echo "{$cp['weight']}"; ?></td>
                                </tr>

                            </table>
                        </td>
                        <td>
                            <?php //if ($cp['deliver_via']=="salesman") { 
                            ?>
                            <b>Select Driver</b>

                            <ul style="list-style: none; max-height:200px; overflow-y:scroll; background-color:aqua; padding:5px;">
                                <?php

                                $drvObj = new Model('driver_quotes');
                                $qts = $drvObj->filter_index(assoc_arr: ['booking_id' => $cp['id']]);

                                if (count($qts) == 0) {
                                    echo "No any driver quoted yet";
                                } else {
                                    foreach ($qts as  $qt) {
                                        $qt = obj($qt);
                                        $drvObj = new Model('pk_user');
                                        $drv = $drvObj->filter_index(assoc_arr: ['id' => $qt->driver_id, 'is_active' => 1])[0];
                                ?>

                                        <li class="my-3">
                                            <label for="" class="custom-radio">
                                                <?php echo $drv['first_name']; ?> : (<?php echo $drv['id']; ?>), accepted at : <?php echo $qt->quote_amount; ?>/- <input type="radio" <?php echo $cp['assigned_driver_id'] == $drv['id'] ? 'checked' : null; ?> class="dlvdt<?php echo $cp['id']; ?>" name="driver_id" value="<?php echo $drv['id']; ?>">
                                                <input type="hidden" name="driver_amount" class="dlvdt<?php echo $cp['id']; ?>" value="<?php echo $qt->quote_amount; ?>">
                                                <input type="hidden" name="booking_id" class="dlvdt<?php echo $cp['id']; ?>" value="<?php echo $cp['id']; ?>">
                                            </label>

                                        </li>
                                <?php }
                                } ?>

                            </ul>
                            <?php if (!is_superuser()) {
                                echo "<input type='hidden' name='salesperson_id' value='{$cpo[0]['salesperson_id']}'>";
                            } ?>
                            <?php // } 
                            ?>

                            <b>Change pickup Date and time</b>
                            <input type="date" class="my-2 form-control dlvdt<?php echo $cp['id']; ?>" value="<?php echo $cp['pickup_date']; ?>" name="pickup_date">
                            <input type="time" class="my-2 form-control dlvdt<?php echo $cp['id']; ?>" value="<?php echo $cp['pickup_time']; ?>" name="pickup_time"> <br>
                            <button id="update-delv-date-btn<?php echo $cp['id']; ?>" class="btn btn-primary">Update</button>
                            <input type="hidden" class="dlvdt<?php echo $cp['id']; ?>" name="order_id" value="<?php echo $cp['id']; ?>">
                            <?php pkAjax("#update-delv-date-btn{$cp['id']}", "/admin/orders/update-parcel-booking-data-ajax", ".dlvdt{$cp['id']}", "#res", 'click'); ?>
                        </td>
                        <td>
                            <?php echo ucfirst($cp['status']); ?>
                            <select id="change_order_status_select<?php echo $cp['id']; ?>" class="form-select ds<?php echo $cp['id']; ?>" name="status">
                                <option disabled>Change Status</option>
                                <?php
                                foreach ($GLOBALS['bk_sts'] as $key => $st) { ?>
                                    <option <?php echo $cp['status'] == $st ? "selected" : null; ?> value="<?php echo $st; ?>"><?php echo ucfirst($st); ?></option>
                                <?php  } ?>

                            </select>
                            <label for="">Cancellation Reason</label>
                            <textarea style="border:1px solid red; border-radius:0;" placeholder="Please specify the reason if order status is set to be cancelled" name="cancel_info" class="form-control ds<?php echo $cp['id']; ?>"><?php echo $cp['note']; ?></textarea>
                            <input type="hidden" class="ds<?php echo $cp['id']; ?>" name="order_id" value="<?php echo $cp['id']; ?>">
                            <?php pkAjax("#change_order_status_select{$cp['id']}", "/admin/orders/change-booking-status-update-ajax", ".ds{$cp['id']}", "#res", 'change'); ?>
                        </td>
                        <td>
                            <div class="d-grid">
                                <a class="btn btn-dark" href="/<?php echo home; ?>/admin/orders/order-list/?status=<?php echo $cp['status']; ?>">Back</a>
                            </div>

                        </td>

                    </tr>
                    <tr>

                    </tr>

                </tbody>


            </table>
        </div>
    </div>

</section>