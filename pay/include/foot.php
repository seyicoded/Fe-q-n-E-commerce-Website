<?php
    $head_url= "../";
    //if online $head_url = "pay.femquen.com/";
?>
<!-- <link href="<?php echo $head_url;?>"> -->
<script type="text/javascript" src="<?php echo $head_url;?>template/js/wow.min.js"></script>
<script src="src/bs-dist/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo $head_url;?>owlcarousel/owl.carousel.min.js"></script>
<script type="text/javascript">
    //Initiat WOW JS
    new WOW().init();
</script>
<script>
    $('.carousel').carousel({
        interval:3000,
        pause:"hover"
    })
</script>
