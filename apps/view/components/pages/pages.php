<?php
$user = USER;
$url = explode("/", $_SERVER["QUERY_STRING"]);
$slug = $url['0'];
$page = get_content_by_slug($slug=$slug);
// myprint($page);
?>

<section style="min-height: 100vh; padding-top:100px;">
  <div class="container">
    <div class="row">
      <div class="col-10 mx-auto grid-margin">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title"><?php echo $page['title']; ?> </h4>
            <?php echo $page['content']; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php pkAjax_form("#updateProfileBtn", "#update-my-profile-form", "#res") ?>