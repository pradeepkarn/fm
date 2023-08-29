<?php
function booking_detail_by_user_api($user_id, $booking_id)
{
    $proms = new Model('salon_bookings');
    return $proms->filter_index(array('user_id' => $user_id, 'id' => $booking_id));
}
function booking_by_user($user_id, $status = 'requested')
{
    if ($status == null) {
        $proms = new Model('salon_bookings');
        return $proms->filter_index(array('user_id' => $user_id));
    }
    $proms = new Model('salon_bookings');
    return $proms->filter_index(array('user_id' => $user_id, 'status' => $status));
}
function change_booking_satus_api($user_id, $booking_id, $status = 'cancelled', $db = null)
{
    if ($db != null) {
        $proms = $db;
    } else {
        $proms = new Dbobjects;
    }
    $proms->tableName = 'salon_bookings';
    $bkng = $proms->filter(['user_id' => $user_id, 'id' => $booking_id]);
    if (count($bkng) > 0) {
        if ($bkng[0]['status'] == 'cancelled') {
            $res['msg'] = "This booking has already been cancelled";
            $res['data'] = false;
            return $res;
        }
        $proms->insertData['status'] = $status;
        try {
            $proms->update();
            $res['msg'] = "success";
            $res['data'] = true;
            return $res;
        } catch (PDOException $e) {
            $res['msg'] = "Database exception while changing status";
            $res['data'] = false;
            return $res;
        }
    } else {
        $res['msg'] = "Not cancelled, data not found in your booking list";
        $res['data'] = false;
        return $res;
    }
}

function change_visiting_datetime($user_id, $booking_id, $date, $time, $db = null)
{
    if ($db != null) {
        $proms = $db;
    } else {
        $proms = new Dbobjects;
    }
    $proms->tableName = 'salon_bookings';
    $bkng = $proms->filter(['user_id' => $user_id, 'id' => $booking_id]);
    if (count($bkng) > 0) {
        if ($bkng[0]['status'] == 'cancelled') {
            $res['msg'] = "This booking has already been cancelled";
            $res['data'] = false;
            return $res;
        }
        $proms->insertData['visiting_date'] = $date;
        $proms->insertData['visiting_time'] = $time;
        try {
            $proms->update();
            $res['msg'] = "success";
            $res['data'] = true;
            return $res;
        } catch (PDOException $e) {
            $res['msg'] = "Database exception while changing schedule";
            $res['data'] = false;
            return $res;
        }
    } else {
        $res['msg'] = "Not updated, data not found in your booking list";
        $res['data'] = false;
        return $res;
    }
}

function total_service_time($jsnData)
{
    $total_min = 0;
    $jsn = json_decode($jsnData);
    if (isset($jsn->services)) {
        foreach ($jsn->services as $srvid) {
            $srvs = getData('content', $srvid->id);
            if ($srvs) {
                $srvs = obj($srvs);
                if ($srvs->duration_unit == "min") {
                    $total_min += $srvs->duration;
                } else {
                    $total_min += $srvs->duration * 60;
                }
            }
        }
    }
    return floor($total_min / 60) . "Hr:" . ($total_min % 60) . "Min";
}

function format_parcel_bookings(array $bk)
{
    $bk = obj($bk);
    unset($bk->user_email);
    $bk->from_coordinate = json_decode($bk->from_coordinate);
    $bk->to_coordinate = json_decode($bk->to_coordinate);
    $bk->user_amount = floatval($bk->user_amount);
    $bk->driver_amount = floatval($bk->driver_amount);
    $bk->length = floatval($bk->length);
    $bk->width = floatval($bk->width);
    $bk->height = floatval($bk->height);
    $bk->weight = floatval($bk->weight);
    $bk->driver_amount = floatval($bk->driver_amount);
    if ($bk->assigned_driver_id != 0 && $bk->assigned_driver_id != '') {
        $drv = obj(getData('pk_user', $bk->assigned_driver_id));
        $bk->assigned_driver = array(
            'id' => $drv->id,
            'first_name' => $drv->first_name,
            'last_name' => $drv->last_name,
            'image' => dp_or_null($drv->image),
            'isd_code' => $drv->isd_code,
            'mobile' => $drv->mobile,
            'email' => $drv->email,
        );
    } else {
        $bk->assigned_driver = null;
    }
    if ($bk->user_id != 0 && $bk->user_id != '') {
        $usr = obj(getData('pk_user', $bk->user_id));
        $bk->user = array(
            'id' => $usr->id,
            'first_name' => $usr->first_name,
            'last_name' => $usr->last_name,
            'image' => dp_or_null($usr->image),
            'isd_code' => $usr->isd_code,
            'mobile' => $usr->mobile,
            'email' => $usr->email,
        );
    } else {
        $bk->user = null;
    }

    return $bk;
}
function format_quote(array $qoute)
{
    $qt = obj($qoute);
    $qt->quote_amount = floatval($qt->quote_amount);
    $qt->driver_id = intval($qt->driver_id);
    $qt->booking = format_parcel_bookings(getData('parcel_bookings',$qt->booking_id));
    $qt->is_confirmed = boolval($qt->is_confirmed);
    return $qt;
}
