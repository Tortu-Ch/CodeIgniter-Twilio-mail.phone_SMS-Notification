<?php

//available social link types and icon 
$social_link_icons = array(
    "facebook" => "facebook",
    "twitter" => "twitter",
    "linkedin" => "linkedin",
    "googleplus" => "google-plus",
    "digg" => "digg",
    "youtube" => "youtube",
    "pinterest" => "pinterest",
    "instagram" => "instagram",
    "github" => "github",
    "tumblr" => "tumblr",
    "vine" => "vine",
);
$links = "";

foreach ($social_link_icons as $key => $icon) {
    if (isset($weblinks->$key) && $weblinks->$key) {
        $address = to_url($weblinks->$key); //check http or https in url
        $links.="<a target='_blank' href='$address' class='social-link fa fa-$icon'></a>";
    }
}
echo $links;
?>
