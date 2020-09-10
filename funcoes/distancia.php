<?php
function Distance($lat1, $lon1, $lat2, $lon2, $unit)
{ 
    $radius = 6378.137; // earth mean radius defined by WGS84
    $dlon = $lon1 - $lon2; 
    $distance = acos( sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($dlon))) * $radius; 
    if ($unit == "K")
    {
        return ($distance); 
    }
    else if ($unit == "M")
    {
        return ($distance * 0.621371192);
    }
    else if ($unit == "N")
    {
        return ($distance * 0.539956803);
    }
    else
    {
          return 0;
    }
}
?>