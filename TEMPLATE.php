<?php
/*
 * check for authorisation
 */
include_once 'authorisation/DataBase.php';
require_once 'authorisation/login.php';
$bd =new DataBase($hn, $un, $pw, $db);
//code - come from vk or fb
if (!$_GET['code']) {
    //check if user has already auth
    $bd->start_session();
    if (!isset($_SESSION['id'])){
        echo <<<_END
                <div class="col-lg-6">
                    <div class="alert alert-info">
        Чтобы войти в систему Вам необходимо авторизоваться через одну из следующих социальных
сетей
        </br>
                        <div align="center">
                            <a href="https://oauth.vk.com/authorize?client_id=6163804&display=page&redirect_uri=https://lendos.me/TEMPLATE.php&response_type=code" style="margin-right: 5px" name="vk"><img src="img/vk2.png" width="41"/></a>
                            <a href="https://www.facebook.com/v2.9/dialog/oauth?client_id=261920790992777&redirect_uri=https://lendos.me/TEMPLATE.php&response_type=code&scope=public_profile,email" style="margin-left: 5px;" name="fb"><img src="img/fb.png" width="41"/></a>
                        </div>
                    </div>
                </div>
          

_END;
        die();

    }
} else {
/*
 * authairisation via vk and fb
 * out - $data
 */
    $token = json_decode(file_get_contents('https://oauth.vk.com/access_token?client_id=6163804&redirect_uri=https://lendos.me/TEMPLATE.php&client_secret=yucaFtiTYOOj9hBsrHrI&code=' . $_GET['code']), true);

    if (!$token) {
        $token = json_decode(file_get_contents('https://graph.facebook.com/v2.9/oauth/access_token?client_id=261920790992777&redirect_uri=https://lendos.me/TEMPLATE.php&client_secret=4f16c767c37c3383d7d1861deb7ff007&code=' . $_GET['code']), true);
        if (!$token) {
            exit("error token");
        }
        $data = json_decode(file_get_contents('https://graph.facebook.com/v2.9/me?client_id=261920790992777&redirect_uri=https://lendos.me/acount.php&client_secret=4f16c767c37c3383d7d1861deb7ff007&code=' . $_GET['code'] . '&access_token=' . $token['access_token'] . '&fields=id,name,email'), true);

        if (!$data) {
            exit('error data');
        }


    } else {
        $data = json_decode(file_get_contents('https://api.vk.com/method/users.get?user_id=' . $token['user_id'] . '&access_token=' . $token['access_token'] . '&fields=uid,first_name,last_name,contacts,email'), true);

        if (!$data) {
            exit('error data');
        }

        $data = $data['response'][0];
    }
    //add user to bd 'users'
    $bd->user_add($data);

}

echo <<<_END
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Оформление заказа</title>

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

/*
 * get current name of user
 */
$bd->start_session();
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
                    <i class="fa fa-user fa-fw"></i>$name<b class="caret"></b>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="PROFILE.php"><i class="fa fa-user fa-fw"></i> Профиль</a>
                    <li class="divider"></li>
                    <li>
                    <form action="TEMPLATE.php" method="POST" id='form2'>
                    <input type="submit" value="Выйти" name ="exit" />
                    </form>
                    </li>
                </ul>
            </li>
        </ul>
_END;
/*
 * if button 'exit' clicked
 */
if (isset($_POST['exit'])){
    $bd->destroy_session_and_data();

    header("Location: index.php");
}
/*
 * if button 'end' clicked
 * page content change to 'FINISH_ORDER.php'
 */
