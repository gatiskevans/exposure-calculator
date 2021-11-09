<?php

namespace App\Descriptions;

class ExposureValueDescriptions
{
    public static function getDescription(int $ev): string
    {
        switch($ev){
            case $ev <= -7:
                $description = "Deep star field or the Milky Way.";
                break;
            case $ev === -6:
                $description = "Night under starlight only or the Aurora Borealis.";
                break;
            case $ev === -5:
                $description = "Night under crescent moon or the Aurora Borealis.";
                break;
            case $ev === -4:
                $description = "Night under half moon, or a meteor shower (with long exposure duration).";
                break;
            case $ev === -3:
                $description = "Night under full moon and away from city lights.";
                break;
            case $ev === -2:
                $description = "Night snowscape under full moon and away from city lights.";
                break;
            case $ev === -1:
                $description = "Start (sunrise) or end (sunset) of the \"blue hour\" (outdoors) or dim ambient lighting (indoors).";
                break;
            case $ev === 0:
                $description = "Dim ambient artificial lighting.";
                break;
            case $ev === 1:
                $description = "Distant view of a lit skyline.";
                break;
            case $ev === 2:
                $description = "Under lightning (with time exposure) or a total lunar eclipse.";
                break;
            case $ev === 3;
                $description = "Fireworks (with time exposure).";
                break;
            case $ev === 4;
                $description = "Candle-lit close-ups, Christmas lights, floodlight buildings, fountains, or bright street lamps.";
                break;
            case $ev === 5;
                $description = "Home interiors at night, fairs and amusement parks.";
                break;
            case $ev === 6;
                $description = "Brightly lit home interiors at night, fairs and amusement parks.";
                break;
            case $ev === 7;
                $description = "Bottom of a rainforest canopy, or along brightly-lit night-time streets.
Floodlit indoor sports areas or stadiums, and stage shows, including circuses.";
                break;
            case $ev === 8;
                $description = "Store windows, campfires, bonfires, ice shows,
Floodlit indoor sports areas or stadiums, and interiors with bright florescents.";
                break;
            case $ev === 9;
                $description = "Landscapes, city skylines 10 minutes after sunset, neon lights.";
                break;
            case $ev === 10;
                $description = "Landscapes and skylines immediately after sunset, capturing a crescent moon using a long lens.";
                break;
            case $ev === 11;
                $description = "Sunsets. Subject to deep shade.";
                break;
            case $ev === 12;
                $description = "Open shade or heavy overcast, capturing half moon using long lens.";
                break;
            case $ev === 13;
                $description = "Cloudy-bright light (no shadows), capturing gibbous moon using long lens.";
                break;
            case $ev === 14;
                $description = "Weak hazy sun, rainbows (soft shadows), capturing the full moon using long lens.";
                break;
            case $ev === 15;
                $description = "Bright or hazy sun, clear sky (distinct shadows).";
                break;
            case $ev === 16;
                $description = "Bright daylight on sand or snow (distinct shadows).";
                break;
            case $ev >= 17 && $ev < 19;
                $description = "Very bright artificial lighting.";
                break;
            case $ev >= 20;
                $description = "Extremely bright artificial lighting, telescopic view of the sun.";
                break;
            default:
                $description = "Something went wrong!";
                break;
        }

        return $description;
    }
}