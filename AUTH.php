<?php
/**
 * Created by PhpStorm.
 * User: maha
 * Date: 05.09.17
 * Time: 12:37
 */
echo <<<_END
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Авторизация</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="css/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/startmin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="css/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
_END;

echo <<<_END
<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="navbar-header">
            <a class="navbar-brand" href="TEMPLATE.html">Lendos.ru</a>
        </div>

        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>

        <!-- Sidebar -->
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">

                <ul class="nav" id="side-menu">
                    <li>
                        <a href="TEMPLATE.html" class="active"><i class="fa fa-dashboard fa-fw"></i> Новый заказ</a>
                    </li>
                    <li>
                        <a href="ORDERS.html" class="active"><i class="fa fa-dashboard fa-fw"></i> Мои заказы</a>
                    </li>
                    <li>
                        <a href="LENDINGS.php" class="active"><i class="fa fa-dashboard fa-fw"></i> Каталог лендингов</a>
                    </li>
                    <li>
                        <a href="PROFILE.html" class="active"><i class="fa fa-dashboard fa-fw"></i> Профиль</a>
                    </li>
                    <li>
                        <a href="SUPPORT.html" class="active"><i class="fa fa-dashboard fa-fw"></i> Связаться с нами</a>
                    </li>
                </ul>
_END;

echo <<<_END
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Вход в систему</h1>
                </div>
            </div>

            <!-- ... Your content goes here ... -->
            <div class="alert alert-danger col-lg-5" role="alert">
                Пожалуйста, авторизуйтесь в системе через одну из предоставленных ниже социальных сетей
                <p style="margin-top: 15px;" align="center">
                    <a href="https://oauth.vk.com/authorize?client_id=6163804&display=page&redirect_uri=https://lendos.me/TEMPLATE.php&response_type=code"><img src="img/vk2.png"  width="40"/></a>
                    <a href="https://www.facebook.com/v2.9/dialog/oauth?client_id=261920790992777&redirect_uri=https://lendos.me/TEMPLATE.php&response_type=code&scope=public_profile,email" style="margin-left: 7px;"><img src="img/fb.png"  width="40"/></a>
                </p>
            </div>


        </div>
    </div>

</div>

<!-- jQuery -->
<script src="js/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="js/metisMenu.min.js"></script>

<!-- Custom Theme JavaScript -->
<script src="js/startmin.js"></script>

</body>
</html>
_END;
?>