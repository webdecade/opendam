<h1>Citi Search</h1>
<script type="text/javascript">
    function albumCheck()
    {

        var albumtag = [];
        var retailertag = [];
        var devicetag = [];
        var messagetag = [];
        var pagetag = [];
        var typetag = [];
        $("input:checkbox").each(function()
        {
            var $this = $(this);
            if ($this.is(":checked"))
            {
                var id = $this.attr("id")
                if (id.contains('chkalb'))
                {
                    albumtag.push($('#' + id).val());
                }
                if (id.contains('chkrel'))
                {
                    retailertag.push($('#' + id).val());
                }
                if (id.contains('chkdev'))
                {
                    devicetag.push($('#' + id).val());
                }
                if (id.contains('chkmsg'))
                {
                    messagetag.push($('#' + id).val());
                }
                if (id.contains('chkpage'))
                {
                    pagetag.push($('#' + id).val());
                }
                if (id.contains('chkmsgtype'))
                {
                    typetag.push($('#' + id).val());
                }
            }
        });
        $dataparam = "";
        var chkflag = 0;
        if (albumtag != "")
        {
            $dataparam = $dataparam + "&album_tag=" + albumtag;
            chkflag = 1;
        }
        if (retailertag != "")
        {
            $dataparam = $dataparam + "&ret_tag=" + retailertag;
            chkflag = 1;
        }
        if (devicetag != "")
        {
            $dataparam = $dataparam + "&dev_tag=" + devicetag;
            chkflag = 1;
        }
        if (messagetag != "")
        {
            $dataparam = $dataparam + "&msg_tag=" + messagetag;
            chkflag = 1;
        }
        if (pagetag != "")
        {
            $dataparam = $dataparam + "&page_tag=" + pagetag;
            chkflag = 1;
        }
        if (typetag != "")
        {
            $dataparam = $dataparam + "&type_tag=" + typetag;
            chkflag = 1;
        }
        if ($dataparam)
        {
            $("#loaderimg").show();
            $.ajax({
                type: "POST",
                url: "citisearch",
                data: "ajaxrqt=1" + $dataparam,
                success: function(data)
                {
                    if (data)
                    {
                        var output = data.split("||");
                        $("#partner_ul").html("");
                        $("#partner_ul").html(output[0]);
                        $("#busidev_ul").html("");
                        $("#busidev_ul").html(output[1]);
                        $("#usrstd_ul").html("");
                        $("#usrstd_ul").html(output[2]);
                        $("#presentation_ul").html("");
                        $("#presentation_ul").html(output[3]);
                        $("#loaderimg").hide();
                    }
                    $("#loaderimg").hide();
                }
            });
        }
        if (chkflag == 0)
        {
            $("#partner_ul").html("");
            $("#partner_ul").html("<li>No album found.</li>");
            $("#busidev_ul").html("");
            $("#busidev_ul").html("<li>No album found.</li>");
            $("#usrstd_ul").html("");
            $("#usrstd_ul").html("<li>No album found.</li>");
            $("#presentation_ul").html("");
            $("#presentation_ul").html("<li>No album found.</li>");
            $("#loaderimg").hide();
        }
    }
</script>
<style>
    .filter-header {
        max-width:300px;
        min-width:240px;
        height:30px;
        text-align: center;
        font-size: 20px;
        font-weight: bold;
        background-color: #6FA2E7;
        color: #ffffff;
        padding-top: 20px;
        margin-bottom: 25px;
    }
    #filter-body { 
        float:left;
    }
    .filter-results {
        float:left;
        width:600px;
        padding-left: 100px;
    }

    #partners{ 
        float:left;
    }
    #user-studies{
        float:right;

    }
    #business-development{
        float:left;
    }
    #presentations{
        float:right;
    }
    .filter-results-left{
        width:300px;
        float: left;
    }
    .filter-results-right{
        width:300px;
        float: right;
    }
    .main-body{ padding-top: 20px;}
    .box { 
        border-width: 2px;
        border-style: solid;
        border-color: #5383BC;
        box-shadow: 1px 1px 1px #888888;
        margin-bottom: 25px;
    }
    .loaderimg {
        border-radius: 15px;
        display: block;
        height: 20%;
        left: 40%;
        opacity: 0.8;
        position: fixed;
        text-align: center;
        top: 40%;
        vertical-align: middle;
        width: 20%;
        z-index: 9999;
    }
    #loaderimg img {
        background: none repeat scroll 0 0 #fff;
        border: 4px solid #5383bc;
        border-radius: 20px;
        padding: 30px;
    }
    .filter-results {width: 650px;}
