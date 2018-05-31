<?
header('Content-Type: text/html; charset=utf-8');
include 'startup.php';

$model = $_GET['model'];
$fieldname = $_GET['fieldname'];
$index = $_GET['index'];

/**
 * Routings and execution
 */
$page = new Field($fieldname, 'reference');
$page->template = 'View/form_select_many';
$page->set_model('Model_'.$model);
$page->show_fields(array('name'));
$page->data['model'] = $model;
$page->get_data();
$page->show();

