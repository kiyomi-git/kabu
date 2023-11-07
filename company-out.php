<?php
session_start();
require '../header.php';
    $pdo = new PDO('mysql:host=localhost;dbname=kabu;charset=utf8', 'root');
if (isset($_REQUEST['company_name'])) {
    $_SESSION['company_name'] = $_REQUEST['company_name'];
    $page = 0;
}   else    {
        unset($_SESSION['company_name']);
    }
    $company_name = $_SESSION['company_name'] ?? '';
    $page = isset($_REQUEST['page']) ? (int)$_REQUEST['page'] : 0;
    $pageSize = 5;
    $offset = $page * $pageSize;
if (!empty($company_name)) {
    $sql = $pdo->prepare("SELECT * FROM index_date WHERE company_name = ? LIMIT $pageSize OFFSET $offset");
    $sql->execute([$company_name]);
    if ($sql->rowCount() > 0) {
        echo '<a href="../index/update.php?company_name=', $company_name, '">-追加登録する-</a>';
        echo '<h3>会社名: ' . $company_name . '</h3>';
        echo '<table>';
        echo '<tr>
            <th>日付</th>
            <th>ROE</th>
            <th>ROA</th>
            <th>EPS</th>
            <th>PER</th>
            <th>自己資本回転率</th>
            <th>BPS</th>
            <th>PBR</th>
            <th>自己資本比率</th>
            <th>総資本回転率</th>
            <th>配当利回り</th>
            <th>PCFR</th>
            </tr>';

        foreach ($sql as $row) {
            echo '<tr>
                <th>', $row['date'], '</th>
                <td>', $row['roe'], '％</td>
                <td>', $row['roa'], '％</td>
                <td>', $row['eps'], '％</td>
                <td>', $row['per'], '</td>
                <td>', round($row['etr']), '回</td>
                <td>', $row['bps'], '円</td>
                <td>', $row['pbr'], '</td>
                <td>', $row['er'], '％</td>
                <td>', $row['etar'], '回</td>
                <td>', $row['dy'], '％</td>
                <td>', $row['pcfr'], '％</td>
                </tr>';
        }
    } else {
        echo '会社名: ' . $company_name . 'のデータが存在しません。';
    }
}   else    {
        echo '会社名が指定されていません。';
    }

    echo '</table>';
    echo '<div>';
if ($page > 0) {
    echo '<a href="company-out.php?page=', $page - 1, '&company_name=', $company_name, '">前のページ</a>';
}
if ($sql->rowCount() >= $pageSize) {
    if ($page > 0) {
        echo ' | ';
    }
    echo '<a href="company-out.php?page=', $page + 1, '&company_name=', $company_name, '">次のページ</a>';
}
    echo '</div>';
require '../footer.php';
?>
