function geoplugin_request() { return '182.70.163.89';} 
function geoplugin_status() { return '200';} 
function geoplugin_credit() { return 'Some of the returned data includes GeoLite data created by MaxMind, available from <a href=\'http://www.maxmind.com\'>http://www.maxmind.com</a>.';} 
function geoplugin_delay() { return '1ms';} 
function geoplugin_city() { return 'Bhopal';} 
function geoplugin_region() { return 'Madhya Pradesh';} 
function geoplugin_regionCode() { return 'MP';} 
function geoplugin_regionName() { return 'Madhya Pradesh';} 
function geoplugin_areaCode() { return '';} 
function geoplugin_dmaCode() { return '';} 
function geoplugin_countryCode() { return 'IN';} 
function geoplugin_countryName() { return 'India';} 
function geoplugin_inEU() { return 0;} 
function geoplugin_euVATrate() { return ;} 
function geoplugin_continentCode() { return 'AS';} 
function geoplugin_latitude() { return '23.2667';} 
function geoplugin_longitude() { return '77.4';} 
function geoplugin_locationAccuracyRadius() { return '200';} 
function geoplugin_timezone() { return 'Asia/Kolkata';} 
function geoplugin_currencyCode() { return 'INR';} 
function geoplugin_currencySymbol() { return '&#8377;';} 
function geoplugin_currencySymbol_UTF8() { return '₹';} 
function geoplugin_currencyConverter(amt, symbol) { 
	if (!amt) { return false; } 
	var converted = amt * 69.9969; 
	if (converted <0) { return false; } 
	if (symbol === false) { return Math.round(converted * 100)/100; } 
	else { return '&#8377;'+(Math.round(converted * 100)/100);} 
	return false; 
} 
