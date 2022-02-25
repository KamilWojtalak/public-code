<?php

const URL_DELIMETER = '/';
/** Index in $url_arr where the resource is */
const URL_RESOURCE_INDEX = 3;
/** Index in $url_arr where the ID is */
const URL_RESOURCE_ID_INDEX = URL_RESOURCE_INDEX + 1;

/** Access token expiration time in seconds */
const JWT_ACCESS_TOKEN_EXPIRATION_TIME = 300;
/** Access token expiration time in seconds (5 days) */
const JWT_REFRESH_TOKEN_EXPIRATION_TIME = 43200;
