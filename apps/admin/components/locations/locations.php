<!-- Team Section -->
     
<style>
    div.image img{
        width: 100%;
    }
</style>
<section id="team">
        
            <div class="row">
                <div class="col-md-12">
                    <div class="intro">
                        <h3>Locations</h3>
                        <div id="ajaxCall" class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                            </div>
                        <p>Enter your locations with <b>Latitude</b> and <b>Longitude</b> coordinates</p>
                    </div>
                </div>
                <div class="col-md-8">
                        <div class="row">
                        <div class="col-md-6">
                            <b>Longitude</b>
                            <input type="text" name="longitude" class="loc-data form-control" placeholder="Longitude Coordinate">
                        </div>
                        <div class="col-md-6">
                            <b>Latitude</b>
                            <input type="text" name="latitude" class="loc-data form-control" placeholder="Latitude Coordinate">
                        </div>
                        <div class="col-md-12">
                            <b>Location Name</b>
                            <textarea name="location_name" class="loc-data form-control" placeholder="Location name" rows="3"></textarea>
                        </div>
                        <div class="col-md-12">
                            <div class="d-grid my-3">
                                <button id="saveBtn" class="btn btn-lg btn-secondary">Save</button>
                            </div>
                            <div id="res"></div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <?php 
            ajaxActive("#ajaxCall");
            pkAjax("#saveBtn","/admin/save-locations-ajax",".loc-data","#res"); ?>
      
     </section>