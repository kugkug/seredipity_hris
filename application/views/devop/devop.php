<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title> HJ Utilities | Developer </title>

    <link rel="stylesheet" type="text/css" href="lib/styles/mainStyle.css">
    <script src="lib/scripts/jquery/js/jquery-1.10.2.js"></script>
    <link rel="stylesheet" type="text/css"  href = "lib/scripts/libs/bootstrap-3.3.7/css/bootstrap.min.css">
    <script src="lib/scripts/libs/bootstrap-3.3.7/js/bootstrap.min.js"></script>

</head>

<body>

    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-fixed-top navbar-default" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand navbar-primary" href="../welcome">HJ UTILITIES | Developer</a>
            </div>
            <!-- /.navbar-header -->

           
        </nav>

            <!-- /.row -->
        <div class="container-fluid" style="margin-top: 50px;">
            <div class="row">
                <div class="col-lg-12"> &nbsp; </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <form name="frmAddMenu" id="frmAddMenu">
                        <div class="form-group">
                            <label for="txtMenuTit">Menu Title</label>
                            <input type="text" name="txtMenuTit" id="txtMenuTit" class="form-control input-sm">
                        </div>
                        <button id="btnAddMenu" name="btnAddMenu" class="btn btn-primary">
                            <i class="glyphicon glyphicon-plus" style="font-size: 1.7vh;"></i> Add Module
                        </button>                            
                    </form>

                    <hr> </hr>

                    <form name="frmAddMod" id="frmAddMod">
                        <div class="form-group">
                            <label for="txtModTitle">Sub Module Title</label>
                            <input type="text" name="txtModTitle" id="txtModTitle" class="form-control input-sm">
                        </div>
                        <!-- <div class="form-group">
                            <label for="txtModDir">Sub Module Filename</label>
                            <input type="text" name="txtModDir" id="txtModDir" class="form-control input-sm">
                        </div> -->
                        <div class="form-group">
                            <label for="selModCat">Sub Module Category</label>
                            <select id="selModCat" name="selModCat" class="form-control input-sm"></select>
                            <!-- <input type="text" name="txtModCat" id="txtModCat" class="form-control input-sm"> -->
                        </div>
                        <!-- <div class="form-group">
                            <label for="txtModDesc">Sub Module Description</label>
                            <textarea name="txtModDesc" id="txtModDesc" class="form-control input-sm" rows="7" style="resize: none;"></textarea>
                        </div> -->
                        <button id="btnAddMod" name="btnAddMod" class="btn btn-primary">
                            <i class="glyphicon glyphicon-plus" style="font-size: 1.7vh;"></i> Add Module
                        </button>
                    </form>
                    &nbsp;
                </div>
                
                <div class="col-lg-6" id="divResult"></div>
            </div>
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->

</body>

</html>

<script type="text/javascript">
    $(document).ready(function(e)
    {
        _getData();

        $("#frmAddMenu").on("submit", function(e)
        {
            e.preventDefault();
            $.ajax(
            {
                type    : "POST",
                url     : "devop-add-menu",
                data    : $("#frmAddMenu").serialize(),
                success : function(response) {
                    _getData();
                },
                error: function() {
                    
                }
            });
        });

        $("#frmAddMod").on("submit", function(e)
        {
            e.preventDefault();
            $.ajax(
            {
                type    : "POST",
                url     : "devop-add-modules",
                data    : $("#frmAddMod").serialize(),
                success : function(response) {
                    console.log(response);
                    // _getData();
                },
                error: function() {
                    
                }
            });
        });
    });

    function _getData()
    {
        $.ajax(
        {
            url     : "devop-get-menu",
            type    : "POST",
            dataType: 'json',
            data    : $("#frmAddMenu").serialize(),
            success : function(response)
            {
                console.log(response);
                $.each(response, function(key, data)
                {
                    if (key == "inner") {
                        $.each(data, function(elemId, value) {
                            $("#" + elemId).html(value);
                        });
                    }
                    else {
                        $.each(data, function(elemId, value) {
                            $("#" + elemId).html(value);
                        });
                    }
                });
            },
            error: function(xhr) 
            {
                console.log(xhr.responseText);
            }
        });
    };


</script>
