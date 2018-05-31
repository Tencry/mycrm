<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <title>Е-центр</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  
  <!-- Bootstrap -->
  <link href="assets/bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
  <style type="text/css">
    body {
      padding-top: 60px;
      padding-left: 20px;
      padding-right: 20px;
      /*background: url("assets/bootstrap/img/header-big.png") repeat;*/
    }
  </style>
  <style type="text/css">
    label.error { float: none; color: red; padding-left: .5em; vertical-align: top; }
    em { font-weight: bold; padding-right: 1em; vertical-align: top; }
  </style>
  <link href="assets/bootstrap/css/bootstrap-responsive.css" rel="stylesheet" media="screen">
  <link href="assets/bootstrap/css/my.css" rel="stylesheet" media="screen">

  <!-- JQuery -->
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
  <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
  <script src="assets/plusstrap/js/jquery.form.js"></script>
  <script type="text/javascript" src="assets/jquery.validate.js"></script>
  <script type="text/javascript" src="assets/jquery.livequery.js"></script>
  <script type="text/javascript" src="assets/jquery.listen.js"></script>
  <script src="assets/jquery.ui.datepicker-ru.js"></script>
  <script src="assets/mycrm.js"></script>

  <!-- arcticModal -->
  <script src="assets/arcticmodal/jquery.arcticmodal.js"></script>
  <link rel="stylesheet" href="assets/arcticmodal/jquery.arcticmodal-0.2.css">
</head>
<body>

	<div class="row-fluid">
		<ul class="nav nav-pills">
		<li><a href="/groups.php">Группы</a></li>
		<li><a href="/students.php">Студенты</a></li>
		<li><a href="/seminars.php">Семинары</a></li>
		<li><a href="/reports.php">Отчеты</a></li>
		<li><a href="/managers.php">Менеджеры</a></li>
		<li><a href="/">О системе...</a></li>
		<li><a href="/logout.php">Выход</a></li>
		</ul>
	</div>

	<div class="row-fluid">
		<div class="span12">
			<?=$content?>
		</div>
	</div>

	<hr>

    <footer>
      <div class="hero-unit">
	      <p>&copy; АО «Центр подготовки, переподготовки и повышения квалификации специалистов органов финансовой системы»</p>
      </div>
    </footer>

	<script src="assets/bootstrap/js/bootstrap.min.js"></script>

</body>
</html>
