<!-- BEGIN: main -->
<link rel="stylesheet" type="text/css" href="{NV_BASE_SITEURL}themes/{TEMPLATE}/css/store/owl.carousel.min.css">
<link rel="stylesheet" type="text/css" href="{NV_BASE_SITEURL}themes/{TEMPLATE}/css/store/owl.theme.default.min.css">
<link rel="stylesheet" type="text/css" href="{NV_BASE_SITEURL}themes/{TEMPLATE}/css/store/store.css">

<div id="owl-store" class="owl-carousel owl-theme">
    <!-- BEGIN: loop -->
    <div class="item">
        <!-- BEGIN: img -->
        <img alt="{ROW.imagealt}" src="{ROW.image}">
        <!-- END: img -->
        <div class="caption">
            <h3><a title="{ROW.title}" href="{ROW.link}">{ROW.title}</a></h3>
        </div>
    </div>
    <!-- END: loop -->
</div>
<script type="text/javascript" src="{NV_BASE_SITEURL}themes/{TEMPLATE}/js/store/owl.carousel.min.js"></script>
<script type="text/javascript">
$('#owl-store').owlCarousel({
    loop:true,
    margin:10,
    nav:false,
    dots: false,
    autoplay:true,
    autoplayTimeout:3000,
    autoplayHoverPause:true,
     responsive:{
        0:{
            items:1,
            nav:false
        },
        380:{
            items:2,
            nav:false
        },
        480:{
            items:2,
            nav:false
        },
        600:{
            items:3,
            nav:false
        },
        800:{
            items:4,
            nav:false
        },
        992:{
            items:5,
            nav:false,
        }
    },
})
</script>
<!-- END: main -->