</style>
  <form action="" method="POST">
    <div class="search-block clearfix">
        <div class="pull-left">
            <ul class="inline list-actions">
                <li>
                    <a id="add_main_folder_button" href="/index.php/admin/albums/new" style="color:#333333;">
                        <i class="icon-plus-sign"></i>
                        Create an album
                    </a>
                </li>
                </u>
        </div>
        <div class="pull-right">
            <div class="custom-select">
                From &nbsp; &nbsp;<input id="txtfrmdate" name="txtfrmdate" type="text" name="startdt">&nbsp;&nbsp; (clear)&nbsp;&nbsp; 
                To &nbsp; &nbsp;<input id="txttodate" name="txttodate" type="text" name="enddt">&nbsp;&nbsp; (clear) &nbsp;&nbsp; 
                <input type="submit" name="show" value="show"/>
            </div>
        </div>
    </div>	
    <div class="main-body">
        <div id="filter-body" class="box">
            <div class="filter-header">Filter Results</div>
            <ul style="list-style-type:none;">
                <?php
                echo '<li>' . 'Album Tag';
                $i = 0;
                foreach ($album_tag as $alb_tag):
                    if ($alb_tag) {
                        echo '<ul style="list-style-type:none;">';
                        echo '<li><input id="chkalb' . $i . '" type="checkbox" onclick="albumCheck();" value="' . $alb_tag . '"/>&nbsp;';
                        echo $alb_tag;
                        echo '</li>';
                        echo '</ul>';
                        $i++;
                    }
                endforeach;
                echo '</li>';
                echo '<li>' . 'Retailer Tag';
                $i = 0;
                foreach ($retailer_tag as $ret_tag):
                    if ($ret_tag) {
                        echo '<ul style="list-style-type:none;">';
                        echo '<li><input id="chkrel' . $i . '" type="checkbox" onclick="albumCheck();" value="' . $ret_tag . '"/>&nbsp;';
                        echo $ret_tag;
                        echo '</li>';
                        echo '</ul>';
                        $i++;
                    }
                endforeach;
                echo '</li>';
                echo '<li>' . 'Device Tag';
                $i = 0;
                foreach ($device_tag as $dvc_tag):
                    if ($dvc_tag) {
                        echo '<ul style="list-style-type:none;">';
                        echo '<li><input id="chkdev' . $i . '" type="checkbox" onclick="albumCheck();" value="' . $dvc_tag . '"/>&nbsp;';
                        echo $dvc_tag;
                        echo '</li>';
                        echo '</ul>';
                        $i++;
                    }
                endforeach;
                echo '</li>';
                echo '<li>' . 'Message Offer';
                $i = 0;
                foreach ($message_offer as $msg_offer):
                    if ($msg_offer) {
                        echo '<ul style="list-style-type:none;">';
                        echo '<li><input id="chkmsg' . $i . '" type="checkbox" onclick="albumCheck();" value="' . $msg_offer . '"/>&nbsp;';
                        echo $msg_offer;
                        echo '</li>';
                        echo '</ul>';
                        $i++;
                    }
                endforeach;
                echo '</li>';
                echo '<li>' . 'Page Tag';
                $i = 0;
                foreach ($page_tag as $pg_tag):
                    if ($pg_tag) {
                        echo '<ul style="list-style-type:none;">';
                        echo '<li><input id="chkpage' . $i . '" type="checkbox" onclick="albumCheck();" value="' . $pg_tag . '"/>&nbsp;';
                        echo $pg_tag;
                        echo '</li>';
                        echo '</ul>';
                        $i++;
                    }
                endforeach;
                echo '</li>';
                echo '<li>' . 'Message Type';
                $i = 0;
                foreach ($messagetype as $msgtype):
                    if ($msgtype) {
                        echo '<ul style="list-style-type:none;">';
                        echo '<li><input id="chkmsgtype' . $i . '" type="checkbox" onclick="albumCheck();" value="' . $msgtype . '"/>&nbsp;';
                        echo $msgtype;
                        echo '</li>';
                        echo '</ul>';
                        $i++;
                    }
                endforeach;
                echo '</li>';
                ?>
            </ul>
        </div>
        <div class="filter-results">
            <div class="filter-results-left">
                <div id="partners" class="box">
                    <div class="filter-header">Existing Partners</div>
                    <ul id="partner_ul">
                    </ul>
                </div>
                <div id="business-development" class="box">
                    <div class="filter-header">Business Development</div>
                    <ul id="busidev_ul">
                    </ul>
                </div>
            </div>
            <div class="filter-results-right">
                <div id="user-studies" class="box">
                    <div class="filter-header">User Studies</div>
                    <ul id="usrstd_ul">
                    </ul>
                </div>
                <div id="presentations" class="box">
                    <div class="filter-header">Presentation</div>
                    <ul id="presentation_ul">
                    </ul>
                </div>
            </div>
        </div>
        <div id="loaderimg" class="loaderimg" style="display:none;">
            <img src="loader.gif" alt="Loading.."/>
        </div>
    </div>
</form>