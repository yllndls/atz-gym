<?php
    define('DB_HOSTNAME', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'gym_management');

    define('USER_TYPE_ADMIN', 1);
    define('USER_TYPE_MEMBER', 2);

    define('PRDCT_STATUS_OFF_FLG', 0);
    define('PRDCT_STATUS_ON_FLG', 1);
    define('PRDCT_STATUS_OFF', 'active');
    define('PRDCT_STATUS_ON', 'Inactive');

    define('TMP_UPLOAD_PRODUCT', 'product');
    define('TMP_UPLOAD_PROFILE', 'profile');
    define('TMP_UPLOAD_RECEIPT', 'receipt');

    define('FORM_FLAG_SAVE', 1);
    define('FORM_FLAG_EDIT', 2);

    define('ONLINE_FLAG', 1);
    define('OFFLINE_FLAG', 0);

    define('PROFILE_NOT_VERIFY', 0);
    define('PROFILE_VERIFY', 1);


    define('PAYMENT_TYPE_COUNTER', 0);
    define('PAYMENT_TYPE_GCASH', 1);

    define('PAYMENT_STATUS_UNPAID', 0);
    define('PAYMENT_STATUS_VERIFY', 1);
    define('PAYMENT_STATUS_PAID', 2);

    define('MEMBERSHIP_STATUS_NEW', 0);
    define('MEMBERSHIP_STATUS_RENEWAL', 1);
    define('MEMBERSHIP_STATUS_EXPIRED', 2);

    define('MEMBERSHIP_FLAG_OFF', 0);
    define('MEMBERSHIP_FLAG_ON', 1);

    define('ORDER_TYPE_MEMBERSHIP', 'membership');
    define('ORDER_TYPE_PRODUCT', 'product');

    define('EXPIRED_FLAG_OFF', 0);
    define('EXPIRED_FLAG_ON', 1);

    define('DEFAULT_QUANTITY', 1);
?>