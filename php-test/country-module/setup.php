<?php
if ( ! function_exists( 'xs_get_country' ) ) {
	function xs_get_country(){
		$countryData = include( __DIR__ .'/xs-countries.php' );
		return $countryData;
	}
}
if ( ! function_exists( 'xs_get_country_state' ) ) {
	function xs_get_country_state($country = ''){
		$stateData = include( __DIR__ .'/xs-states.php' );
		if(!empty($country)){
			$stateData = isset($stateData[$country]) ? $stateData[$country] : [];
		}
		return $stateData;
	}
}
if ( ! function_exists( 'xs_get_country_phone' ) ) {
	function xs_get_country_phone($country = ''){
		$stateData = include( __DIR__ .'/xs-phone.php' );
		if(!empty($country)){
			$stateData = isset($stateData[$country]) ? $stateData[$country] : '';
		}
		return $stateData;
	}
}
if ( ! function_exists( 'xs_get_country_local' ) ) {
	function xs_get_country_local($country = ''){
		$localData = include( __DIR__ .'/xs-locale-info.php' );
		if(!empty($country)){
			$localData = isset($localData[$country]) ? $localData[$country] : [];
		}
		return $localData;
	}
}
if ( ! function_exists( 'xs_get_currency_symbol' ) ) {
	function xs_get_currency_symbol($cc = 'USD')
	{
		$cc = strtoupper($cc);
		$currency = array(
		"USD" => "$" , //U.S. Dollar
		"AUD" => "A$" , //Australian Dollar
		"BRL" => "R$" , //Brazilian Real
		"CAD" => "C$" , //Canadian Dollar
		"CZK" => "Kč" , //Czech Koruna
		"DKK" => "kr" , //Danish Krone
		"EUR" => "€" , //Euro
		"HKD" => "HK$" , //Hong Kong Dollar
		"HUF" => "Ft" , //Hungarian Forint
		"ILS" => "₪" , //Israeli New Sheqel
		"INR" => "₹", //Indian Rupee
		"JPY" => "¥" , //Japanese Yen 
		"MYR" => "RM" , //Malaysian Ringgit 
		"NOK" => "kr" , //Norwegian Krone
		"NZD" => "&#36" , //New Zealand Dollar
		"PHP" => "₱" , //Philippine Peso
		"PLN" => "zł" ,//Polish Zloty
		"GBP" => "£" , //Pound Sterling
		"SEK" => "kr" , //Swedish Krona
		"CHF" => "Fr" , //Swiss Franc
		"TWD" => "$" , //Taiwan New Dollar 
		"THB" => "฿" , //Thai Baht
		"TRY" => "₺", //Turkish Lira
		"AED" => "د.إ", 
		"ANG" => "NAƒ", 
		"ARS" => "AR$", 
		"AFN" => "&#1547;", 
		"ALL" => "L", 
		"DZD" => "د.ج", 
		"AOA" => "Kz", 
		"XCD" => "EC$", 
		"AMD" => "դր", 
		"AWG" => "ƒ", 
		"AZN" => "ман", 
		"BSD" => "BS$", 
		"BHD" => "ب.د", 
		"BBD" => "Bds$", 
		"BYR" => "Br", 
		"BZD" => "BZ$", 
		"XOF" => "franc", 
		"BMD" => "BD$", 
		"BTN" => "Nu", 
		"BOB" => "Bs", 
		"BAM" => "KM", 
		"BWP" => "P", 
		"BND" => "B$", 
		"BGN" => "лв", 
		"BIF" => "FBu", 
		"XAF" => "franc", 
		"CAD" => "CA$", 
		"CVE" => "CV$", 
		"KYD" => "CI$", 
		"CLP" => "CL$", 
		"CNY" => "CN¥", 
		"COP" => "Col$", 
		"KMF" => "KMF", 
		"CDF" => "CDFr", 
		"NZD" => "NZ$", 
		"CRC" => "₡", 
		"HRK" => "HRK", 
		"CUC" => "CU$", 
		"CYP" => "CY£", 
		"CZK" => "Kč", 
		//"DKK" => "ø", 
		"DJF" => "Fdj", 
		"DOP" => "RD$", 
		"EGP" => "ج.م", 
		"ERN" => "Nfk", 
		"EEK" => "KR", 
		"ETB" => "Br", 
		"FKP" => "FK£", 
		"FJD" => "FJ$", 
		"XPF" => "CFP", 
		"GMD" => "D", 
		"GEL" => "GEL", 
		"GHC" => "₵", 
		"GIP" => "GI£", 
		"GTQ" => "Q", 
		"GNF" => "FG", 
		"GYD" => "GY$", 
		"HTG" => "G", 
		"HNL" => "L", 
		"ISK" => "ISK", 
		"IDR" => "Rp", 
		"IRR" => "ريال", 
		"IQD" => "ع.د", 
		"JMD" => "JA$", 
		//"JPY" => "JP¥", 
		"JOD" => "JD", 
		"KZT" => "KZT", 
		"KES" => "KSh", 
		"KPW" => "₩", 
		"KRW" => "₩", 
		"KWD" => "د.ك", 
		"KGS" => "KGS", 
		"LAK" => "₭", 
		"LVL" => "Ls", 
		"LBP" => "ل.ل", 
		"LSL" => "L", 
		"LRD" => "L$", 
		"LYD" => "ل.د", 
		"CHF" => "CHF", 
		"LTL" => "Lt", 
		"MOP" => "MO$", 
		"MKD" => "MKD", 
		"MGA" => "MGA", 
		"MWK" => "MK", 
		"MVR" => "MRf", 
		"MTL" => "Lm", 
		"MRO" => "UM", 
		"MUR" => "MU₨", 
		"MXN" => "Mex$", 
		"MDL" => "MDL", 
		"MNT" => "₮", 
		"MAD" => "د.م", 
		"MZN" => "MTn", 
		"MMK" => "K", 
		"NAD" => "N$", 
		"NPR" => "NP₹", 
		"ANG" => "NP₹", 
		"NIO" => "C$", 
		"NGN" => "₦", 
		"NOK" => "øre", 
		"OMR" => "ر.ع", 
		"PKR" => "PK₹", 
		"PAB" => "PAB", 
		"PGK" => "K", 
		"PYG" => "₲", 
		"PEN" => "S./", 
		"PHP" => "₱", 
		"PLN" => "zł", 
		"QAR" => "ر.ق", 
		"RON" => "ROL", 
		"RUB" => "RUруб", 
		"RWF" => "RF", 
		"SHP" => "SH£", 
		"WST" => "WS$", 
		"STD" => "Db", 
		"SAR" => "ر.س", 
		"RSD" => "дин", 
		"SCR" => "S₹", 
		"SLL" => "Le", 
		"SGD" => "S$", 
		"SKK" => "Sk", 
		"SBD" => "SI$", 
		"SOS" => "Sh", 
		"ZAR" => "SAR", 
		"LKR" => "LK₹", 
		"SDD" => "£Sd", 
		"SRD" => "SR$", 
		"NOK" => "øre", 
		"SZL" => "SZL", 
		"SEK" => "kr", 
		"CHF" => "CHF", 
		"SYP" => "S£", 
		"TWD" => "NT$", 
		"TJS" => "TJS", 
		"TZS" => "TSh", 
		"THB" => "฿", 
		"TOP" => "PT$", 
		"TTD" => "TT$", 
		"TND" => "د.ت", 
		"TRY" => "YTL", 
		"TMM" => "m", 
		"UGX" => "USh", 
		"UAH" => "₴", 
		"UYU" => "UR$", 
		"UZS" => "UZS", 
		"VUV" => "Vt", 
		"VEB" => "Bs", 
		"VND" => "₫", 
		"YER" => "YER", 
		"ZMK" => "ZK", 
		"ZWD" => "Z$", 
		"CUP" => "MN$", 
		"ECS" => "EC$", 
		"SVC" => "₡", 
		"GHS" => "GHS", 
		"GGP" => "GGP", 
		"GWP" => "GWP", 
		"KHR" => "៛", 
		"BDT" => "Tk." 
		//"BDT" => "৳" 
		);
		
		if(array_key_exists($cc, $currency)){
			return $currency[$cc];
		}
	}
}

