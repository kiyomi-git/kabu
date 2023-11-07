<?php session_start(); ?>
<?php require '../header.php'; ?>

<?php

if (isset($_SESSION['company'])) {
    $companyData = $_SESSION['company'];

    $assets = $companyData['assets'] * 1000000; // 資産
    $liabilities = $companyData['liabilities'] * 1000000; // 負債
    $opo_income = $companyData['opo_income'] * 1000000; // 経常利益
    $profit = $companyData['profit'] * 1000000; // 純利益
    $net_assets = $companyData['net_assets'] * 1000000; // 純資産
    $revenue = $companyData['revenue'] * 1000000; // 売上高
    $sales_cash_flow = $companyData['sales_cash_flow'] * 1000000; // 営業活動によるキャッシュフロー
    $inv_cash_flow = $companyData['inv_cash_flow'] * 1000000; // 投資活動によるキャッシュフロー
    $fin_cash_flow = $companyData['fin_cash_flow'] * 1000000; // 財務活動によるキャッシュフロー
    $cash_flow = $sales_cash_flow + $inv_cash_flow + $fin_cash_flow; // キャッシュフロー

    $stock_count = $companyData['stock_count'];
    $stock_price = $companyData['stock_price'];
    $dividend = $companyData['dividend'];

    $companyData['roe'] = ($profit / ($assets - $liabilities)) * 100; // ROE（自己資本利益率）'%'
    $companyData['roa'] = (($opo_income / $assets) * 100); // ROA（総資産利益率）'%'
    $companyData['eps'] = ($profit / $stock_count); // EPS（1株当たり利益）
    $companyData['per'] = ($stock_price / $companyData['eps']); // PER（株価収益率）倍
    $companyData['etr'] = (($profit / ($assets - $liabilities)) * 1000000); // 自己資本回転率
    $companyData['bps'] = ($net_assets / $stock_count); // BPS（1株当たりの純資産）
    $companyData['pbr'] = ($stock_price / $companyData['bps']); // PBR（株価純資産倍率）
    $companyData['et'] = (($assets - $liabilities) / 1000000); // 自己資本
    $companyData['er'] = (($companyData['et'] * 1000000) / ($net_assets + $liabilities) * 100); // 自己資本比率
    $companyData['etar'] = ($revenue / $assets); // 総資本回転率
    $companyData['dy'] = (($dividend / $stock_price) * 100); // 配当利回り
    $companyData['pcfr'] = ($stock_price / $companyData['eps']); // PCFR（株価キャッシュフロー倍率）
    $companyData['eps_cash_flow'] = ($cash_flow / $stock_count); // 1株当たりのキャッシュフロー
    
    $pdo = new PDO('mysql:host=localhost;dbname=kabu;charset=utf8', 'root');
    $sql = $pdo->prepare('INSERT INTO index_date VALUES (?, ?, ?, ? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,?)');
    $sql->execute([
        $companyData['company_name'], 
        $companyData['date'],
        $companyData['roe'],
        $companyData['roa'],
        $companyData['eps'],
        $companyData['per'],
        $companyData['etr'],
        $companyData['bps'],
        $companyData['pbr'],
        $companyData['et'],
        $companyData['er'],
        $companyData['etar'],
        $companyData['dy'],
        $companyData['pcfr'],
        $companyData['eps_cash_flow']
    ]);
    

    echo '<div id="process"><table>';
    echo '<tr><th><h3>-会社情報-</h3></th></tr>';
    echo '<tr><th>会社名</th><td>', $companyData['company_name'], '</td></tr>';
    echo '<tr><th>日付</th><td>', $companyData['date'], '</td></tr>';
    
    echo '<tr><th><h3>-利益関連指標-</h3></th></tr>';
    echo '<tr><th>ROE（自己資本利益率）</th><td>', number_format($companyData['roe'], 2), '％</td></tr>';
    echo '<tr><th>ROA（総資産利益率）</th><td>', number_format($companyData['roa'], 2), '％</td></tr>';
    echo '<tr><th>EPS（1株当たり利益）</th><td>', number_format($companyData['eps'], 2), '％</td></tr>';
    echo '<tr><th>PER（株価収益率）</th><td>', number_format($companyData['per'], 2), '</td></tr>';
    echo '<tr><th>自己資本回転率</th><td>', number_format($companyData['etr'], 2), '回</td></tr>';
    
    echo '<tr><th><h3>-資本構造関連指標-</h3></th></tr>';    
    echo '<tr><th>BPS（1株当たりの純資産）</th><td>', number_format($companyData['bps'], 2), '円</td></tr>';
    echo '<tr><th>PBR（株価純資産倍率）</th><td>', number_format($companyData['pbr'], 2), '</td></tr>';
    echo '<tr><th>自己資本</th><td>', number_format($companyData['et'], 2), '</td></tr>';
    echo '<tr><th>自己資本比率</th><td>', number_format($companyData['er'], 2), '％</td></tr>';
    echo '<tr><th>総資本回転率</th><td>', number_format($companyData['etar'], 2), '回</td></tr>';
        
    echo '<tr><th><h3>-配当関連指標-</h3></th></tr>';
    echo '<tr><th>配当利回り</th><td>', number_format($companyData['dy'], 2), '％</td></tr>';
    
    echo '<tr><th><h3>-キャッシュフロー関連指標-</h3></th></tr>';
    echo '<tr><th>PCFR（株価キャッシュフロー倍率）</th><td>', number_format($companyData['pcfr'], 2), '％</td></tr>';
    echo '<tr><th>1株当たりのキャッシュフロー</th><td>', number_format($companyData['eps_cash_flow'], 2), '</td></tr>';
    echo '</table></div>';    
}   else    {
        echo "データが存在しません。";
    }
?>
<?php require '../footer.php'; ?>

