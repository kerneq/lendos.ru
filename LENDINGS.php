<?php
/**
 * Created by PhpStorm.
 * User: maha
 * Date: 05.09.17
 * Time: 12:13
 */
echo <<<_END
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Каталог лендингов</title>

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
/*
 * get current name of user
 */
session_start();
$name = $_SESSION['name'];

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

        <!-- Top Navigation: Right Menu -->
        <ul class="nav navbar-right navbar-top-links">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i> $name <b class="caret"></b>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="PROFILE.html"><i class="fa fa-user fa-fw"></i> Профиль</a>
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
                    <h1 class="page-header">Каталог лендингов</h1>
                </div>
            </div>
_END;

    echo <<<_END
            <!-- ... Your content goes here ... -->
            <div class="row" style="border-bottom: 1px solid #e4dddd; margin-bottom: 50px;">
                <!-- image -->
                <div class="col-lg-3">
                    <img src="img/vk2.png"  width="100%"/>
                </div>

                <!-- info -->
                <div class="col-lg-8" style="margin-bottom: 15px;">
                    <!-- lending name -->
                    <p style="font-size: 30px;">Lending name</p>
                    <p style="font-size: 16px;">Тематика: бизнес</p>
                    <p style="font-size: 16px;">Мобильная версия: есть</p>
                    <p style="font-size: 16px;">Стоимость лендинга + любые доработки: 3500 рублей</p>
                    <p style="font-size: 16px;">Годовая поддержка: 500 рублей</p>
                    <button type="button" class="btn btn-primary">Заказать</button>
                    <button type="button" class="btn btn-success" style="margin-left: 15px;">ДЕМО версия</button>
                </div>
            </div>
_END;

    echo <<<_END
            <div class="row" style="border-bottom: 1px solid #e4dddd; margin-bottom: 50px;">
                <!-- image -->
                <div class="col-lg-3">
                    <img src="img/vk2.png"  width="100%"/>
                </div>

                <!-- info -->
                <div class="col-lg-8" style="margin-bottom: 15px;">
                    <!-- lending name -->
                    <p style="font-size: 30px;">Lending name</p>
                    <p style="font-size: 16px;">Тематика: бизнес</p>
                    <p style="font-size: 16px;">Мобильная версия: есть</p>
                    <p style="font-size: 16px;">Стоимость лендинга + любые доработки: 3500 рублей</p>
                    <p style="font-size: 16px;">Годовая поддержка: 500 рублей</p>
                    <button type="button" class="btn btn-primary">Заказать</button>
                    <button type="button" class="btn btn-success" style="margin-left: 15px;">ДЕМО версия</button>
                </div>
            </div>
_END;

    echo <<<_END
            <div class="row" style="border-bottom: 1px solid #e4dddd; margin-bottom: 50px;">
                <!-- image -->
                <div class="col-lg-3">
                    <img src="img/vk2.png"  width="100%"/>
                </div>

                <!-- info -->
                <div class="col-lg-8" style="margin-bottom: 15px;">
                    <!-- lending name -->
                    <p style="font-size: 30px;">Lending name</p>
                    <p style="font-size: 16px;">Тематика: бизнес</p>
                    <p style="font-size: 16px;">Мобильная версия: есть</p>
                    <p style="font-size: 16px;">Стоимость лендинга + любые доработки: 3500 рублей</p>
                    <p style="font-size: 16px;">Годовая поддержка: 500 рублей</p>
                    <button type="button" class="btn btn-primary">Заказать</button>
                    <button type="button" class="btn btn-success" style="margin-left: 15px;">ДЕМО версия</button>
                </div>
            </div>
_END;

    echo <<<_END
            <div class="row" style="border-bottom: 1px solid #e4dddd; margin-bottom: 50px;">
                <!-- image -->
                <div class="col-lg-3">
                    <img src="img/vk2.png"  width="100%"/>
                </div>

                <!-- info -->
                <div class="col-lg-8" style="margin-bottom: 15px;">
                    <!-- lending name -->
                    <p style="font-size: 30px;">Lending name</p>
                    <p style="font-size: 16px;">Тематика: бизнес</p>
                    <p style="font-size: 16px;">Мобильная версия: есть</p>
                    <p style="font-size: 16px;">Стоимость лендинга + любые доработки: 3500 рублей</p>
                    <p style="font-size: 16px;">Годовая поддержка: 500 рублей</p>
                    <button type="button" class="btn btn-primary">Заказать</button>
                    <button type="button" class="btn btn-success" style="margin-left: 15px;">ДЕМО версия</button>
                </div>
            </div>
_END;

    echo <<<_END
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