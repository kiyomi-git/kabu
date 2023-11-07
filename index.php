<?php require '../header.php'; ?>

<h3>-新規登録-</h3>
<form action="index-out.php" method="post">
    <table>
        <tr>
            <td><label for="company_name">会社名:</label></td>
            <td><input type="text" name="company_name" class="textbox" required></td>
        </tr>
        <tr>
            <td><label for="aapl">証券コード:</label></td>
            <td><input type="number" name="aapl" class="textbox" required></td>
        </tr>
        <tr>
            <td><label for="date">日付:</label></td>
            <td><input type="date" name="date" class="textbox" required></td> 
        </tr>
        <tr>
            <td><label for="ir_name">IR開示名:</label></td>
            <td><input type="text" name="ir_name" class="textbox" required></td>
        </tr>
    </table>

    <?php
    $sections = [[
            'title' => '-収(損)益計算書-',
            'fields' => [
                '売上高:' => 'revenue', 
                '経常利益:' => 'opo_income',
                '純利益(当期純利益):' => 'profit', 
                
            ]],[
            'title' => '-貸借対照表-',
            'fields' => [
                '総資産:' => 'assets',
                '負債:' => 'liabilities',
                '純資産:' => 'net_assets',
            ]],[
            'title' => '-キャッシュフロー-',
            'fields' => [
                '営業活動によるキャッシュフロー:' => 'sales_cash_flow',
                '投資活動によるキャッシュフロー:' => 'inv_cash_flow',
                '財務活動によるキャッシュフロー:' => 'fin_cash_flow',
            ]],];

    foreach ($sections as $section) : ?>
        <h3><?php echo $section['title']; ?></h3>
        <table>
            <?php foreach ($section['fields'] as $key => $value) : ?>
                <tr>
                    <td><label for="<?php echo $value; ?>"><?php echo $key; ?></label></td>
                    <td><input type="number" name="<?php echo $value; ?>" class="textbox">百万円</td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endforeach; ?>
    <h3>-株式-</h3>
    <table>
        <tr>
            <td><label for="stock_price">株価（100株当たり）:</label></td>
            <td><input type="number" name="stock_price" class="textbox" required></td>
        </tr>
        <tr>
            <td><label for="dividend">年間配当金（100株当たり）:</label></td>
            <td><input type="number" name="dividend" class="textbox" required></td>
        </tr>
        <tr>
            <td><label for="stock_count">発行済み株式数:</label></td>
            <td><input type="number" name="stock_count" class="textbox" required></td> 
        </tr>
    </table>
    <p><input type="submit" value="入力する" class="textbox" name="out"></p>
</form>

<?php require '../footer.php'; ?>
