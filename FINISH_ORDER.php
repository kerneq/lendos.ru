<?php
session_start();
if (!isset($_SESSION['id'])){
    echo 'Вы не авторизированный пользователь, пройдите по одной из сылок';
    echo <<<_END
<form>
    <pre>
<a href="https://oauth.vk.com/authorize?client_id=6156122&display=page&redirect_uri=http://165.227.116.214/TEMPLATE.php&response_type=code" name="vk">Войти через ВК</a>

<a href="https://www.facebook.com/v2.9/dialog/oauth?client_id=261920790992777&redirect_uri=http://165.227.116.214/TEMPLATE.php&response_type=code&scope=public_profile,email" name="fb">Войти через FB</a>
    </pre>
</form>
_END;
    die();

}
echo <<<_END
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Ваши контактные данные и оплата заказа</title>

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
_END;
session_start();
$name = $_SESSION['name'];
echo <<<_END
<body>

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="navbar-header">
            <a class="navbar-brand" href="TEMPLATE.php">Lendos.ru</a>
        </div>

        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>

        <!-- Top Navigation: Right Menu -->
        <ul class="nav navbar-right navbar-top-links">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i> $name <b class="caret"></b>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="PROFILE.php"><i class="fa fa-user fa-fw"></i> Профиль</a>
                    <li class="divider"></li>
                    <li><form action="TEMPLATE.php" method="POST" id='form2'>
                            <input type="submit" value="Выйти" name ="exit" />
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
_END;

if (isset($_POST['exit'])){
    $bd->destroy_session_and_data();

    header("Location: index.php");
}

echo <<<_END
        <!-- Sidebar -->
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">

                <ul class="nav" id="side-menu">
                    <li>
                        <a href="TEMPLATE.php" class="active"><i class="fa fa-dashboard fa-fw"></i> Новый заказ</a>
                    </li>
                    <li>
                        <a href="ORDERS.php" class="active"><i class="fa fa-dashboard fa-fw"></i> Мои заказы</a>
                    </li>
                    <li>
                        <a href="PROFILE.php" class="active"><i class="fa fa-dashboard fa-fw"></i> Профиль</a>
                    </li>
                    <li>
                        <a href="SUPPORT.php" class="active"><i class="fa fa-dashboard fa-fw"></i> Связаться с нами</a>
                    </li>
                </ul>

            </div>
        </div>
    </nav>
_END;

echo <<<_END
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Ваши контакты и оплата заказа</h1>
                </div>
            </div>

            <!-- ... Your content goes here ... -->

            <form role="form" style="margin-bottom: 50px;" method="post" action="FINISH_ORDER.php">
                <!-- e-mail -->
                <div class="form-group">
                    <label for="exampleInputEmail1">Ваш e-mail</label>
                    <input type="email" class="form-control"
                           id="exampleInputEmail1"
                           placeholder="iam@yandex.ru"
                            style="width: 40%"
                            name="email">
                </div>
                <!-- phone -->
                <div class="form-group">
                    <label for="exampleInputEmail1">Ваш телефон (по желанию)</label>
                    <input type="text" class="form-control"
                           id="exampleInputPhone"
                           placeholder="89092814332"
                           style="width: 40%"
                           name="phone">
                </div>

                <p style="color: green">* через два часа ваш заказ будет готов и мы свяжемся с вами</p>
                <b>К оплате: 600 рублей</b>
                </br></br>

                <button type="submit" class="btn btn-default" name="pay">Оплатить</button>
            </form>


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