<?php

// Get the data from the file
$data = file_get_contents('data.json');

// Parse the data into an array
$dataArray = json_decode($data, true);

// Get the transaction id from the postback body
$id = $_POST['transaction_id'];

// Loop through the array and find the transaction by id
foreach ($dataArray as &$item) {

    // If transaction is found update the data
    if ($item['id'] == $id)
    {
        $item['client_id'] = $_POST['client_id'];
        $item['status'] = $_POST['payment_status'];
        $item['message'] = $_POST['message'];
        $item['amount_available'] = $_POST['amount_available'];
        $item['amount_paid'] = $_POST['amount_paid'];
        $item['currency'] = $_POST['currency'];
        $item['commission'] = $_POST['commission'];
        $item['payment_date'] = $_POST['payment_date'];
        $item['payment_method'] = $_POST['payment_method'];
        break;
    }
}

// Encode the array back to a JSON string
$dataJson = json_encode($dataArray);

// And save it to the file
file_put_contents('data.json', $dataJson, LOCK_EX);

// Return a success response (not required)
header('Content-Type: application/json');
die(json_encode(['result'=>'success'], JSON_PRETTY_PRINT));