if (isset($_POST['end']))
header("Location: FINISH_ORDER.php");
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
                        <a href="LENDINGS.php" class="active"><i class="fa fa-dashboard fa-fw"></i> Каталог лендингов</a>
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
                    <h1 class="page-header">Оформление заказа</h1>
                </div>
            </div>

            <!-- ... Your content goes here ... -->

            <form role="form" style="margin-bottom: 50px;" method="POST" action="TEMPLATE.php">
                <div class="form-group">
                    <label for="exampleInputEmail1">Адрес лендинга для копирования</label>
                    <input required="required"
                           type="text" class="form-control"
                           id="exampleInputEmail1"
                           placeholder="http://site.ru"
                            style="width: 40%"
                            name="url">
                </div>

                <p style="margin-top: 20px;">
                    <a class="btn btn-primary" data-toggle="collapse"
                       href="#multiCollapseExample1" aria-expanded="false"
                       aria-controls="multiCollapseExample1">Добавить код ретаргетинга (пиксель)</a>
                </p>
                <div class="row">
                    <div class="col">
                        <div class="collapse multi-collapse" id="multiCollapseExample1">
                            <div class="card card-body">
                                <!-- vk -->
                                <div class="col-auto" style="margin-top: 10px;">
                                    <label class="sr-only">vk-pixel</label>
                                    <div class="input-group col-lg-4 col-lg-offset-1" >
                                        <div class="input-group-addon"><img src="img/vk2.png" width="20" /></div>
                                        <input id="pixel-vk" type="text" class="form-control" placeholder="VK-RTRG-102030-aBcDe" name="vk_pixel">
                                    </div>
                                </div>
                                <!-- fb -->
                                <div class="col-auto" style="margin-top: 10px;">
                                    <label class="sr-only">fb-pixel</label>
                                    <div class="input-group col-lg-4 col-lg-offset-1">
                                        <div class="input-group-addon"><img src="img/fb.png" width="20" /></div>
                                        <input id="pixel-fb" type="text" class="form-control" placeholder="236621784242525" name="fb_pixel">
                                    </div>
                                </div>
                                <!-- yandex metrika -->
                                <div class="col-auto" style="margin-top: 10px; margin-bottom: 20px;">
                                    <label class="sr-only">metrika-pixel</label>
                                    <div class="input-group col-lg-4 col-lg-offset-1">
                                        <div class="input-group-addon"><img src="img/yandex.png" width="21" /></div>
                                        <input id="pixel-metrika" type="text" class="form-control" placeholder="23662178" name="metka_pixel">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- additional modules -->
                <p style="margin-top: 10px;">
                    <a class="btn btn-primary" data-toggle="collapse"
                       href="#multiCollapseExample2" aria-expanded="false"
                       aria-controls="multiCollapseExample2">Добавить дополнительный модуль, плагин</a>
                </p>
                <div class="row">
                    <div class="col">
                        <div class="collapse multi-collapse" id="multiCollapseExample2">
                            <div class="card card-body">
                                <div class="col-sm-10 col-lg-offset-1">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input id="vk-fast" class="form-check-input" type="checkbox" name="module1"> Быстрые сообщения в группу ВК
                                        </label>
                                        </br>
                                        <label class="form-check-label">
                                            <input id="different" class="form-check-input" type="checkbox" name="modules2"> Другой (напишите об нем в форме ниже)
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- text block -->
                <div class="form-group col-lg-6" style="margin-top: 20px; position: relative; right: 15px;">
                    <label for="exampleFormControlTextarea1">Ваши индивидуальные требования, тексты</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="modules"></textarea>
                </div>

                <div style="clear: both"></div>

                <!-- add promo code 
                <p>
                    <a class="btn btn-success" data-toggle="collapse"
                       href="#promoCode" aria-expanded="false"
                       aria-controls="promoCode">Промокод (если есть)</a>
                </p>
                <div class="row">
                    <div class="col">
                        <div class="collapse multi-collapse" id="promoCode">
                            <div class="card card-body">
                                <div class="col-sm-2">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input id="promo" type="text" class="form-control" placeholder="ваш промокод">
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <button type="button" class="btn btn-primary">проверить</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
-->
<input id="hidden-price" type="hidden" name="price" value="350">
                <!-- total costs -->
                <div id="totalCosts">
                    <p id="costs" style="color: green; margin-top: 10px;">Полная стоимость: 350 рублей</p>
                </div>

                <button type="submit" class="btn btn-default" style="margin-top: 10px;" name="end">Закончить оформление</button>
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

<script>
    var siteCosts = 350;
    var pixelCosts = 100;
    var moduleCosts = 150;

    var checkBoxesSelected = 0;

    // init
    $('#vk-fast').attr('checked', false);
    $('#different').attr('checked', false);

    // check input text with pixels ID
    $( "#pixel-vk, #pixel-fb, #pixel-metrika" ).change(function() {
        updateTotalCosts();
    });

    // validation checkboxes
    $("#vk-fast, #different").change(
        function() {
            if ($(this).is(':checked')) {
                checkBoxesSelected++;
                updateTotalCosts();
            } else {
                checkBoxesSelected--;
                updateTotalCosts();
            }
        });

    // recount total price
    function updateTotalCosts() {
        var total = siteCosts;

        if ($("#pixel-vk").val() !== ''
            || $("#pixel-fb").val() !== ''
            || $("#pixel-metrika").val() !== '') {
            total += pixelCosts;
        }

        total += moduleCosts * checkBoxesSelected;
         $("#costs").text('Полная стоимость: ' + total + ' рублей');
         $("#hidden-price").val(total);
    }

</script>

</body>
</html>
_END;
/*
 * if button 'end' clicked
 * the form is ready to be send
 */
if (isset($_POST['end'])){
    date_default_timezone_set('Europe/Moscow');
    //date format 03.12.01
    $date_today = date("m.d.y");
    //time format 17:16:17
    $today[1] = date("H:i:s");
    $date = $today[1].' / '.$date_today;
    //adding data of order of current user to table 'oreders'
    $bd->add_order($_POST['url'], $_POST['vk_pixel'],
        $_POST['fb_pixel'],$_POST['metka_pixel'],
        $date, $_POST['price'], $_POST['modules'],
        $_POST['module1'].$_POST['module2']);
}

?>