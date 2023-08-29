<?php if (defined("direct_access") != 1) {
    echo "Silenece is awesome";
    return;
} ?>
<?php $GLOBALS["title"] = "Home"; ?>
<?php import("apps/admin/inc/header.php"); ?>
<?php import("apps/admin/inc/nav.php");
$plugin_dir = "promotions";
?>
<?php

// if (isset($_POST['update_banner'])) {
//     $contentid = $_POST['update_banner_page_id'];
//     $banner=$_FILES['banner'];
//     $banner_name = uniqid("banner_").time().USER['id'];
//     // print_r($_FILES);
//     change_my_banner($contentid,$banner,$banner_name);
//     msg_ssn();
// }

?>
<style>
    .list-none li {
        font-weight: bold;
    }

    .menu-col {
        min-height: 300px !important;
    }
</style>
<section>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div id="sidebar-col" class="col-md-2 <?php echo sidebar_bg; ?>">
                <?php import("apps/admin/inc/sidebar.php"); ?>
            </div>
            <!-- Main Area -->
            <div id="content-col" class="col-md-10 pb-5">
                <?php import("apps/admin/pages/page-nav.php"); ?>
                <h4>Search Product</h4>
                <div class="row">
                    <div class="col-md-8">
                        <form id="add-this-product-form" action="/<?php echo home; ?>/admin/promotions/add-this-product-in-promotions-ajax" method="post">
                            <style>
                                .my-input:focus {
                                    border: 1px solid dodgerblue;
                                    /* background-color:  rgb(32,32,32); */
                                    color: dodgerblue;
                                    outline: none !important;
                                }

                                #search-book {
                                    text-indent: 10px;
                                    color: dodgerblue;
                                    border: 1px solid dodgerblue;
                                    height: 50px;
                                    width: 100%;
                                }

                                .s-div {
                                    list-style: none;
                                    position: absolute;
                                    width: 100%;
                                    display: none;
                                    height: 300px;
                                    overflow-y: scroll;
                                    background-color: black;
                                    color: white;
                                }
                            </style>
                            <div class="mb-3">
                            <?php 
                            $show = 0;
                            if( $_GET['promo']=="featured"){
                                $show = 1;
                            }elseif($_GET['promo']=="hot_deals"){
                                $show = 1;
                            }else{
                                $show = 0;
                            }
                            if($show==1):?>
                                <input type="file" class="form-control" name="promoimage">
                            <?php endif; ?>
                               
                                <input type="hidden" class="add-this-product" name="content_group" value="<?php echo $_GET['promo']; ?>">
                                <input type="hidden" class="add-this-product" name="promo_cat" value="<?php echo $_GET['id']; ?>">
                            </div>
                            <div role="search" style="position:relative;">
                                <div class="d-flex" style="position: relative;">

                                    <input id="search-book" class="my-input getEmpList" type="search" placeholder="Search Product" name="search_prod" aria-label="Search">
                                </div>
                                <?php pkAjax("#search-book", "/admin/promotions/get-product-list-ajax", ".getEmpList", "#divToHide", 'keyup');
                                ajaxActive($qry = ".progress");
                                ?>
                                <ul id="divToHide" class="s-div card py-3">
                                    <?php
                                    $prodObj = new Model('content');
                                    $arr['content_group'] = 'product';
                                    $obj = $prodObj->filter_index($arr);
                                    // $employees = $userObj->filter_index(array('user_group'=>'employee'));
                                    // print_r($genres);
                                    if ($obj == false) {
                                        $obj = array();
                                    }
                                    ?>
                                    <?php foreach ($obj as $k => $v) : ?>
                                        <li id="getEmpList<?php echo $v['id']; ?>" class="py-1 pk-pointer">
                                            <input onclick="setInSearch(`<?php echo $v['title']; ?>`)" class="add-this-product" type="radio" name="content_id" value="<?php echo $v['id']; ?>">
                                            <?php echo $v['title'] ?? $v['title'] ?? "No Name"; ?> ID: <?php echo $v['id']; ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>

                            </div>


                            <script defer>
                                function setInSearch(data) {
                                    var sBox = document.getElementById('search-book');
                                    sBox.value = data;
                                }

                                window.onload = function() {
                                    var divToHide = document.getElementById('divToHide');
                                    //   var searchInput = document.getElementById('search-book');
                                    document.onclick = function(e) {
                                        if (e.target.id !== 'search-book') {
                                            //element clicked wasn't the div; hide the div
                                            divToHide.style.display = 'none';
                                        } else if (e.target.id === 'search-book') {
                                            //element clicked wasn't the div; hide the div
                                            divToHide.style.display = 'block';
                                        }
                                    };
                                };
                            </script>

                        </form>
                    </div>
                    <div class="col-md-4">
                        <div id="res"></div>
                        <div class="d-grid">
                            <button id="add-this-product" class="btn btn-primary btn-lg">Add</button>
                            
                            <?php pkAjax_form('#add-this-product', "#add-this-product-form", "#res"); ?>
                        </div>
                        <div class="progress my-3">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-prime" role="progressbar" aria-label="Animated striped example" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                        </div>
                    </div>
                </div>
            </div>




            <script>
                // function selectImagee(btnId,inputfileId) {
                //   var btnId = document.getElementById(btnId);
                //   var inputfileId = document.getElementById(inputfileId);
                //   btnId.addEventListener('click',()=>{
                //     inputfileId.click();
                //   });
                // }
                // selectImagee("selectImageBtn","banner-img");
            </script>
            <div id="res"></div>
            <?php pkAjax_form("#add-new-cat-btn", "#add-new-product-btn-form", "#res", 'click', 'post', true); ?>
            <?php ajaxActive(".progress"); ?>







            <!-- Main Area ends-->
        </div>
    </div>
    </div>
</section>
<?php import("apps/admin/inc/footer.php"); ?>