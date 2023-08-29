<?php
class ApplyForCert 
{
    private $dbTableObj;
    public function __construct()
    {
        $this->dbTableObj = new Model('pk_user');
    }
    public function save_form_data($userid = 0)
    {
            if (authenticate()!=true) {
                $_SESSION['msg'][] = "Please login";
                die();
             }
            if (!isset($_POST['save_my_form'])) {
                $_SESSION['msg'][] = "Invalid Form";
                die();
            }
            extract($_POST);           
            $data["col_num"] = isset($col_num)?$col_num:null;
            $data["ins_date"] = isset($ins_date)?$ins_date:null;
            $data["acid"] = isset($acid)?$acid:null;
            $data["importer_num"] = isset($importer_num)?$importer_num:null;
            $data["importer_address"] = isset($importer_address)?$importer_address:null;
            $data["producer"] = isset($producer)?$producer:null;
            $data["producer_address"] = isset($producer_address)?$producer_address:null;
            $data["exporter"] = isset($exporter)?$exporter:null;
            $data["exporter_address"] = isset($exporter_address)?$exporter_address:null;
            $data["invoice_amt"] = isset($invoice_amt)?$invoice_amt:null;
            $data["invoice_number"] = isset($invoice_number)?$invoice_number:null;
            $data["invoice_date"] = isset($invoice_date)?$invoice_date:null;
            $data["method_of_shipment"] = isset($method_of_shipment)?$method_of_shipment:null;
            $data["document_number"] = isset($document_number)?$document_number:null;
            $data["document_date"] = isset($document_date)?$document_date:null;
            $data["country_of_shipment"] = isset($country_of_shipment)?$country_of_shipment:null;
            $data["point_of_entry"] = isset($point_of_entry)?$point_of_entry:null;
            $data["num_n_pkg_typ"] = isset($num_n_pkg_typ)?$num_n_pkg_typ:null;
            $data["container_truck_num"] = isset($container_truck_num)?$container_truck_num:null;
            $data["declared_unit_qty"] = isset($declared_unit_qty)?$declared_unit_qty:null;
            $data["country_of_origin"] = isset($country_of_origin)?$country_of_origin:null;
            $data["brand_desc"] = isset($brand_desc)?$brand_desc:null;
            $data["accridated"] = isset($accridated)?$accridated:null;

            if ($userid!=0 && filter_var($userid, FILTER_VALIDATE_INT)) {
                try {
                    $this->dbTableObj->update($userid,array('application_json_data'=>json_encode($data)));
                    $_SESSION['msg'][] = "Congaratulations you have successfully applied";
                    return;
                } catch (\Throwable $th) {
                    $_SESSION['msg'][] = "Something went wrong";
                    die();
                }
            }
    }
            
            
}
