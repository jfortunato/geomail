# Geomail

Send emails based on geographic location.

## Usage

#### Basic Usage
```php
$html = ''; // Use whatever means to create an html message.
$config = [
    'google_maps_api_key'        => '<API-KEY>', // Google Maps API Key
    'range'                      => 50, // Range in miles
    'geomail_always_send_emails' => [], // An array of emails to always send to, in addition to the sendClosest() location
    'mailer_host'                => '',
    'mailer_port'                => '',
    'mailer_username'            => '',
    'mailer_password'            => '',
    'mailer_from'                => '',
];

// The center point we want to use
$postalCode = \Geomail\PostalCode::determine('90210');

// Parse a "locations.json" file, containing 'lat', 'lng', & 'email' fields
$parser = new \Geomail\Parser\JsonLocationsParser;
$locations = $parser('/path/to/locations.json', 'lat', 'lng', 'email');

$geomail = \Geomail\Geomail::prepare('Example Subject', $html, $config);
$geomail->sendClosest($postalCode, $locations);

// Email sent to location closest to 90210 postal code (in addition to "geomail_always_send_emails")
```
