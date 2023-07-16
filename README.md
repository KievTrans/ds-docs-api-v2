# API Documentation: DikeShield Processing Gateway

The DikeShield Processing Gateway API allows websites to process payment transactions using the DikeShield service. This document outlines the data format for communication between the website and the DikeShield gateway.

## Authorization

The unique identifier (API key) of the website will be provided by DikeShield during registration.

Each request must include the `api-key` header containing your API key.

## General Information

Endpoint: `https://api.dshield.co/v2/`

Response body example for a successful request:

```
{
    "result": "success",
    "data": ...
}
```

Response body example for a failed request:

```
{
    "result": "error",
    "message": "Error description text."
}
```

If you use something other than PHP on the backend, when making a request to the API, specify the following header: 

```
Content-Type: multipart/form-data
```

## Create a payment link

`POST https://api.dshield.co/v2/payment`

### Request

The website sends the following data to the DikeShield Processing Gateway for payment processing.

| Element             | Description                                                                                                                                                                  |
|---------------------|------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| client_id           | A unique number managed by the website to identify the client.                                                                                                               |
| client_email        | An email identifier of the customer where an OTP message may be sent by the system prior to the payment.                                                                     |
| client_private_name | The first name of the customer.                                                                                                                                              |
| client_family_name  | The last name of the customer.                                                                                                                                               |
| client_country      | The country code of the customer's country.                                                                                                                                  |
| amount              | The amount of money to be processed by DikeShield.                                                                                                                           |
| currency            | The currency of the transaction. Only `USD`, `EUR`, and `GBP` are supported.                                                                                                 |
| description         | A brief description of the transaction or the product/service being purchased.                                                                                               |
| success_url         | The URL to which the customer should be redirected after successfully completing the payment.                                                                                |
| failed_url          | The URL to which the customer should be redirected if an error occurs during the payment.                                                                                    |
| callback_url        | The URL to which DikeShield should send a notification of the payment status after processing the transaction.                                                               |
| force_processor     | Set force processor to select a specific processor from the available list. `0` - automatically selected by DikeShield system, `1` - Flutterwave, `2` - Squad, `3` - Stripe. |

### Request Example

```
{
    "client_id": "123456789",
    "client_email": "john@acrobat.com",
    "client_private_name": "John",
    "client_family_name": "Miller",
    "client_country": "US",
    "amount": 50.00,
    "currency": "USD"
    "description": "Short description of the transaction",
    "success_url": "https://www.example.com/thankyou",
    "failed_url": "https://www.example.com/error",
    "callback_url": "https://www.example.com/payment_callback",
    "force_processor": 0
}
```

### Response

The DikeShield Processing Gateway sends the following JSON data back to the website in response to a payment processing request.

| Element  | Description |
| ------------- | ------------- |
| id  | A unique identifier for the payment transaction generated by DikeShield.  |
| payment_url  | The payment URL that the website must send its user to complete the payment process.  |

### Response Example

```
{
    "result": "success",
    "data": {
        "id": "5dc777ae1780e41ed5c7b2f52e930c42",
        "payment_url": "https://paydshield.com/pay/v/XXXXXXXXXX"
    }
}
```

## Callback

When the transaction is paid the website will receive back a `POST` request containing the following data.

| Element  | Description |
| ------------- | ------------- |
| client_id  | The same client ID was sent by the website to DikeShield.  |
| payment_status  | Indicates whether the payment was successful or failed. The possible value is `success`.  |
| message  | If the payment failed, this field provides a reason for the failure.  |
| amount_available | The amount of money available for withdrawal (transaction amount minus DikeShield commission). |
| amount_paid  | The amount of money received by DikeShield.  |
| currency  | The currency of the processed payment, as specified in the request data.  |
| commission  | The commission held by DikeShield for the transaction.  |
| transaction_id  | A unique identifier for the payment transaction generated by DikeShield.  |
| payment_date  | The date that the payment was processed by DikeShield. Unix timestamp. |
| payment_method  | The payment method used for the transaction (e.g. credit card, PayPal, etc.).  |
| merchant_id  | The unique identifier of the website's merchant account with DikeShield, if applicable. |

