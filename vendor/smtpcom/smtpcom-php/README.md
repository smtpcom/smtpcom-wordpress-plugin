# smtp.com PHP SDK

This is the smtp.com PHP SDK. This SDK contains methods for interacting with the smtp.com API.
Below are examples to get you started. For additional information, please see API documentation at
https://www.smtp.com/resources/api-documentation/

# Install

Via Composer

``` bash
$ composer require smtpcom/smtpcom-php
```

# Usage
```php
require 'vendor/autoload.php';
use SmtpSdk\SmtpSdk;

// First, instantiate the SDK with your API credentials
$ps = SmtpSdk::create('api-key-example'); // Use default api url and version
$ps = SmtpSdk::create('api-key-example', 'https://api.smtp.com', 'v4');
```


## Statistics

#### Get event aggregates for the specified data slices and duration
```php
$parameters = [
    'start'           => 'string',  // The starting time. Required if the {duration} path parameter is not specified.
    'end'             => 'string',  // The ending time. If not specified, defaults to now. RFC 2822 or UNIX epoch format.
    'duration'        => 'string',  // A standardized shorthand for a known start/end bracket.
    'slice'           => 'string',  // A reducing method which can be applied to the requested duration.
    'slice_specifier' => 'string',  // Slice value
    'group_by'        => 'string',  // Define a grouping
    'event'           => 'array',   // Array of any event names for which stats has been requested.
    'limit'           => 'integer', // Maximum number of items to return.
    'offset'          => 'integer'  // Number of items to skip before returning the results.
];
$ps->statistics()->index($parameters);
```


## Account

#### Get account information
```php
$ps->account()->show();
```


## Channels

#### Get All Channels
```php
$ps->channels()->index();
```

#### Create a New Channel
```php
$parameters = [
    'smtp_username' => 'string',  // *Required. Username for the channel
    'smtp_password' => 'string',  // *Required. Password for the channel
    'quota'         => 'integer', // *Required. Quota for the channel
];
$ps->channels()->create($parameters);
```

#### Get Channel Details
```php
$ps->channels($name)->show();
```

#### Delete a Channel
```php
$ps->channels($name)->delete();
```

#### Update Channel Details
```php
$parameters = [
    'smtp_username' => 'string',  // Username for the channel
    'smtp_password' => 'string',  // Password for the channel
    'quota'         => 'integer', // Quota for the channel
];
$ps->channels($name)->update($parameters);
```


## API keys

#### List All API Keys
```php
$ps->keys()->index();
```

#### Create a New API Key
```php
$parameters = [
    'name'        => 'string', // *Required. Name for API key
    'description' => 'string'  // Description for API key
];
$ps->keys()->create($parameters);
```


## Reports

#### Get All Reports
```php
$ps->reports()->index();
```

#### Create On-Demand Report
```php
$parameters = [
    'channel'     => 'string',  // Name of the channel for which a given report has been defined
    'type'        => 'string',  // Type or report format. If not specified defaults to “csv” - currently the only supported type
    'start'       => 'integer', // *Required. Start date/time of the report in RFC 2822 or UNIX epoch format
    'end'         => 'string',  // End date/time of the report in RFC 2822 or UNIX epoch format (default - now)
    'domain'      => 'string',  // Filter by the “from” domain of emails
    'rcpt_domain' => 'string',  // Filter by the “to” domain of emails
    'events'      => 'string',  // Filter by event type.
    'columns'     => ['col1']   // Array of columns to be specified in the report.
];
$ps->reports()->onDemand()->create($parameters);
```

#### Get Report Details
```php
$ps->reports($reportId)->show();
```

#### Create Periodic Report
```php
$parameters = [
    'frequency'     => 'string',  // *Required. Report frequency
    'report_time'   => 'integer', // *Required. The hour at which the report should be sent.
    'channel'       => 'string',  // Name of the channel for which a given report has been defined
    'notify_method' => 'string',  // Notification method to be used when report is completed and can be downloaded
    'notify_dest'   => 'string',  // A valid URL which will accept the report completion notification.
    'domain'        => 'string',  // Filter by the “From” domain of emails
    'rcpt_domain'   => 'string',  // Filter by the “To” domain of emails
    'events'        => 'string',  // Filter by event type.
    'columns'       => ['col1']   // Array of columns to be specified in the report.
];
$ps->reports()->periodic()->create($parameters);
```


## Alerts

#### List All Allerts
```php
$ps->alerts()->index();
```

#### Create New Alert
```php
$parameters = [
    'type'      => 'string', // *Required. An alert’s type. Currently only “monthly_quota” is supported
    'threshold' => 'decimal' // Number which represents a percentage of an account’s monthly quota. Must be decimal between 0 and 1
];
$ps->alerts()->create($parameters);
```

#### Get Alert Details
```php
$ps->alerts($alertId)->show();
```

#### Delete Alert
```php
$ps->alerts($alertId)->delete();
```

#### Update Alert Details
```php
$parameters = [
    'threshold' => 'decimal' // *Required. Number which represents a percentage of an account’s monthly quota. Must be decimal between 0 and 1
];
$ps->alerts($alertId)->update($parameters);
```


## Domains

#### Get All Registered Domains
```php
$ps->domains()->index();
```

#### Register a Domain
```php
$ps->domains($domainName)->create();
```

#### Get Domain Details
```php
$ps->domains($domainName)->show();
```

#### Delete Domain
```php
$ps->domains($domainName)->delete();
```

#### Update Domain Details
```php
$parameters = [
    'enabled' => 'boolean' // *Required. Whether the domain is enabled
];
$ps->domains($domainName)->update($parameters);
```


## DKIM keys

#### Get DKIM for Domain
```php
$ps->domains($domainName)->dkim()->show();
```

