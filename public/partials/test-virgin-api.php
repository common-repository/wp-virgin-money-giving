<?php 

$wp_virgin_settings = get_option('wp_virgin_money_giving_options_name');

$key = $wp_virgin_settings['fundDevelopersKey'];
$resourceID = $wp_virgin_settings['fundResourceID'];

$api = new Virgin_Money_Giving_Fundraisers(array(
    'fundDevelopersKey' => $key
));


$fundraisers_details = $api->get_fundraisers_details($resourceID);

echo '<pre>';
print_r($fundraisers_details);
echo '</pre>';

$fundraisers_page_details = $api->get_fundraisers_page_details($resourceID, '5');

echo '<pre>';
print_r($fundraisers_page_details);
echo '</pre>';

/*
$fundraisers_search = $api->return_fundraisers_search('421d8098-3cf7-11e3-80f9-00237d37086c', 'Woods', 'Michael');

echo '<pre>';
print_r($fundraisers_search);
echo '</pre>';
*/