### Callback Example
```
{
    "transaction_id": "5dc777ae1780e41ed5c7b2f52e930c42",
    "client_id": "123456789",
    "payment_status": "success",
    "message": null,
    "amount_available": "50.00",
    "amount_paid": "50.00"
    "currency": "USD"
    "commission": "XX.00",
    "payment_date": 1680971073,
    "payment_method": "Credit Card",
    "merchant_id": "1"
}
```

## Transaction Details

The method allows you to get additional information on the transaction and check its status.

### Request

`GET https://api.dshield.co/v2/transaction?id={transaction_id}`

| Element  | Description |
| ------------- | ------------- |
| id  | A unique identifier for the payment transaction generated by DikeShield.  |

### Response

The response contains a transaction object:

| Element  | Description |
| ------------- | ------------- |
| id  | A unique identifier for the payment transaction generated by DikeShield.  |
| status  | The transaction's current status. Possible values are: `pending`, `success`, `failed` and `chargeback.  |
| amount  | The amount of money that was specified when requesting to create a payment link.  |
| currency  | The currency of the processed payment, as specified in the request data.  |
| commission  | The commission held by DikeShield for the transaction.  |
| message  | Additional payment information.  |
| created_at  | The date the transaction was created. Unix timestamp. |
| paid_at  | The date the transaction was paid. Unix timestamp. |
| updated_at  | The date the transaction was updated. Unix timestamp. |

```
{
    "result": "success",
    "data": {
        "id": "44ff3eb4f032d0b2033628ce21aef442",
        "status": "success",
        "amount": "100.00",
        "currency": "USD",
        "commission": "XX.00",
        "message": "",
        "created_at": 1680971073,
        "paid_at": 1680971073,
        "updated_at": 1680971074
    }
}
```

## Transaction List

The method allows you to get a list of all recent transactions.

### Request

`GET httsp://api.dshield.co/v2/transactions`

| Element  | Description |
| ------------- | ------------- |
| start_date  | Optional. The start date in the `YYYY-MM-DD` format. The date is three days ago by default.  |
| end_date  | Optional.  The end date in the `YYYY-MM-DD` format.  Today is the default date. |
| status  | Optional. Possible values are `pending`, `success`, `failed`, `chargeback`. |

Example:

```
GET httsp://api.dshield.co/v2/transactions?start_date=2022-01-01&end_date=2022-01-30&status=success
GET httsp://api.dshield.co/v2/transactions?start_date=2022-01-01&end_date=2022-01-30
GET httsp://api.dshield.co/v2/transactions?status=chargeback
```

### Response

The response contains an array of transaction objects, the same as for the previous query.

```
{
    "result": "success",
    "data": [
        {
            "id": "44ff3eb4f032d0b2033628ce21aef442",
            "status": "success",
            "amount": "100.00",
            "currency": "USD",
            "commission": "XX.00",
            "message": "",
            "created_at": 1680971073,
            "paid_at": 1680971073,
            "updated_at": 1680971074
        },
        ...
    ]
}
```

## Country Codes

`GET https://api.dshield.co/v2/countries`

The method allows you to get a list of all supported country codes.

---

That's it! This documentation should help you get started with using the DikeShield Processing Gateway API.

If you have any questions or concerns, please contact our support team at admin@dshield.com

---

## Changelog

### 1.1 (2023-04-29)

- Added `client_private_name` and `client_family_name` parameters to the `payment` method.
- Changed endpoint URL to `https://api.dshield.co/v1.1/`.

### 2023-05-03

- Added `client_country` parameter to the `payment` method.
- Added `countries` method.

### 2.0 (2023-05-11)

- Added `force_processor` parameter to the `payment` method.
- Changed endpoint URL to `https://api.dshield.co/v2/`.
