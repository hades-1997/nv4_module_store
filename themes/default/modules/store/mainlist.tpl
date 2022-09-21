<!-- BEGIN: main -->
<!-- BEGIN: cata -->
<div class="panel panel-default clearfix">
    <div class="panel-heading">
        <ul class="list-inline sub-list-icon" style="margin: 0">
            <li><h4><a title="{CAT.title}" href="{CAT.link}"><span>{CAT.title}</span></a></h4></li>
        </ul>
    </div>
    <div class="panel-body">
        <!-- BEGIN: loop -->
        <div class="clearfix">
            <!-- BEGIN: image -->
            <a href="{ROW.link}" title="{ROW.title}"><img src="{ROW.image}" alt="{ROW.imagealt}" class="img-thumbnail pull-left"/></a>
            <!-- END: image -->
            <h3><a href="{ROW.link}" title="{ROW.title}">{ROW.title}</a></h3>
            <p class="description-note">
                <span>
                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                    {ROW.add_time}
                </span>
                <span>
                    <em class="fa fa-eye">&nbsp;</em>&nbsp;{ROW.hitstotal}
                </span>
            </p>
            <ul>
                <!-- BEGIN: telephone -->
                <li><a href="tel:{ROW.sdt}" title="{ROW.sdt}"><i class="fa fa-phone" aria-hidden="true"></i>&nbsp;{ROW.sdt}</a></li>
                <!-- END: telephone -->
                <!-- BEGIN: email -->
                <li><a href="mail:{ROW.email}" title="{ROW.email}"><i class="fa fa-envelope-o" aria-hidden="true"></i>&nbsp;{ROW.email}</a></li>
                <!-- END: email -->
            </ul>
            <hr>
        </div>
        <!-- END: loop -->
    </div>
</div>
<!-- END: cata -->
<!-- END: main -->