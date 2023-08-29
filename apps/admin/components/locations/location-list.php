<?php 
$locListObj = new Model('locations');
// $locListObj->json_obj = true;
$allloc = $locListObj->index();

?>
    
<section>  
        <div class="row">
            <div class="col-md-12">
                <div class="intro">
                    <h3>All Locations</h3>
                    
                </div>
            </div>
            <div class="col-md-8">
            <table class="table table-hover">
                    <thead>
                        <tr>
                       
                            <th scope="col">Longitude</th>
                            <th scope="col">Latitude</th>
                            <th scope="col">Location Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($allloc as $key => $lv): ?>                       
                        <tr>
                            <td><?php echo $lv['longitude']; ?></td>
                            <td><?php echo $lv['latitude']; ?></td>
                            <td><?php echo $lv['location_name']; ?></td>
                   
                        </tr>
                        <?php endforeach; ?>
                        
                    </tbody>
                    </table>
            </div>
        </div>
        
      
     </section>