if ( ! function_exists( 'xs_get_country_currency' ) ) {
	
	function xs_get_country_currency($code = 'US') {
		$code = strtoupper($code);
		$info =  array(
			'AF' => 'AFN',
			'AX' => 'EUR',
			'AL' => 'ALL',
			'DZ' => 'DZD',
			'AS' => 'USD',
			'AD' => 'EUR',
			'AO' => 'AOA',
			'AI' => 'XCD',
			'AQ' => 'XCD',
			'AG' => 'XCD',
			'AR' => 'ARS',
			'AM' => 'AMD',
			'AW' => 'AWG',
			'AU' => 'AUD',
			'AT' => 'EUR',
			'AZ' => 'AZN',
			'BS' => 'BSD',
			'BH' => 'BHD',
			'BD' => 'BDT',
			'BB' => 'BBD',
			'BQ' => 'USD',
			'BY' => 'BYR',
			'BE' => 'EUR',
			'BZ' => 'BZD',
			'BJ' => 'XOF',
			'BM' => 'BMD',
			'BT' => 'BTN',
			'BO' => 'BOB',
			'BA' => 'BAM',
			'BW' => 'BWP',
			'BV' => 'NOK',
			'BR' => 'BRL',
			'IO' => 'USD',
			'BN' => 'BND',
			'BG' => 'BGN',
			'BF' => 'XOF',
			'BI' => 'BIF',
			'KH' => 'KHR',
			'CM' => 'XAF',
			'CA' => 'CAD',
			'CV' => 'CVE',
			'KY' => 'KYD',
			'CF' => 'XAF',
			'TD' => 'XAF',
			'CL' => 'CLP',
			'CN' => 'CNY',
			'HK' => 'HKD',
			'CX' => 'AUD',
			'CC' => 'AUD',
			'CO' => 'COP',
			'KM' => 'KMF',
			'CG' => 'XAF',
			'CD' => 'CDF',
			'CK' => 'NZD',
			'CR' => 'CRC',
			'HR' => 'HRK',
			'CU' => 'CUP',
			'CW' => 'ANG',
			'CY' => 'EUR',
			'CZ' => 'CZK',
			'DK' => 'DKK',
			'DJ' => 'DJF',
			'DM' => 'XCD',
			'DO' => 'DOP',
			'EC' => 'ECS',
			'EG' => 'EGP',
			'SV' => 'SVC',
			'GQ' => 'XAF',
			'ER' => 'ERN',
			'EE' => 'EUR',
			'ET' => 'ETB',
			'FK' => 'FKP',
			'FO' => 'DKK',
			'FJ' => 'FJD',
			'FI' => 'EUR',
			'FR' => 'EUR',
			'GF' => 'EUR',
			'PF' => 'XPF',
			'TF' => 'EUR',
			'GA' => 'XAF',
			'GM' => 'GMD',
			'GE' => 'GEL',
			'DE' => 'EUR',
			'GH' => 'GHS',
			'GI' => 'GIP',
			'GR' => 'EUR',
			'GL' => 'DKK',
			'GD' => 'XCD',
			'GP' => 'EUR',
			'GU' => 'USD',
			'GT' => 'GTQ',
			'GG' => 'GGP',
			'GN' => 'GNF',
			'GW' => 'GWP',
			'GY' => 'GYD',
			'HT' => 'HTG',
			'HM' => 'AUD',
			'HN' => 'HNL',
			'HU' => 'HUF',
			'IS' => 'ISK',
			'IN' => 'INR',
			'ID' => 'IDR',
			'IR' => 'IRR',
			'IQ' => 'IQD',
			'IE' => 'EUR',
			'IM' => 'GBP',
			'IL' => 'ILS',
			'IT' => 'EUR',
			'JM' => 'JMD',
			'JP' => 'JPY',
			'JE' => 'GBP',
			'JO' => 'JOD',
			'KZ' => 'KZT',
			'KE' => 'KES',
			'KI' => 'AUD',
			'KP' => 'KPW',
			'KR' => 'KRW',
			'KW' => 'KWD',
			'KG' => 'KGS',
			'LA' => 'LAK',
			'LV' => 'EUR',
			'LB' => 'LBP',
			'LS' => 'LSL',
			'LR' => 'LRD',
			'LY' => 'LYD',
			'LI' => 'CHF',
			'LT' => 'EUR',
			'LU' => 'EUR',
			'MK' => 'MKD',
			'MG' => 'MGF',
			'MW' => 'MWK',
			'MY' => 'MYR',
			'MV' => 'MVR',
			'ML' => 'XOF',
			'MT' => 'EUR',
			'MH' => 'USD',
			'MQ' => 'EUR',
			'MR' => 'MRO',
			'MU' => 'MUR',
			'YT' => 'EUR',
			'MX' => 'MXN',
			'FM' => 'USD',
			'MD' => 'MDL',
			'MC' => 'EUR',
			'MN' => 'MNT',
			'ME' => 'EUR',
			'MS' => 'XCD',
			'MA' => 'MAD',
			'MZ' => 'MZN',
			'MM' => 'MMK',
			'NA' => 'NAD',
			'NR' => 'AUD',
			'NP' => 'NPR',
			'NL' => 'EUR',
			'AN' => 'ANG',
			'NC' => 'XPF',
			'NZ' => 'NZD',
			'NI' => 'NIO',
			'NE' => 'XOF',
			'NG' => 'NGN',
			'NU' => 'NZD',
			'NF' => 'AUD',
			'MP' => 'USD',
			'NO' => 'NOK',
			'OM' => 'OMR',
			'PK' => 'PKR',
			'PW' => 'USD',
			'PA' => 'PAB',
			'PG' => 'PGK',
			'PY' => 'PYG',
			'PE' => 'PEN',
			'PH' => 'PHP',
			'PN' => 'NZD',
			'PL' => 'PLN',
			'PT' => 'EUR',
			'PR' => 'USD',
			'QA' => 'QAR',
			'RE' => 'EUR',
			'RO' => 'RON',
			'RU' => 'RUB',
			'RW' => 'RWF',
			'SH' => 'SHP',
			'KN' => 'XCD',
			'LC' => 'XCD',
			'PM' => 'EUR',
			'VC' => 'XCD',
			'WS' => 'WST',
			'SM' => 'EUR',
			'ST' => 'STD',
			'SA' => 'SAR',
			'SN' => 'XOF',
			'RS' => 'RSD',
			'SC' => 'SCR',
			'SL' => 'SLL',
			'SG' => 'SGD',
			'SK' => 'EUR',
			'SI' => 'EUR',
			'SB' => 'SBD',
			'SO' => 'SOS',
			'ZA' => 'ZAR',
			'GS' => 'GBP',
			'SS' => 'SSP',
			'ES' => 'EUR',
			'LK' => 'LKR',
			'SD' => 'SDG',
			'SR' => 'SRD',
			'SJ' => 'NOK',
			'SZ' => 'SZL',
			'SE' => 'SEK',
			'CH' => 'CHF',
			'SY' => 'SYP',
			'TW' => 'TWD',
			'TJ' => 'TJS',
			'TZ' => 'TZS',
			'TH' => 'THB',
			'TG' => 'XOF',
			'TK' => 'NZD',
			'TO' => 'TOP',
			'TT' => 'TTD',
			'TN' => 'TND',
			'TR' => 'TRY',
			'TM' => 'TMT',
			'TC' => 'USD',
			'TV' => 'AUD',
			'UG' => 'UGX',
			'UA' => 'UAH',
			'AE' => 'AED',
			'GB' => 'GBP',
			'US' => 'USD',
			'UM' => 'USD',
			'UY' => 'UYU',
			'UZ' => 'UZS',
			'VU' => 'VUV',
			'VE' => 'VEF',
			'VN' => 'VND',
			'VI' => 'USD',
			'WF' => 'XPF',
			'EH' => 'MAD',
			'YE' => 'YER',
			'ZM' => 'ZMW',
			'ZW' => 'ZWD',
		);
		
		if(array_key_exists($code, $info)){
			return $info[$code];
		}
	}
}
/*
$country = [];
$countryList = xs_get_country();
//print_r($countryList);
if(is_array($countryList) && sizeof($countryList) > 0){					
	foreach($countryList AS $key=>$value):
		$country[$key]['info'] = [ 
			'name' => $value,
			'phone_code' => xs_get_country_phone($key),
		];
		$localListDefult = xs_get_country_local($key);
		
		$country[$key]['currency'] = [ 
			'code' => isset($localListDefult['currency_code']) ? $localListDefult['currency_code'] : 'USD',
			'symbol' => xs_get_currency_symbol(isset($localListDefult['currency_code']) ? $localListDefult['currency_code'] : 'USD'),
			'currency_pos' => isset($localListDefult['currency_pos']) ? $localListDefult['currency_pos'] : 'left',
			'thousand' => isset($localListDefult['thousand_sep']) ? $localListDefult['thousand_sep'] : ',',
			'decimal' => isset($localListDefult['decimal_sep']) ? $localListDefult['decimal_sep'] : '.',
			'num_decimals' => isset($localListDefult['num_decimals']) ? $localListDefult['num_decimals'] : '2',
			'weight_unit' => isset($localListDefult['weight_unit']) ? $localListDefult['weight_unit'] : 'kg',
			'dimension_unit' => isset($localListDefult['dimension_unit']) ? $localListDefult['dimension_unit'] : 'in',
			'tax_rates' => isset($localListDefult['tax_rates']) ? $localListDefult['tax_rates'] : [],
		];
		
		$country[$key]['states'] = xs_get_country_state($key);
	endforeach;
}

$file = 'E:\wamp\www\test\country-module/xs-info.php';
file_put_contents($file, "<?php\n\$my_array = ".var_export($country, true).";\n");

// or format
file_put_contents($file, var_export($var, true));
eval('$myvar = ' . file_get_contents($file) . ';');



$file = 'xs-info.php';
include($file);
echo '<pre>'; print_r($my_array); echo '</pre>';
*/