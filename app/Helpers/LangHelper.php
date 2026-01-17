<?php
function currentLang()
{
    return request('lang', 'en'); // default en
}
