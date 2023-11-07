<?php session_start(); ?>
<?php require '../header.php'; ?>
<?php
$company_name = htmlspecialchars($_REQUEST['company_name']);
$date = $_REQUEST['date'];
$ir_name = htmlspecialchars($_REQUEST['ir_name']);
$aapl = $_REQUEST['aapl'];
$revenue = $_REQUEST['revenue'];
$profit = $_REQUEST['profit'];
$opo_income = $_REQUEST['opo_income'];
$assets = $_REQUEST['assets'];
$liabilities = $_REQUEST['liabilities'];
$net_assets = $_REQUEST['net_assets'];
$stock_price = $_REQUEST['stock_price'];
$dividend = $_REQUEST['dividend'];
$stock_count = $_REQUEST['stock_count'];
$sales_cash_flow = $_REQUEST['sales_cash_flow'];
$inv_cash_flow = $_REQUEST['inv_cash_flow'];
$fin_cash_flow = $_REQUEST['fin_cash_flow'];
$pdo = new PDO('mysql:host=localhost;dbname=kabu;charset=utf8', 'root');
$sql = $pdo->prepare('INSERT INTO ir_date VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
$sql->execute([
    $company_name,
    $date,
    $ir_name,
    $aapl,
    $revenue,
    $profit,
    $opo_income,
    $assets,
    $liabilities,
    $net_assets,
    $stock_price,
    $dividend,
    $stock_count,
    $sales_cash_flow,
    $inv_cash_flow,
    $fin_cash_flow
]);
$_SESSION['company'] = [
    'company_name' => $company_name,
    'date' => $date,
    'ir_name' => $ir_name,
    'aapl' => $aapl,
    'revenue' => $revenue,
    'profit' => $profit,
    'opo_income' => $opo_income,
    'assets' => $assets,
    'liabilities' => $liabilities,
    'net_assets' => $net_assets,
    'stock_price' => $stock_price,
    'dividend' => $dividend,
    'stock_count' => $stock_count,
    'sales_cash_flow' => $sales_cash_flow,
    'inv_cash_flow' => $inv_cash_flow,
    'fin_cash_flow' => $fin_cash_flow
];
if (isset($_SESSION['company'])) {
    echo '<h3>- ' . $_SESSION['company']['company_name'] . '(' . $_SESSION['company']['aapl'] . ') 会社情報 -</h3>';
    echo 'IR開示名：' . $_SESSION['company']['ir_name'] . 'の登録に成功しました。';
    echo '<br>' . $_SESSION['company']['date'] ;
    echo '<h3><a href="../process/process.php?=', $_SESSION['company']['company_name'], '">-指標計算する-</a></h3>';
    echo '<hr>';
} else {
    echo '追加に失敗しました。';
}
?>
<?php require '../footer.php'; ?>







