<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

$config['warn_email_from'] = 'noreply@jswitch.absys.ninja'; // asal email warning mengenai balance
$config['warn_email_form_name'] = 'jSwitch System'; // nama dari pemilik email tersebut

$config['dev_domain'] = 'staging.mobeli.co.id'; // domain name for jSwitch core api -- development
$config['prod_domain'] = 'corepay.mobeli.co.id'; // domain name for jSwitch core api -- production
$config['dev_domain_url'] = 'http://staging.mobeli.co.id/'; // domain name for jSwitch core api -- development
$config['prod_domain_url'] = 'http://corepay.mobeli.co.id/'; // domain name for jSwitch core api -- production
$config['dev_mwallet_url'] = 'http://staging.mobeli.co.id/mswitch/'; // URL for merchant wallet -- development
$config['prod_mwallet_url'] = 'http://mwallet.mobeli.co.id/'; // URL for merchant wallet -- production
$config['dev_iswitch_url'] = 'http://staging.mobeli.co.id/'; // URL for XCMS -- development
$config['prod_iswitch_url'] = 'http://xcms.mobeli.co.id/'; // URL for XCMS -- production

$config['artagraha_proxy_url_dev'] = 'http://103.30.180.157/ag_proxy_dev.php'; // full URL to artagraha proxy script -- development
$config['artagraha_proxy_url_prod'] = 'http://103.30.180.157/ag_proxy_prod.php'; // full URL to artagraha proxy script -- production

// config for generic merchant:
$config['generic_merchant_code'] = 'GENERIC';

// config for email alert
$config['username'] = 'alert@jatis.com';
$config['password'] = 'jtsmobiledev~!@#juga';
$config['subject'] = 'List Switching Failed Transaction on '.date('Y-m-d');

// config for JATELINDO DEV
//$config['terminal_id'] = 'DEVJATIS';
//$config['acceptor_id'] = '200900100800000';
//$config['jatelindo_host'] = '202.152.22.118';
//$config['jatelindo_port'] = '1423';

// config for JATELINDO PRODUCTION
$config['terminal_id'] = '54JATIS1';
$config['acceptor_id'] = '201211111111111';
$config['jatelindo_host'] = '202.152.22.116';
$config['jatelindo_port'] = '6050';

// config for email RTG
$config['usernamertg'] = 'testing-alert@jatis.com';
$config['passwordrtg'] = 'jtsmobiledev~!@#juga';
$config['subjectrtg'] = 'BPJS Reconcile Report for '.date('Y-m-d');
$config['day']= '1';
