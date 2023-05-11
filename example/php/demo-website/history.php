<!--
On this page you can see the transactions details.
-->
<!DOCTYPE html>
<html>
<head>
    <title>My demo website</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="container" style="width: 90%">
    <h1>Transaction details</h1>
    <p>Go back and <a href="/">buy more</a></p>
    <div class="history">
        <?php
        $dbFile = 'data.json';
        $data = file_get_contents($dbFile);
        $history = array_reverse(json_decode($data, true));
        foreach ($history as $item) {
        ?>
            <div class="history-block">
                <div class="history-item">
                    <div class="history-item-key">transaction_id</div>
                    <div class="history-item-value"><?=$item['id']?></div>
                </div>
                <div class="history-item">
                    <div class="history-item-key">client_id</div>
                    <div class="history-item-value"><?=$item['client_id']?></div>
                </div>
                <div class="history-item">
                    <div class="history-item-key">payment_status</div>
                    <div class="history-item-value"><?=$item['status']?></div>
                </div>
                <div class="history-item">
                    <div class="history-item-key">message</div>
                    <div class="history-item-value"><?=$item['message']?></div>
                </div>
                <div class="history-item">
                    <div class="history-item-key">amount_paid</div>
                    <div class="history-item-value"><?=$item['amount_paid']?></div>
                </div>
                <div class="history-item">
                    <div class="history-item-key">currency</div>
                    <div class="history-item-value"><?=$item['currency']?></div>
                </div>
                <div class="history-item">
                    <div class="history-item-key">payment_date</div>
                    <div class="history-item-value"><?=$item['payment_date']?></div>
                </div>
                <div class="history-item">
                    <div class="history-item-key">payment_method</div>
                    <div class="history-item-value"><?=$item['payment_method']?></div>
                </div>
            </div>
        <?php break; } ?>
    </div>
</div>
</body>
</html>
