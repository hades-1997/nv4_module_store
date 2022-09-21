<!-- BEGIN: main -->
<div class="page panel panel-default">
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-24 col-sm-12 col-md-8">
                <!-- BEGIN: image -->
                <img alt="{CONTENT.imagealt}" src="{CONTENT.image}" class="img-thumbnail">
                <!-- END: image -->
            </div>
            <div class="col-xs-24 col-sm-12 col-md-16">
                <h1 class="title">{CONTENT.title}</h1>
                <p class="description-note">
                    <span>
                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                        {CONTENT.add_time}
                    </span>
                    <span>
                        <em class="fa fa-eye">&nbsp;</em>&nbsp;{CONTENT.hitstotal}
                    </span>
                </p>
                
                <div class="clearfix aution">
                    <ul>
                        <!-- BEGIN: category -->
                        <li><a href="{CATEGORY.link}" title="{CATEGORY.title}"><i class="fa fa-certificate" aria-hidden="true"></i>&nbsp;{CATEGORY.title}</a></li>
                        <!-- END: category -->
                        <!-- BEGIN: telephone -->
                        <li><a href="tel:{CONTENT.sdt}" title="{CONTENT.sdt}"><i class="fa fa-phone" aria-hidden="true"></i>&nbsp;{CONTENT.sdt}</a></li>
                        <!-- END: telephone -->
                        <!-- BEGIN: email -->
                        <li><a href="mail:{CONTENT.email}" title="{CONTENT.email}"><i class="fa fa-envelope-o" aria-hidden="true"></i>&nbsp;{CONTENT.email}</a></li>
                        <!-- END: email -->
                        <!-- BEGIN: address -->
                        <li><i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;{CONTENT.dia_chi}</li>
                        <!-- END: address -->
                        <!-- BEGIN: website -->
                        <li><a href="{CONTENT.website}" title="{CONTENT.website}" target="_blank"><i class="fa fa-life-ring" aria-hidden="true"></i>&nbsp;{CONTENT.website}</a></li>
                        <!-- END: website -->
                        <!-- BEGIN: facebook -->
                        <li><a href="{CONTENT.facebook}" title="{CONTENT.facebook}" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i>&nbsp;{CONTENT.facebook}</a></li>
                        <!-- END: facebook -->
                    </ul>
                </div>   
            </div>     
        </div>
        
        <div class="clearfix content-tab">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#bodytext">{LANG.bodytext}</a></li>
                <li><a data-toggle="tab" href="#bodytext_maps">{LANG.bodytext_maps}</a></li>
                <li><a data-toggle="tab" href="#images">{LANG.images}</a></li>
            </ul>
            
            <div class="tab-content">
                <div id="bodytext" class="tab-pane fade in active">
                    {CONTENT.bodytext}
                </div>
                <div id="bodytext_maps" class="tab-pane fade">
                    <div id="maps">
                        <div id="map"></div>
                        <script>
                          function initMap() {
                            // Styles a map in night mode.
                            var uluru = {lat: {DATA.lat}, lng: {DATA.lng}};
                            var map = new google.maps.Map(document.getElementById('map'), {
                              center: {lat: {DATA.lat}, lng: {DATA.lng}},
                              zoom: {DATA.zoom},
                              scrollwheel: false,
                            });
                            var marker = new google.maps.Marker({
                               position: uluru,
                               map: map,
                             });
                          }
                        </script>
                        <script async defer src="https://maps.googleapis.com/maps/api/js?key={CONFIG.key_map}&callback=initMap"></script>
                    </div>
                </div>
                <div id="images" class="tab-pane fade">
                    <div class="row">
                        <!-- BEGIN: image_loop -->
                        <div class="col-xs-24 col-sm-12 col-md-8">
                            <img alt="{IMAGE.imagealt}" src="{IMAGE.image}" class="img-thumbnail">
                        </div>
                        <!-- END: image_loop -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- BEGIN: other -->
<div class="panel panel-default">
    <div class="panel-heading">
        {LANG.related}
    </div>
    <div class="panel-body">
        <div class="row">
            <!-- BEGIN: loop -->
            <div class="col-xs-24 col-sm-12 col-md-8">
                <div class="margin-bottom-lg border-color">
                    <!-- BEGIN: image -->
                    <div class="text-center">
                        <a title="{OTHER.title}" href="{OTHER.link}"><img <!-- BEGIN: alt -->alt="{OTHER.imagealt}"<!-- END: alt --> src="{OTHER.image}" width="{OTHER.imageWidth}" class="img-thumbnail" /></a>
                    </div>
                    <!-- END: image -->
                    <div class="caption">
                        <h3><a title="{OTHER.title}" href="{OTHER.link}">{OTHER.title}</a></h3>
                        <p class="description-note">
                            <span>
                                <i class="fa fa-clock-o" aria-hidden="true"></i>
                                {OTHER.add_time}
                            </span>
                            <span>
                                <em class="fa fa-eye">&nbsp;</em>&nbsp;{OTHER.hitstotal}
                            </span>
                        </p>
                        <ul>
                            <!-- BEGIN: telephone -->
                            <li><a href="tel:{OTHER.sdt}" title="{OTHER.sdt}"><i class="fa fa-phone" aria-hidden="true"></i>&nbsp;{OTHER.sdt}</a></li>
                            <!-- END: telephone -->
                            <!-- BEGIN: email -->
                            <li><a href="mail:{OTHER.email}" title="{OTHER.email}"><i class="fa fa-envelope-o" aria-hidden="true"></i>&nbsp;{OTHER.email}</a></li>
                            <!-- END: email -->
                        </ul>
                    </div>
                </div>
            </div>
            <!-- END: loop -->
       </div>
    </div>
</div>
<!-- END: other -->
<!-- END: main -->