<?php session_start(); ?>
<?php require '../header.php'; ?>
<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=kabu;charset=utf8', 'root');        

    $company_name = $_REQUEST['company_name'];

    $sql = $pdo->prepare('SELECT * FROM ir_date WHERE company_name=?');
    $sql->execute([$company_name]);


    if ($sql->rowCount() > 0) {
        echo '<h3>' . $_REQUEST['company_name'] . '-登録-</h3>';
        echo '<form action="index-out.php" method="post">';
        echo '<table>';
        if ($sql->rowCount() > 0) {
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            echo '<tr><td>
                <label for="company_name">会社名:</label>
                </td><td>
                <input type="text" name="company_name" value="', $row['company_name'], '" class="textbox" required>
                </td></tr>';
            echo '<tr><td>
                <label for="aapl">証券コード:</label>
                </td><td>
                <input type="number" name="aapl" value="', $row['aapl'], '" class="textbox" required>
                </td></tr>';
            echo '<tr><td>
                <label for="date">日付:</label>
                </td><td>
                <input type="date" name="date" value="', $row['date'], '" class="textbox" required>
                </td></tr>';
            echo '<tr><td>
                <label for="ir_name">IR開示名:</label>
                </td><td>
                <input type="text" name="ir_name" value="', $row['ir_name'], '" class="textbox" required>
                </td></tr></table>';
            echo '<h3>-収(損)益計算書-</h3>';
            echo '<table><tr><td>
                <label for="revenue">売上高:</label>
                </td><td>
                <input type="number" name="revenue" value="', $row['revenue'], '" class="textbox">百万円
                </td></tr>';
            echo '<tr><td>
                <label for="opo_income">経常利益:</label>
                </td><td>
                <input type="number" name="opo_income" value="', $row['opo_income'], '" class="textbox">百万円
                </td></tr>';
            echo '<tr><td>
                <label for="profit">純利益(当期純利益):</label>
                </td><td>
                <input type="number" name="profit" value="', $row['profit'], '" class="textbox">百万円
                </td></tr></table>';
            echo '<h3>-貸借対照表-</h3>';
            echo '<table><tr><td>
                <label for="assets">総資産:</label>
                </td><td>
                <input type="number" name="assets" value="', $row['assets'], '" class="textbox">百万円
                </td> </tr>';
            echo '<tr><td>
                <label for="liabilities">負債:</label>
                </td><td>
                <input type="number" name="liabilities" value="', $row['liabilities'], '" class="textbox">百万円
                </td></tr>';
            echo '<tr><td>
                <label for="net_assets">純資産:</label>
                </td><td>
                <input type="number" name="net_assets" value="', $row['net_assets'], '" class="textbox">百万円
                </td></tr></table>';
            echo '<h3>-株式-</h3>';
            echo '<table><tr><td>
                <label for="stock_price">株価（100株当たり）:</label>
                </td><td>
                <input type="number" name="stock_price" value="', $row['stock_price'], '" class="textbox">円
                </td></tr>';
            echo '<tr><td>
                <label for="dividend">年間配当金（100株当たり）:</label>
                </td><td>
                <input type="number" name="dividend" value="', $row['dividend'], '" class="textbox">円
                </td></tr>';
            echo '<tr><td>
                <label for="stock_count">発行済み株式数:</label>
                </td><td>
                <input type="number" name="stock_count" value="', $row['stock_count'], '" class="textbox">株
                </td></tr></table>';
            echo '<h3>-キャッシュフロー-</h3>';
            echo '<table><tr><td>
                <label for="sales_cash_flow">営業活動によるキャッシュフロー:</label>
                </td><td>
                <input type="number" name="sales_cash_flow" value="', $row['sales_cash_flow'], '" class="textbox">百万円
                </td></tr>';
            echo '<tr><td>
                <label for="inv_cash_flow">投資活動によるキャッシュフロー:</label>
                </td><td>
                <input type="number" name="inv_cash_flow" value="', $row['inv_cash_flow'], '" class="textbox">百万円
                </td></tr>';
            echo '<tr><td>
                <label for="fin_cash_flow">財務活動によるキャッシュフロー:</label>
                </td><td>
                <input type="number" name="fin_cash_flow" value="', $row['fin_cash_flow'], '" class="textbox">百万円
                </td></tr>';
            echo '</table><p><input type="submit" value="入力する" class="textbox" name="out"></p></form>';
        }
    } else {
        echo '会社名: ' . $_REQUEST['company_name'] . 'のデータが存在しません。';
    }
} catch (PDOException $e) {
    echo 'エラー: ' . $e->getMessage();
}
?>
<?php require '../footer.php'; ?>