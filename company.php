<?php
session_start();
require '../header.php';
?>
<hr>
<form action="#" method="post"> 
    会社名検索:<input type="text" name="keyword" class="textbox" placeholder="(例: 株式会社〇〇)">
    <input type="submit" value="検索" class="textbox">
</form>
<form action="#" method="post">
    <label for="range">証券コード検索:</label>
    <input type="number" name="range_min" class="textbox" placeholder="(例: 1300)">~
    <input type="number" name="range_max" class="textbox" placeholder="(例: 1999)">
    <input type="submit" value="検索" class="textbox">
</form>


<hr>
<?php
$pdo = new PDO('mysql:host=localhost;dbname=kabu;charset=utf8', 'root');
$pageSize = 10;
$page = isset($_REQUEST['page']) ? (int)$_REQUEST['page'] : 1;
$offset = ($page - 1) * $pageSize;
$sql = null; 
if (isset($_REQUEST['range_min']) && isset($_REQUEST['range_max'])) {
    $min_aapl = (int)$_REQUEST['range_min'];
    $max_aapl = (int)$_REQUEST['range_max'];

    // 範囲をチェックして無効な入力を防ぐこともできます
    if ($min_aapl >= 1300 && $max_aapl >= $min_aapl && $max_aapl <= 9999) {
        $sql = $pdo->prepare('SELECT * FROM ir_date WHERE aapl BETWEEN :min_aapl AND :max_aapl LIMIT :limit OFFSET :offset');
        $sql->bindParam(':min_aapl', $min_aapl, PDO::PARAM_INT);
        $sql->bindParam(':max_aapl', $max_aapl, PDO::PARAM_INT);
        $sql->bindParam(':limit', $pageSize, PDO::PARAM_INT);
        $sql->bindParam(':offset', $offset, PDO::PARAM_INT);
        $sql->execute();

        $trtd = "";
        $i = 0;

        foreach ($sql as $row) {
            $trtd .= '<tr>';
            $trtd .= '<td><a href="company-out.php?company_name=' . $row['company_name'] . '">' . $row['company_name'] . '</a></td>';
            $trtd .= '<td>' . $row['aapl'] . '</td>';
            $trtd .= '<td>' . $row['date'] . '</td>';
            $trtd .= '<td>' . $row['ir_name'] . '</td>';
            $trtd .= '</tr>';
            $i++;
        }
        if ($i == 0) {
            echo "選択された範囲の証券コードは登録されていません.";
        } else {
            echo '<h3>-会社一覧-</h3><table><tr><th>会社名</th><th>証券コード</th><th>日付</th><th>IR開示名</th></tr>';
            echo $trtd;
        }
    } else {
        echo "無効な範囲が指定されました。範囲は1300から9999の間で、最小値は最大値より小さくなければなりません。";
    }
}
   elseif (isset($_REQUEST['keyword']))    {
    $sql = $pdo->prepare('SELECT * FROM ir_date WHERE company_name LIKE :keyword LIMIT :limit OFFSET :offset');
    $keyword = '%' . $_REQUEST['keyword'] . '%';
    $sql->bindParam(':keyword', $keyword, PDO::PARAM_STR);
    $sql->bindParam(':limit', $pageSize, PDO::PARAM_INT);
    $sql->bindParam(':offset', $offset, PDO::PARAM_INT);
    $sql->execute();

    echo '<h3>-会社一覧-</h3><table><tr><th>会社名</th><th>証券コード</th><th>日付</th><th>IR開示名</th></tr>';

    foreach ($sql as $row){
        echo '<tr>';
        echo '<td><a href="company-out.php?company_name=' . $row['company_name'] . '">',  $row['company_name'], '</a></td>';
        echo '<td>' . $row['aapl'] . '</td>';
        echo '<td>' . $row['date'] . '</td>';
        echo '<td>' . $row['ir_name'] . '</td>';
        echo '</tr>';
    }
}   else    {
    echo '<h3>-会社一覧-</h3><table><tr><th>会社名</th><th>証券コード</th><th>日付</th><th>IR開示名</th></tr>';
    
    $sql = $pdo->prepare('SELECT * FROM ir_date LIMIT :limit OFFSET :offset');
    $sql->bindParam(':limit', $pageSize, PDO::PARAM_INT);
    $sql->bindParam(':offset', $offset, PDO::PARAM_INT);
    $sql->execute();

    foreach ($sql as $row) {
        echo '<tr>';
        echo '<td><a href="company-out.php?company_name=' . urlencode($row['company_name']) . '">', $row['company_name'], '</a></td>';
        echo '<td>' . $row['aapl'] . '</td>';
        echo '<td>' . $row['date'] . '</td>';
        echo '<td>' . $row['ir_name'] . '</td>';
        echo '</tr>';
    }
}

echo '</table>';
if ($page > 1) {
    echo '<a href="?page=' . ($page - 1) . '">前のページ</a>';
}
if ($sql && $sql->rowCount() == $pageSize) {
    echo ' | ';
    echo '<a href="?page=' . ($page + 1) . '">次のページ</a>';
}
?>
<?php require '../footer.php'; ?>
