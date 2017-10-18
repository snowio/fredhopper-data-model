<?php
namespace SnowIO\FredhopperDataModel\Internal;

function validateId(string $id)
{
    if (!\preg_match('{^[a-z0-9_]+$}', $id)) {
        throw new \Exception('Invalid Id');
    }
}

function sanitizeId(string $id): string
{
    $id = \strtolower($id);
    $id = \preg_replace('/[^a-z0-9\_]/', '_', $id);
    $id = \trim($id, '_');
    return $id;
}

function validateLocale(string $locale)
{
    $locales = [
        'sq_AL',
        'ar_DZ',
        'ar_BH',
        'ar_EG',
        'ar_IQ',
        'ar_JO',
        'ar_KW',
        'ar_LB',
        'ar_LY',
        'ar_MA',
        'ar_OM',
        'ar_QA',
        'ar_SA',
        'ar_SD',
        'ar_SY',
        'ar_TN',
        'ar_AE',
        'ar_YE',
        'be_BY',
        'bg_BG',
        'ca_ES',
        'zh_CN',
        'zh_SG',
        'zh_HK',
        'zh_TW',
        'hr_HR',
        'cs_CZ',
        'da_DK',
        'nl_BE',
        'nl_NL',
        'en_AU',
        'en_CA',
        'en_IN',
        'en_IE',
        'en_MT',
        'en_NZ',
        'en_PH',
        'en_SG',
        'en_ZA',
        'en_GB',
        'en_US',
        'et_EE',
        'fi_FI',
        'fr_BE',
        'fr_CA',
        'fr_FR',
        'fr_LU',
        'fr_CH',
        'de_AT',
        'de_DE',
        'de_LU',
        'de_CH',
        'el_CY',
        'el_GR',
        'iw_IL',
        'hi_IN',
        'hu_HU',
        'is_IS',
        'in_ID',
        'ga_IE',
        'it_IT',
        'it_CH',
        'ja_JP',
        'ja_JP_JP',
        'ko_KR',
        'lv_LV',
        'lt_LT',
        'mk_MK',
        'ms_MY',
        'mt_MT',
        'no_NO',
        'no_NO_NY',
        'pl_PL',
        'pt_BR',
        'pt_PT',
        'ro_RO',
        'ru_RU',
        'sr_BA',
        'sr_ME',
        'sr_RS',
        'sr_Latn_BA',
        'sr_Latn_ME',
        'sr_Latn_RS',
        'sk_SK',
        'sl_SI',
        'es_AR',
        'es_BO',
        'es_CL',
        'es_CO',
        'es_CR',
        'es_DO',
        'es_EC',
        'es_SV',
        'es_GT',
        'es_HN',
        'es_MX',
        'es_NI',
        'es_PA',
        'es_PY',
        'es_PE',
        'es_PR',
        'es_ES',
        'es_US',
        'es_UY',
        'es_VE',
        'sv_SE',
        'th_TH',
        'th_TH_TH',
        'tr_TR',
        'uk_UA',
        'vi_VN',
    ];

    if (!in_array($locale, $locales)) {
        throw new \Exception('Invalid Locale');
    }
}
