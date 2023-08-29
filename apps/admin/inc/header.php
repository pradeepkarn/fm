<!doctype html>
<html dir="ltr" lang="en">
  <head>
    <link rel="icon" href="/<?php echo media_root; ?>/logo/favicon.png" type="image/gif" sizes="16x16">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="/<?php echo STATIC_URL; ?>/admin/css/styles.bs.css" rel="stylesheet" />
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" type="text/css" href="/<?php echo STATIC_URL; ?>/admin/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script> -->
 <!-- <script src="/<?php //echo STATIC_URL; ?>/js/jquery.js"></script> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://www.w3schools.com/lib/w3.js"></script>
  <script src="https://cdn.tiny.cloud/1/mhpaanhgacwjd383mnua79qirux2ub6tmmtagle79uomfsgl/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <title><?php if (isset($GLOBALS["title"])) {echo $GLOBALS["title"]; }  ?></title>
    <style>
  .sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: 15%;
    height: 100vh;
    /* transition: all 1s cubic-bezier(0.75,0.82,0.165,1); */
    box-shadow: 0 0 4px rgba(0,0,0,0.5);
    background-color: rgba(255,255,255,1);
    overflow-y: scroll;
  }

  .side-nav{
    position: relative;
    top: 70px;
  }
  .side-nav ul{
    position: relative;
    left: 10px;
  }
  .content{
    position: relative;
    margin-left: auto;
    width: 85%;
  }
  .ht-100vh{
    height: 100vh;
  }

  .mobile-sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: 50%;
    height: 100vh;
    /* transition: all 1s cubic-bezier(0.75,0.82,0.165,1); */
    /* box-shadow: 0 0 4px rgba(0,0,0,0.5); */
    background-color: rgba(255,255,255,1);
    overflow-y: scroll;
    z-index: +1;
  }
  .mobile-content{
    position: relative;
    margin-left: auto;
    width: 100%;
  }
</style>
<style>
    #sidebar-col{
        min-height: 100vh;
        /* background-color: rgb(33,37,41); */
    }
</style>
<style>
.pagination {
  display: inline-block;
}

.pagination a {
  color: black;
  float: left;
  padding: 8px 16px;
  text-decoration: none;
  transition: background-color .3s;
  border: 1px solid #ddd;
  margin: 0 4px;
}

.pagination a.active {
  background-color: #4CAF50;
  color: white;
  border: 1px solid #4CAF50;
}

.pagination a:hover:not(.active) {background-color: #ddd;}
</style>
  </head>
  <body>
      