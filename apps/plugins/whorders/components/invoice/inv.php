<?php
if (isset($_GET['tid'])) {
    $ord = get_order_by_uinique_id($uid = $_GET['tid'])[0];
    // echo "<pre>";
    // print_r($ord);
    // echo "</pre>";
}
?>
<style>
    .top-to-btm{
        /* background-image: linear-gradient( #04c786 , #00626d);
        -webkit-text-fill-color: transparent;
        -webkit-background-clip: text;
        background-clip: text;
        border: none; */
        background: #04C786;
background: linear-gradient(to bottom, #04C786 0%, #00626D 100%);
-webkit-background-clip: text;
-webkit-text-fill-color: transparent;
background-clip: text;

    }
    .top-hd{
        font-size: 30px;
        font-weight: 700;
    }
    .strip{
        height: 40px;
        background-image: linear-gradient(to right, #04c786 , #00626d);
    }
    .inv-text{
        position: absolute;
        color: rgba(102,102,102,255);
        font-size: 55px;
        font-weight: 500;
        top: -44px;
        right: 8px;
    }
    .in-text-col{
        position: relative;
        margin-top: 20px;
    }
</style>
<section>
    <div class="container">
        <div class="row my-3">
            <div class="col-5">
                <div class="top-hd top-to-btm">Mashail Al-Qasr</div>
                <div>Trading & Contarcting Co.</div>
                <div>VAT No.</div>
                <div>Tel</div>
                <div>Riyadh Al-Shifa</div>
            </div>
            <div class="col-2 text-center">
                <img style="max-height:120px;" src="/<?php echo MEDIA_URL; ?>/images/inv.logo.png" alt="">
            </div>
            <div class="col-5 text-end">
                <div class="top-hd top-to-btm">Mashail Al-Qasr</div>
                <div>Trading & Contarcting Co.</div>
                <div>VAT No.</div>
                <div>Tel</div>
                <div>Riyadh Al-Shifa</div>
            </div>
        </div>
        <div class="row strip-row">
            <div class="col-6 strip">

            </div>
            <div class="col-4 in-text-col">
                <div class="top-hd inv-text">
                    INVOICE
                </div>
            </div>
            <div class="col-2 strip">

            </div>
        </div>
        <div class="row">
            <h1 class="text-center top-to-btm"> Lorem </h1>
        </div>
    </div>
</section>

<script>
    const myPrint = (obj) =>{
     
        obj.style.display = "none";
        if (obj.style.display=="none") {
            window.print();
        }
    }
    document.addEventListener('mouseover', ()=>{
        document.getElementById("printBtn").style.display = 'inline-block';
    })
    
</script>