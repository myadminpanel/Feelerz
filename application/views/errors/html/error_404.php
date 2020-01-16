<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>404 Page Not Found</title>
<style type="text/css">

::selection { background-color: #E13300; color: white; }
::-moz-selection { background-color: #E13300; color: white; }
html {height:100%;}
body {
	background-color: #fff;
	margin: 0;
	font: 13px/20px normal Helvetica, Arial, sans-serif;
	color: #4F5155;
	-moz-box-align: center;
    -moz-box-pack: center;
    align-items: center;
    display: flex;
    justify-content: center;
	height: 100%;
}
.error-box {
    background: #fff none repeat scroll 0 0;
    border-radius: 5px;
    color: #919fa9;
    line-height: 1;
    margin: 0 auto;
    max-width: 475px;
    padding: 50px 30px 55px;
    text-align: center;
    width: 100%;
}
.error-heading {
    color: #ae9dfb;
    font-size: 3.5em;
    font-weight: bold;
}
.error-title {
    color: #2c2c2c;
    font-size: 22px;
    font-weight: normal;
    margin: 0 0 1.5rem;
}
.return-home {
    background-color: #ae9dfb;
    border-radius: 4px;
    color: #fff;
    display: inline-block;
    font-size: 18px;
    font-weight: bold;
    padding: 9px 15px;
    text-decoration: none;
}
a {
	color: #003399;
	background-color: transparent;
	font-weight: normal;
}
</style>
</head>
<body>
	<div id="container" class="error-box">
		<div class="error-heading"><?php echo $heading; ?></div>
		<div class="error-title"><?php echo $message; ?></div>
		<div class="error-content">
			<p>Unfortunately the page you were looking for could not be found.
			It may be temporarily unavailable, moved or no longer exist.
			Check the URL you entered for any mistakes and try again.</p>
		</div>
	<a href="<?php $this->config =& get_config();
        echo $this->config['base_url'];  ?>" class="return-home">Return Home</a>
	</div>
</body>
</html>