#### Add DKIM for Domain
```php
$parameters = [
    'selector'    => 'string', // *Required. Name of DKIM selector for this domain
    'private_key' => 'string'  // *Required. Private key of the DKIM record
];
$ps->domains($domainName)->dkim()->create($parameters);
```

#### Delete DKIM for Domain
```php
$ps->domains($domainName)->dkim()->delete();
```

#### Update DKIM Key Details
```php
$parameters = [
    'selector'    => 'string', // *Required. Name of DKIM selector for this domain
    'private_key' => 'string'  // *Required. Private key of the DKIM record
];
$ps->domains($domainName)->dkim()->update($parameters);
```


## Callbacks

#### List All Callbacks
```php
$ps->callbacks()->index();
```

#### Delete All Callbacks
```php
$ps->callbacks()->deleteAll();
```

#### Get Callback Details
```php
$ps->callbacks($channel)->type($event)->show();
```

#### Create Callback
```php
$parameters = [
    'medium'  => 'string', // *Required. Medium to send callback data.
    'address' => 'string', // *Required. Address of where the callback data should be sent.
    'awsData' => 'string'  // Amazon SQS settings
];
$ps->callbacks($channel)->type($event)->create($parameters);
```

#### Delete Callback
```php
$ps->callbacks($channel)->type($event)->delete();
```

#### Update Callback Details
```php
$parameters = [
    'medium'  => 'string', // Medium to send callback data.
    'address' => 'string', // Address of where the callback data should be sent.
    'awsData' => 'string'  // Amazon SQS settings
];
$ps->callbacks($channel)->type($event)->update($parameters);
```

#### View Callback Logs
```php
$parameters = [
    'limit' => 'integer' // Number of items to return in the response. Default is 20
];
$ps->callbacks($channel)->logs()->index($parameters);
```


## Messages

#### Get Detailed Messages Info
```php
$parameters = [
    'start'   => 'string',  // *Required. The starting time. RFC 2822 or UNIX epoch format
    'end'     => 'string',  // The ending time. If not specified, defaults to now. RFC 2822 or UNIX epoch format.
    'event'   => 'array',   // Array of any event names for which stats has been requested ('accepted', 'failed', 'delivered').
    'limit'   => 'integer', // *Required. Maximum number of items to return.
    'offset'  => 'integer', // *Required. Number of items to skip before returning the results.
    'msg_id'  => 'integer'  // Unique message ID
];
$ps->messages($channel)->index($parameters);
```

#### Send a Message
```php
// Extended variant
// Full Email Address object:
[
    'name'    => 'string', // Name of a person, must be a valid RFC 2822 name
    'address' => 'string'  // *Required. Email address, as specified in RFC 2822
];
$parameters = [
    'recipients' => [ // At least one of to, cc, bcc or bulk_list
        'to' => [/* Full Email Address objects array */],
        'cc' => [/* Full Email Address objects array */], // CC recipients array
        'bcc' => [/* Full Email Address objects array */], // BCC recipients array
        'bulk_list' => [/* Full Email Address objects array */] // Distribution array.
                                                                // Instead of an individual email to multiple recipients,
                                                                // multiple emails to multiple recipients will be created.
    ],
    'originator' => [ // At least one of from or reply_to must be specified here.
        'from' => [/* Full Email Address object */],
        'reply_to' => [/* Full Email Address object */]
    ],
    'subject' => 'string', // Email subject. Multiline value is supported, 998 characters max.
    'body' => [
        'parts' => [ // Array of content parts
            [
                'version'  => 'string', // MIME version. By default set to 1.0
                'type'     => 'string', // MIME type. By default set to plain/text
                'charset'  => 'string', // Content character set -- i.e. UTF-8, ISO-8859-1, etc.
                'encoding' => 'string', // Content encoding – i.e. 7bit, quoted-printable, base64, etc. default base64
                'content'  => 'string'  // Actual part’s content in its raw form
            ]
        ],
        'attachments' => [ // Array of attachments
            [
                'type'        => 'string', // MIME type. By default set to application/octet-stream
                'disposition' => 'string', // Content-disposition, either inline or attachment. By default set to attachment
                'filename'    => 'string', // Name of attached file
                'cid'         => 'string', // Content ID for inline dispositions. By default this is equal to the filename.
                                           // Can be used in HTML content to address an attached image using “cid:” URL scheme.
                'content'     => 'string' // Actual attachment content in its raw form
            ]
        ],
    ],
    'custom_headers' => [], // Optional. A name of a header to customize (both standard and non-standard) and its value,
                            // which can be either string or array of strings
];
$ps->messages($channel)->create($parameters);

// Simplified variant
// from - sender email (Full Email Address object or Email string)
// to - recipient email or array of emails
// subject - Email subject. Multiline value is supported, 998 characters max.
// body - Email content
// attachments - Array of attachments. Optional.
$ps->messages($channel)->create($from, $to, $subject, $body, $attachments);
```

#### Send MIME Message
```php
// Extended variant
$parameters = [
    'mime' => 'string', // A completely prepared full MIME container of the email, compliant with RFC 2045, RFC 2046,
                        // RFC 2047, RFC 4288, RFC 4289 and RFC 2049. No validation will be performed during API
                        // submission and it will be attempted to be delivered as is. Any errors while processing
                        // and delivering this email will be available only via callbacks.
    'recipients' => [/* Similar to create method */],
    'originator' => [/* Similar to create method */]
];
$ps->messages($channel)->createMime($parameters);

// Simplified variant
// from - sender email
// to - recipient email or array of emails
// mime - A completely prepared full MIME container of the email
$ps->messages($channel)->createMime($from, $to, $mime);
```
