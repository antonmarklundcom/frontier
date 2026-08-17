<?php
/**
 * Environment-backed secrets. Copy to config/env.php on the server only.
 * Never commit config/env.php. Prefer real environment variables where the host
 * supports them; this file is the Hostinger shared-hosting fallback.
 */
return [
    // SMTP — authenticated submission. Until this is configured and a real test
    // message has been received, the consultation form is not "working".
    'smtp_host'   => getenv('PF_SMTP_HOST')   ?: '',
    'smtp_port'   => getenv('PF_SMTP_PORT')   ?: '587',
    'smtp_user'   => getenv('PF_SMTP_USER')   ?: '',
    'smtp_pass'   => getenv('PF_SMTP_PASS')   ?: '',
    'mail_to'     => getenv('PF_MAIL_TO')     ?: '',
    'mail_from'   => getenv('PF_MAIL_FROM')   ?: '',

    // VenderCRM — server-to-server only. The key never reaches the browser.
    'crm_enabled' => (bool) getenv('PF_CRM_ENABLED'),
    'crm_endpoint'=> getenv('PF_CRM_ENDPOINT') ?: '',
    'crm_key'     => getenv('PF_CRM_KEY')      ?: '',
    'crm_source'  => 'site:paraguayfrontier.com',
];
