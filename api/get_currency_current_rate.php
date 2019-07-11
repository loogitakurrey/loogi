<?php
$api_key='d4ec30171e8d13fc2a03138e1aae3800';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://data.fixer.io/api/2019-01-01?access_key=d4ec30171e8d13fc2a03138e1aae3800&base=EUR&symbols=INR,USD,EUR,GBP,ILS');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
$result= curl_exec($ch);
curl_close($ch);
echo "<pre>";
print_r(json_decode($result,true));
$data = json_decode($result,true);
$data = $data['rates'];
$inr = $data['INR'];
$usd = $data['USD'];
$eur = $data['EUR'];
$gbp = $data['GBP'];
$ils = $data['ILS'];
?>