<?php
$v = "v2";
define("API_V",$v);
header("Access-Control-Allow-Origin: *");
// header('Access-Control-Allow-Origin: https://www.example.com');
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
import("apps/api/$v/function.php");

if (token_security==true){
    if (getBearerToken()!==sitekey) {
        $msg['msg'] = "Invalid Authorization";
            header("HTTP/1.0 503 Forbiden");
            $msg['msg'] = "503 Forbiden";
            echo json_encode($msg);
        die();
     }
}

$url = explode("/", $_SERVER["QUERY_STRING"]);
$path = $_SERVER["QUERY_STRING"];
$GLOBALS['urlend'] = end($url);
$GLOBALS['urlprev'] = prev($url);

if ("$url[0]/$v" == "api/$v") {
    if (count($url)>=4) {

//get categories
        if ("{$url[2]}/$url[3]" == "get/categories") {
            import("apps/api/$v/api.categories/api.get.categories.php");
            return;
        }
//get categories
        if ("{$url[2]}/$url[3]" == "get/popular-categories") {
            import("apps/api/$v/api.categories/api.get-popular.categories.php");
            return;
        }
//search categories
        if ("{$url[2]}/$url[3]" == "search/categories") {
            import("apps/api/$v/api.categories/api.search.categories.php");
            return;
        }
// //get sub categories
//         if ("{$url[2]}/$url[3]" == "get/sub-categories") {
//             import("apps/api/$v/api.categories/api.get.sub-categories.php");
//             return;
//         }
// search salons by cat id
        if ("{$url[2]}/$url[3]" == "search/salon-list-by-cat-id") {
            import("apps/api/$v/api.listings/api.search.salon-list-by-cat-id.php");
            return;
        }
// get salons by cat id
        if ("{$url[2]}/$url[3]" == "get/salon-list-by-cat-id") {
            import("apps/api/$v/api.listings/api.get.salon-list-by-cat-id.php");
            return;
        }
// get salon details
        if ("{$url[2]}/$url[3]" == "get/salon-by-salon-id") {
            import("apps/api/$v/api.listings/api.get.salon-details-by-salon-id.php");
            return;
        }
// get my fav salons by token
        if ("{$url[2]}/$url[3]" == "get/fav-salon-by-user-token") {
            import("apps/api/$v/api.listings/api.get.fav-salon-list-by-user-token.php");
            return;
        }
// get salons id
        if ("{$url[2]}/$url[3]" == "get/fav-salon-by-user-token") {
            import("apps/api/$v/api.listings/api.get.fav-salon-list-by-user-token.php");
            return;
        }
// get services salon id
        if ("{$url[2]}/$url[3]" == "get/services-by-salon-id") {
            import("apps/api/$v/api.listings/api.get.services-by-salon-id.php");
            return;
        }
// request parcel booking
        if ("{$url[2]}/$url[3]" == "request-for/parcel-booking") {
            import("apps/api/$v/api.bookings/api.book-my-parcel.php");
            return;
        }
// get available bookings
        if ("{$url[2]}/$url[3]" == "get/available-bookings") {
            import("apps/api/$v/api.bookings/api.get-available-bookings.php");
            return;
        }
// send quote by driver
        if ("{$url[2]}/$url[3]" == "send/quote-by-driver") {
            import("apps/api/$v/api.bookings/api.send-quote-by-driver-on-avl-bookings.php");
            return;
        }
// send running orders
        if ("{$url[2]}/$url[3]" == "driver/running-bookings") {
            import("apps/api/$v/api.bookings/api.driver-running-bookings.php");
            return;
        }
// get my bookings
        if ("{$url[2]}/$url[3]" == "get/my-bookings") {
            import("apps/api/$v/api.bookings/api.get-my-bookings.php");
            return;
        }
// driver requests on bookings
        if ("{$url[2]}/$url[3]" == "driver/requests-his-on-bookings") {
            import("apps/api/$v/api.bookings/api.driver-requests-his-on-bookings.php");
            return;
        }










// request for changes booking visiting date and time
        if ("{$url[2]}/$url[3]" == "request-for/change-booking-schedule") {
            import("apps/api/$v/api.bookings/api.change-my-booking-datetime.php");
            return;
        }
// booking history
        if ("{$url[2]}/$url[3]" == "get/booking-history") {
            import("apps/api/$v/api.bookings/api.salon-services-booking-history.php");
            return;
        }
// booking details
        if ("{$url[2]}/$url[3]" == "get/booking-detail-by-booking-id") {
            import("apps/api/$v/api.bookings/api.salon-services-booking-details.php");
            return;
        }
// Cancel my booking
        if ("{$url[2]}/$url[3]" == "cancel/my-booking") {
            import("apps/api/$v/api.bookings/api.cancel-my-booking.php");
            return;
        }
// Coupons verify
        if ("{$url[2]}/$url[3]" == "coupon/verify") {
            import("apps/api/v2/api.coupons/api.verify-coupon.php");
            return;
        }
// Coupons verify
        if ("{$url[2]}/$url[3]" == "coupon/list-by-user-token") {
            import("apps/api/v2/api.coupons/api.get-coupon-list-user-token.php");
            return;
        }
//get locations
        if ("{$url[2]}/$url[3]" == "get/locations") {
            import("apps/api/$v/api.locations/api.get.locations.php");
            return;
        }
//get listings
        if ("{$url[2]}/$url[3]" == "get/listings") {
            import("apps/api/$v/api.listings/api.get.listings.php");
            return;
        }
//get to rated listings
        if ("{$url[2]}/$url[3]" == "top/rated-salon-list") {
            import("apps/api/$v/api.listings/api.get.top-rated-salon-list.php");
            return;
        }
//get to recent visist list
        if ("{$url[2]}/$url[3]" == "get/my-recent-visit-list") {
            import("apps/api/$v/api.listings/api.get.recent-visit-salon-list.php");
            return;
        }
//get companies
        if ("{$url[2]}/$url[3]" == "get/companies") {
            import("apps/api/$v/api.companies/api.get.companies.php");
            return;
        }

// send enquiry
        if ("{$url[2]}/$url[3]" == "send/enquiry") {
            import("apps/api/$v/api.enquiries/api.send-enquiry.php");
            return;
        }
//get sliders
        if ("{$url[2]}/$url[3]" == "get/sliders") {
            import("apps/api/$v/api.sliders/api.get.sliders.php");
            return;
        }
        // if ("{$url[2]}/$url[3]" == "get/deal-sliders") {
        //     import("apps/api/$v/api.sliders/api.get.deal-sliders.php");
        //     return;
        // }
//get sliders
        if ("{$url[2]}/$url[3]" == "get/plans") {
            import("apps/api/$v/api.plans/api.get.plans.php");
            return;
        }
//buy plan
        if ("{$url[2]}/$url[3]" == "buy/plan") {
            import("apps/api/$v/api.plans/api.buy.plan.php");
            return;
        }
//my purchased plans
        if ("{$url[2]}/$url[3]" == "my/plans") {
            import("apps/api/$v/api.plans/api.get-my.plans.php");
            return;
        }
//get banners
        if ("{$url[2]}/$url[3]" == "get/banners") {
            import("apps/api/$v/api.banners/api.get.banners.php");
            return;
        }

//My payments
        if ("{$url[2]}/$url[3]" == "my/payment") {
            import("apps/api/$v/api.payments/api.my.payment_by_id.php");
            return;
        }
//My all payments
        if ("{$url[2]}/$url[3]" == "my/all-payments") {
            import("apps/api/$v/api.payments/api.my.all_payments.php");
            return;
        }
//Update Listing
        if ("{$url[2]}/$url[3]" == "update/listing") {
            import("apps/api/$v/api.listings/api.update.listing.php");
            return;
        }
//create Listing
        if ("{$url[2]}/$url[3]" == "create/listing") {
            import("apps/api/$v/api.listings/api.create.listing.php");
            return;
        }
//create enquiry
        if ("{$url[2]}/$url[3]" == "create/enquiry") {
            import("apps/api/$v/api.enquiries/api.create.enquiry.php");
            return;
        }
//get enquiry
        if ("{$url[2]}/$url[3]" == "get/enquiry") {
            import("apps/api/$v/api.enquiries/api.get.enquiries.php");
            return;
        }

//User login
        if ("{$url[2]}/$url[3]" == "user/login") {
            import("apps/api/$v/api.users/api.user.login.php");
            return;
        }
        if ("{$url[2]}/$url[3]" == "user/login-via-token") {
            import("apps/api/$v/api.users/api.user.login-via-token.php");
            return;
        }
        //get users
        if ("{$url[2]}/$url[3]" == "get/users") {
            import("apps/api/$v/api.users/api.get.user.php");
            return;
        }
// Sign Up user
        if ("{$url[2]}/$url[3]" == "user/signup") {
            import("apps/api/$v/api.users/api.user.signup.php");
            return;
        }
// Reg company
        if ("{$url[2]}/$url[3]" == "reg/company") {
            import("apps/api/$v/api.companies/api.reg.company.php");
            return;
        }
// My  companies
        if ("{$url[2]}/$url[3]" == "get/my-companies") {
            import("apps/api/$v/api.companies/api.get.my-companies.php");
            return;
        }
// My  companies
        if ("{$url[2]}/$url[3]" == "update/my-company") {
            import("apps/api/$v/api.companies/api.update.my-company.php");
            return;
        }
// Profile details 
        if ("{$url[2]}/$url[3]" == "profile/details") {
            import("apps/api/$v/api.users/api.profile-details.php");
            return;
        }
        if ("{$url[2]}/$url[3]" == "update/profile-details") {
            import("apps/api/$v/api.users/api.update.profile-details.php");
            return;
        }

//User update
        if ("{$url[2]}/$url[3]" == "update/user") {
            import("apps/api/$v/api.account/api.update.user.php");
            return;
        }
// mark this salon as fav 
        if ("{$url[2]}/$url[3]" == "mark-salon/as-fav") {
            import("apps/api/$v/api.listings/api.mark-as-fav.php");
            return;
        }
// rate this salon 
        if ("{$url[2]}/$url[3]" == "rate/this-salon-by-user-token") {
            import("apps/api/$v/api.listings/api.star-rate-salon-by-user-token.php");
            return;
        }
//get all medias
        // if ("{$url[2]}/$url[3]" == "get/medias") {
        //     import("apps/api/$v/api.gallery/api.medias.php");
        //     return;
        // }
// reset account
        // if ("{$url[2]}/$url[3]" == "reset/account") {
        //     import("apps/api/$v/api.account/api.reset-account.php");
        //     return;
        // }
       
// address
        // if ("{$url[2]}/$url[3]" == "create/address") {
        //     import("apps/api/$v/api.address/api.create.address.php");
        //     return;
        // }
        // if ("{$url[2]}/$url[3]" == "update/address") {
        //     import("apps/api/$v/api.address/api.update.address.php");
        //     return;
        // }
        // if ("{$url[2]}/$url[3]" == "delete/address") {
        //     import("apps/api/$v/api.address/api.delete.address.php");
        //     return;
        // }
        // if ("{$url[2]}/$url[3]" == "get/address") {
        //     import("apps/api/$v/api.address/api.get-address.php");
        //     return;
        // }
        
    }
//404
        else{
            header("HTTP/1.0 404 Not Found");
            $msg['msg'] = "404, Page not found";
            echo json_encode($msg);
            return;
        }
}