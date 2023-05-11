# Demo website

The demo website is a simple website that allows you to test the DikeShield payment gateway.

The website is composed of the following files:

- `index.php` - main page of the website
- `thank.php` - thank you page, the user is redirected to this page after a successful payment
- `error.php` - error page, the user is redirected to this page after a failed payment
- `callback.php` - callback script, this script is called by DikeShield after a payment is made, here we save the transaction details into the database
- `data.json` - contains the data of the transactions (database)
- `history.php` - last transaction details
- `style.css` - stylesheet for the website

## Configuration

To configure the demo website you need to edit the `index.php` file. You have to change the API-key on line 14.

## Installation

To run the demo simply upload the files to your web server and open the `http://example.com/index.php` page in your browser.