<?php
\Magento\Framework\Component\ComponentRegistrar::register(
    \Magento\Framework\Component\ComponentRegistrar::LANGUAGE,
    '${vendor}_${package}_${languageISO}_${countryISO}',
    __DIR__
);