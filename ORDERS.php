<?php
//check if user has already auth
session_start();
if (!isset($_SESSION['id'])){
    /*echo <<<_END
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
          

_END;*/
    header("Location: AUTH.php");
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

    <title>Мои заказы</title>

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

    <style>
        @-moz-document url-prefix() {
            fieldset { display: table-cell; }
        }
    </style>
</head>
_END;
/*
 * get current name of user
 */
session_start();
$name = $_SESSION['name'];

echo <<<_END
<body>

<style>
    th, td {
        border-right: 1px solid #ddd;
    }
</style>

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
/*
 * if button 'exit' clicked
 */
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
                    <h1 class="page-header"> Мои заказы </h1>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-inverse">
                    <thead style="background-color: #cbd3f5;">
                    <tr>
                        <th>#</th>
                        <th>URL лендинга</th>
                        <th>ссылка для скачивания</th>
                        <th>код пикселя VK</th>
                        <th>код пикселя FB</th>
                        <th>код пикселя Yandex Metrika</th>
                        <th>дата оформления</th>
                        <th>стоимость</th>
                    </tr>
                    </thead>
_END;

echo <<<_END
                    <tbody>
_END;
/*
 * get orders from table 'orders'
 * if status is 'paid'
 */
require_once 'authorisation/login.php';
include_once 'authorisation/DataBase.php';
$bd = new DataBase($hn, $un, $pw, $db);
//get all orders of current user
$result = $bd->out_orders();
$rows = $result->num_rows;
$num = 1;
for ($j = 0 ; $j < $rows ; ++$j)
{
    $result->data_seek($j);
    $row = $result->fetch_array(MYSQLI_NUM);
    if ($row[11]==='paid') {
        echo <<<_END
                    <tr>
                        <th scope="row">$num</th>
                        <td>$row[2]</td>
                        <td>$row[10]</td>
                        <td>$row[3]</td>
                        <td>$row[4]</td>
                        <td>$row[5]</td>
                        <td>$row[6]</td>
                        <td>$row[7]</td>
                    </tr>
_END;
        $num++;
    }

}
$result->close();


echo <<<_END
                    
                    </tbody>
                </table>
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