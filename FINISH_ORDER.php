<?php
session_start();
if (!isset($_SESSION['id'])){
    echo <<<_END
                <div class="col-lg-6">
                    <div class="alert alert-info">
        Чтобы войти в систему Вам необходимо авторизоваться через одну из следующих социальных
сетей
        </br>
                        <div align="center">
                            <a href="https://oauth.vk.com/authorize?client_id=6156122&display=page&redirect_uri=https://lendos.me/TEMPLATE.php&response_type=code" style="margin-right: 5px" name="vk"><img src="img/vk2.png" width="41"/></a>
                            <a href="https://www.facebook.com/v2.9/dialog/oauth?client_id=261920790992777&redirect_uri=https://lendos.me/TEMPLATE.php&response_type=code&scope=public_profile,email" style="margin-left: 5px;" name="fb"><img src="img/fb.png" width="41"/></a>
                        </div>
                    </div>
                </div>
          

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

include_once 'authorisation/login.php';
include_once 'authorisation/DataBase.php';
$bd = new DataBase($hn,$un,$pw,$db);
$result = $bd->take_inf();
$result->data_seek(0);
$row = $result->fetch_array(MYSQLI_NUM);
$user_email = $row[3];
$user_phone = $row[4];
$result = $bd->out_orders();
$rows = $result->num_rows-1;
$result->data_seek($rows);
$row = $result->fetch_array(MYSQLI_NUM);

if (isset($_POST['pay'])){
    $bd->update(NULL, $_POST['email'], NULL, NULL, NULL);
    $mrh_login = "lendosme";
    $mrh_pass1 = "a1EH0K5FXTUfOfK5asP3";

// номер заказа
// number of order
    $inv_id = $row[0];

// описание заказа
// order description
    $inv_desc = "Вы успешно оплатили свой заказ, во вкладке заказ вы его увидите";

// сумма заказа
// sum of order
    $out_summ = $row[7];

// тип товара
// code of goods
    $shp_item = 1;

// предлагаемая валюта платежа
// default payment e-currency
    $in_curr = "";

// язык
// language
    $culture = "ru";

// кодировка
// encoding
    $encoding = "utf-8";

// формирование подписи
// generate signature
    $crc  = md5("$mrh_login:$out_summ:$inv_id:$mrh_pass1:Shp_item=$shp_item");
    //header("Location: ../TEMPLATE.php");
    file_get_contents("https://auth.robokassa.ru/Merchant/Index.aspx?MerchantLogin=$mrh_login&OutSum=$out_summ&InvId=$inv_id&IncCurrLabel=$in_curr&Desc=$inv_desc&SignatureValue=$crc&Shp_item=$shp_item&Culture=$culture&Encoding=$encoding&IsTest=1");
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
                           placeholder="$user_email"
                            style="width: 40%"
                            name="email"
                            required="required">
                </div>
                <!-- phone -->
                <div class="form-group">
                    <label for="exampleInputEmail1">Ваш телефон (по желанию)</label>
                    <input type="text" class="form-control"
                           id="exampleInputPhone"
                           placeholder="$user_phone"
                           style="width: 40%"
                           name="phone">
                </div>

                <p style="color: green">* через два часа ваш заказ будет готов и мы свяжемся с вами</p>
                <b>К оплате: $row[7] рублей</b>
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