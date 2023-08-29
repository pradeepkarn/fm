<table class="table">
                                        <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>CID</th>
                                                <th>Created By</th>
                                                <th>View</th>
                                                <th>Title</th>
                                                <th>Price</th>
                                                <th>Sale Price</th>
                                                <th>Short Info</th>
                                                <th>Category</th>
                                                <th>Status</th>
                                                <?php if (getAccessLevel()<=5): ?>
                                                <th>Action</th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            
                                            $limit="5";
                                            $total_bookings = 0;
                                            if(isset($_GET['page'])){
                                                $starting_from = $_GET['page'];
                                                $rows_limit = 5;
                                                $limit = "{$starting_from},{$rows_limit}";
                                            }
                                                if (isset($_GET['userid'])) {
                                                    $bookings = getAllServices($limit,$_GET['userid']); 
                                                    if (getAllServices($limit="0,99999",$_GET['userid'])!=false) {
                                                        $total_bookings = count(getAllServices($limit="0,99999",$_GET['userid']));
                                                    }
                                                }
                                                else{
                                                    $bookings = getAllServices($limit); 
                                                    if (getAllServices()!=false) {
                                                        $total_bookings = count(getAllServices());
                                                    }
                                                }
                                               
                                                $servs = $bookings;
                                                if (isset($_GET['rows_ord']) && isset($_GET['startfrom_numrows'])) {
                                                    $ord = $_GET['rows_ord'];
                                                    $limit = $_GET['startfrom_numrows'];
                                                    $servobj = new Model('service');
                                                    $servs = $servobj->index($ord, $limit);
                                                }
                                            //$servs = getAllServices($limit); 
                                            if ($servs!=false) {
                                               foreach ($servs as $key => $sv) {
                                                $created_by = getTableRowById("pk_user",$sv['created_by']);
                                                   ?>
                                                <tr class="border-dark">
                                                    <?php $imgpath = RPATH."/media/images/categories/".$sv['image']; $img = file_exists($imgpath); ?>
                                                    <td><img class="<?php echo ($img==true)?"":"hide"; ?>" style="height: 50px; width: 50px; object-fit: cover;" src="/<?php echo media_root; ?>/images/categories/<?php echo $sv['image']; ?>" alt=""></td>
                                                    <td><?php echo $sv['id']; ?></td>
                                                    <td><?php echo "{$created_by['name']}<br>(ID: {$created_by['id']})"; ?></td>
                                                    <td> <a target="_blank" class="text-deco-none" href="/<?php echo home; ?>/book-service/?serviceid=<?php echo $sv['id']; ?>"> <i class="text-success fas fa-eye"></i></a> </td>                                                    <td><?php echo $sv['title']; ?></td>
                                                    <td><?php echo $sv['price']; ?></td>
                                                    <td><?php echo $sv['sale_price']; ?></td>
                                                    <td><?php echo pk_excerpt($sv['description'],50); ?></td>
                                                    <td class="text-capt"><?php echo $sv['category']; ?></td>
                                                    <td><?php echo ($sv['activation']==1) ? "Active" : "Inactive"; ?></td>
                                                    <?php if (getAccessLevel()<=5): ?>
                                                    <td class="text-center">
                                                        <button data-bs-toggle="dropdown" id="dropdownMenuButton1" class="btn btn-success"><i class="pk-pointer fa-solid fa-ellipsis-vertical"></i> </button>
                                                        <ul class="dropdown-menu bg-success" aria-labelledby="dropdownMenuButton1">
                                                            <li><a class="dropdown-item text-white edit-service" data-bs-toggle="modal" data-bs-target="#addServiceModal_<?php echo $sv['id']; ?>" href="#">Edit</a></li>
                                                            <!-- <li><a class="dropdown-item" href="#">Settings</a></li> -->
                                                        </ul>
                                                    </td>
                                                    <?php endif; ?>
                                                </tr>
                                                <?php if (getAccessLevel()<=5): ?>
                                                <!--Modal area  -->
                                            <div class="modal fade" id="addServiceModal_<?php echo $sv['id']; ?>" tabindex="-1" aria-labelledby="addServiceModalLabel_<?php echo $sv['id']; ?>" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Update Course</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div id="img-res<?php echo $sv['id']; ?>"></div>
                                                                    
                                                                    <form id="image-upload-form<?php echo $sv['id']; ?>" action="/<?php echo home;?>/admin/services/update-service" method="post">
                                                                        <?php csrf_token(); ?>
                                                                        <input type="file" name="update_my_service_admin_image">
                                                                        <input type="hidden" name="service_id" value="<?php echo $sv['id']; ?>">
                                                                        <input id="upload-img-btn<?php echo $sv['id']; ?>" type="submit" class="btn btn-success" value="UPLOAD">
                                                                    </form>
                                                                    <?php pkAjax_form("#upload-img-btn{$sv['id']}","#image-upload-form{$sv['id']}","#img-res{$sv['id']}",$event='click'); ?>
                                                                    <div style="display: none;" id="loadid_<?php echo $sv['id']; ?>"><b>Please wait...</b></div>
                                                                    <?php ajaxLoad("#loadid_{$sv['id']}"); ?>
                                                                </div>
                                                            </div>
                                                            <form method="post" id="update-service-form<?php echo $sv['id']; ?>">
                                                                <?php csrf_token(); ?>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div id="res"></div>
                                                                        <div class="mb-3">
                                                                        <label for="serviceTitle" class="form-label">Title</label>
                                                                        <input name="service_title" value="<?php echo $sv['title']; ?>" required onblur="checkDate();" type="text" class="form-control" id="serviceTitle<?php echo $sv['id']; ?>" placeholder="Title">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                    Category <input id="post_cat_radio_select<?php echo $sv['id']; ?>" checked type="radio" name="cat">
                    <select id="post_cat_select<?php echo $sv['id']; ?>" name="category" class="form-control update_page">
                    <?php $dbcat = new Mydb('service');
                            $cts = $dbcat->filterDistinct($col="category", $ord='',$limit = 100);
                            foreach ($cts as $key => $ctsvl): ?>
                            <option <?php echo ($ctsvl['category']==$sv['category'])?"selected":""; ?> value="<?php echo $ctsvl['category']; ?>"><?php echo $ctsvl['category']; ?></option>
                          <?php endforeach; ?>
                    </select>
                    </div>
                    <?php if (getAccessLevel()<=1) {?>
                        <div class="col-md-12">
                    Want to create a new category ? <input id="post_cat_radio<?php echo $sv['id']; ?>" type="radio" name="cat">
                    <input id="post_cat_add<?php echo $sv['id']; ?>" type="text" disabled=true name="category" class="form-control mb-2">
                    </div>
                    <script>
                        var activrad<?php echo $sv['id']; ?> = document.getElementById("post_cat_radio<?php echo $sv['id']; ?>");
                        var postcat<?php echo $sv['id']; ?> = document.getElementById("post_cat_add<?php echo $sv['id']; ?>");
                        var postcatselect<?php echo $sv['id']; ?> = document.getElementById("post_cat_select<?php echo $sv['id']; ?>");
                        var postcatselectrad<?php echo $sv['id']; ?> = document.getElementById("post_cat_radio_select<?php echo $sv['id']; ?>");
                        activrad<?php echo $sv['id']; ?>.addEventListener('click',activeElAd<?php echo $sv['id']; ?>);
                        postcatselectrad<?php echo $sv['id']; ?>.addEventListener('click',activeElSel<?php echo $sv['id']; ?>);
                            function activeElAd<?php echo $sv['id']; ?>() {
                                postcat<?php echo $sv['id']; ?>.disabled = false;
                                postcatselect<?php echo $sv['id']; ?>.disabled = true;
                            }
                            function activeElSel<?php echo $sv['id']; ?>() {
                                postcat<?php echo $sv['id']; ?>.disabled = true;
                                postcatselect<?php echo $sv['id']; ?>.disabled = false;
                            }
                    </script>
                   <?php } ?>
                                                                    <div class="col-md-6 hide">
                                                                        Location (Google Map Latitude)
                                                                        <input type="number" step="any" class="form-control" name="gmap_lat" value="<?php echo $sv['gmap_lat']; ?>">
                                                                    </div>
                                                                    <div class="col-md-6 hide">
                                                                        Location (Google Map Longitude)
                                                                        <input type="number" step="any" class="form-control" name="gmap_long" value="<?php echo $sv['gmap_long']; ?>">
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="mb-3">
                                                                        <label for="serviceDescription" class="form-label">Description</label>
                                                                        <textarea name="service_desc" onblur="checkDate();" class="form-control tiny_textarea" id="serviceDescription<?php echo $sv['id']; ?>" rows="3"><?php echo $sv['description']; ?></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 hide">
                                                                        <div class="mb-3">
                                                                        <label for="startDate" class="form-label">Service starting Date</label>
                                                                        <input name="service_starting_date" value="<?php echo $sv['service_starting_date']; ?>" onblur="checkDate();" type="date" class="form-control" id="startDate<?php echo $sv['id']; ?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 hide">
                                                                        <div class="mb-3">
                                                                        <label for="endDate" class="form-label">Service ending Date</label>
                                                                        <input name="service_ending_date" value="<?php echo $sv['service_ending_date']; ?>" onblur="checkDate();" type="date" class="form-control" id="endDate<?php echo $sv['id']; ?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 hide">
                                                                        <div class="mb-3">
                                                                        <label for="avlSapcePerSlot" class="form-label">Available space per slot</label>
                                                                        <input name="service_avl_seat" value="<?php echo $sv['available_seat']; ?>" onblur="checkDate();" type="number" step="any" min=0 class="form-control" id="avlSapcePerSlot<?php echo $sv['id']; ?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                        <label for="pricePerSpace" class="form-label">Price</label>
                                                                        <input name="service_price" value="<?php echo $sv['price']; ?>" onblur="checkDate();" type="number" step="any" class="form-control" id="pricePerSpace<?php echo $sv['id']; ?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                        <label for="pricePerSpace" class="form-label">Sale Price</label>
                                                                        <input name="sale_price" value="<?php echo $sv['sale_price']; ?>" onblur="checkDate();" type="number" step="any" class="form-control" id="salePricePerSpace<?php echo $sv['id']; ?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 hide">
                                                                        <div class="mb-3">
                                                                        <label for="startTime" class="form-label">Daily Service start time</label>
                                                                        <input name="service_starts" value="<?php echo $sv['service_starts']; ?>" onblur="checkDate(); checkTime();" type="time" class="form-control" id="startTime<?php echo $sv['id']; ?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 hide">
                                                                        <div class="mb-3">
                                                                        <label for="endTime" class="form-label">Daily Service end time</label>
                                                                        <input name="service_ends" value="<?php echo $sv['service_ends']; ?>" onblur="checkDate(); checkTime();" type="time" class="form-control" id="endTime<?php echo $sv['id']; ?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                    <h3 class="text-danger text-center" id="msg"></h3>
                                                                    </div>
                                                                  
                                                                        <div class="mb-3 col-md-3 hide">
                                                                        <label for="serviceSlotDuration" class="form-label">Service Slot Duration</label>
                                                                    
                                                                        <input type='time' name="service_duration" value="<?php echo $sv['service_duration']; ?>" min='00:00:01' class="form-control" max='23:59:59' id="serviceSlotDuration<?php echo $sv['id']; ?>">
                                                                        <input style="display: none;" type="radio" required checked name="service_duration_type" value="hour">   
                                                                    <input style="display: none;" type="radio" required name="service_duration_type" value="minute">
                                                                    <input type="hidden" value="<?php echo $sv['id']; ?>" name="update_my_service_admin">      
                                                                    </div>
                                                                    
                                                                    <script>
                                                                        function checkDate<?php echo $sv['id']; ?>(){
                                                                            let datetimeStart = document.querySelector("#startDate<?php echo $sv['id']; ?>");
                                                                            let datetimeEnd = document.querySelector("#endDate<?php echo $sv['id']; ?>");
                                                                            let msgs = document.querySelector("#msg");
                                                                            let addServiceBtn = document.querySelector("#add-service-btn<?php echo $sv['id']; ?>");
                                                                            if(Date.parse(datetimeStart.value) > Date.parse(datetimeEnd.value)){
                                                                                msgs.innerText = "End date must be after or same as start date";
                                                                                addServiceBtn.disabled = true;
                                                                            }
                                                                            else if(Date.parse(datetimeStart.value) <= Date.parse(datetimeEnd.value)){
                                                                                msgs.innerText = "";
                                                                                addServiceBtn.disabled = false;
                                                                            }
                                                                        }
                                                                        function checkTime<?php echo $sv['id']; ?>(){
                                                                            var timefrom = new Date();
                                                                            temp = $('#startTime<?php echo $sv['id']; ?>').val().split(":");
                                                                            timefrom.setHours((parseInt(temp[0]) - 1 + 24) % 24);
                                                                            timefrom.setMinutes(parseInt(temp[1]));

                                                                            var timeto = new Date();
                                                                            temp = $('#endTime<?php echo $sv['id']; ?>').val().split(":");
                                                                            timeto.setHours((parseInt(temp[0]) - 1 + 24) % 24);
                                                                            timeto.setMinutes(parseInt(temp[1]));

                                                                            if (timeto < timefrom){
                                                                                alert('start time should be smaller than end time!');
                                                                            }
                                                                        }
                                                                        </script>
                                                                </div>
                                                            </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-success" data-bs-dismiss="modal"><i class="fa-solid fa-ban"></i> Cancel</button>
                                                        <button id="update-service-btn<?php echo $sv['id']; ?>" type="button" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Update</button>
                                                    </div>
                                                    </div>
                                                </div>
                                                </div>
                                                <!-- Modal area ends -->
                                                <?php endif; ?>
                                                <?php 
                                                $url = "/admin/services/update-service";
                                                pkAjax("#update-service-btn{$sv['id']}",$url,"#update-service-form{$sv['id']}","#res"); ?>
                                            <?php } } ?>
                                           
                                        </tbody>
                                    </table>