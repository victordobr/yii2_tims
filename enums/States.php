<?php
namespace app\enums;

use Yii;
use kfosoft\base\Enum;


/**
 * States Enum
 * @package app\enums
 */
class States extends Enum
{

    const ALABAMA = 0;
    const ALASKA = 1;
    const ARIZONA = 2;
    const ARKANSAS = 3;
    const CALIFORNIA = 4;
    const COLORADO = 5;
    const CONNECTICUT = 6;
    const DELAWARE = 7;
    const FLORIDA = 8;
    const GEORGIA = 9;
    const HAWAII = 10;
    const IDAHO = 11;
    const ILLINOIS = 12;
    const INDIANA = 13;
    const IOWA = 14;
    const KANSAS = 15;
    const KENTUCKY = 16;
    const LOUISIANA = 17;
    const MAINE = 18;
    const MARYLAND = 19;
    const MASSACHUSETTS = 20;
    const MICHIGAN = 21;
    const MINNESOTA = 22;
    const MISSISSIPPI = 23;
    const MISSOURI = 24;
    const MONTANA = 25;
    const NEBRASKA = 26;
    const NEVADA = 27;
    const NEW_HAMPSHIRE = 28;
    const NEW_JERSEY = 29;
    const NEW_MEXICO = 30;
    const NEW_YORK = 31;
    const NORTH_CAROLINA = 32;
    const NORTH_DAKOTA = 33;
    const OHIO = 34;
    const OKLAHOMA = 35;
    const OREGON = 36;
    const PENNSYLVANIA = 37;
    const RHODE_ISLAND = 38;
    const SOUTH_CAROLINA = 39;
    const SOUTH_DAKOTA = 40;
    const TENNESSEE = 41;
    const TEXAS = 42;
    const UTAH = 43;
    const VERMONT = 44;
    const VIRGINIA = 45;
    const WASHINGTON = 46;
    const WEST_VIRGINIA = 47;
    const WISCONSIN = 48;
    const WYOMING = 49;
    const ALBERTA = 50;
    const BRITISH_COLUMBIA = 51;
    const MANITOBA = 52;
    const NEW_BRUNSWICK = 53;
    const NEWFOUNDLAND_AND_LABRADOR = 54;
    const NORTHWEST_TERRITORIES = 55;
    const NOVA_SCOTIA = 56;
    const NUNAVUT = 57;
    const ONTARIO = 58;
    const PRINCE_EDWARD_ISLAND = 59;
    const QUEBEC = 60;
    const SASKATCHEWAN = 61;
    const YUKON = 62;

    /**
     * List of name state from the USA and Canada.
     * @return array|null data.
     */
    public static function listData()
    {
        return [
            self::ALABAMA  => Yii::t('app', 'Alabama'),
            self::ALASKA  => Yii::t('app', 'Alaska'),
            self::ARIZONA  => Yii::t('app', 'Arizona'),
            self::ARKANSAS  => Yii::t('app', 'Arkansas'),
            self::CALIFORNIA  => Yii::t('app', 'California'),
            self::COLORADO  => Yii::t('app', 'Colorado'),
            self::CONNECTICUT  => Yii::t('app', 'Connecticut'),
            self::DELAWARE  => Yii::t('app', 'Delaware'),
            self::FLORIDA  => Yii::t('app', 'Florida'),
            self::GEORGIA  => Yii::t('app', 'Georgia'),
            self::HAWAII  => Yii::t('app', 'Hawaii'),
            self::IDAHO  => Yii::t('app', 'Idaho'),
            self::ILLINOIS  => Yii::t('app', 'Illinois'),
            self::INDIANA  => Yii::t('app', 'Indiana'),
            self::IOWA  => Yii::t('app', 'Iowa'),
            self::KANSAS  => Yii::t('app', 'Kansas'),
            self::KENTUCKY  => Yii::t('app', 'Kentucky'),
            self::LOUISIANA  => Yii::t('app', 'Louisiana'),
            self::MAINE  => Yii::t('app', 'Maine'),
            self::MARYLAND  => Yii::t('app', 'Maryland'),
            self::MASSACHUSETTS  => Yii::t('app', 'Massachusetts'),
            self::MICHIGAN  => Yii::t('app', 'Michigan'),
            self::MINNESOTA  => Yii::t('app', 'Minnesota'),
            self::MISSISSIPPI  => Yii::t('app', 'Mississippi'),
            self::MISSOURI  => Yii::t('app', 'Missouri'),
            self::MONTANA  => Yii::t('app', 'Montana'),
            self::NEBRASKA  => Yii::t('app', 'Nebraska'),
            self::NEVADA  => Yii::t('app', 'Nevada'),
            self::NEW_HAMPSHIRE  => Yii::t('app', 'New Hampshire'),
            self::NEW_JERSEY  => Yii::t('app', 'New Jersey'),
            self::NEW_MEXICO  => Yii::t('app', 'New Mexico'),
            self::NEW_YORK  => Yii::t('app', 'New York'),
            self::NORTH_CAROLINA  => Yii::t('app', 'North Carolina'),
            self::NORTH_DAKOTA  => Yii::t('app', 'North Dakota'),
            self::OHIO  => Yii::t('app', 'Ohio'),
            self::OKLAHOMA  => Yii::t('app', 'Oklahoma'),
            self::OREGON  => Yii::t('app', 'Oregon'),
            self::PENNSYLVANIA  => Yii::t('app', 'Pennsylvania'),
            self::RHODE_ISLAND  => Yii::t('app', 'Rhode Island'),
            self::SOUTH_CAROLINA  => Yii::t('app', 'South Carolina'),
            self::SOUTH_DAKOTA  => Yii::t('app', 'South Dakota'),
            self::TENNESSEE  => Yii::t('app', 'Tennessee'),
            self::TEXAS  => Yii::t('app', 'Texas'),
            self::UTAH  => Yii::t('app', 'Utah'),
            self::VERMONT  => Yii::t('app', 'Vermont'),
            self::VIRGINIA  => Yii::t('app', 'Virginia'),
            self::WASHINGTON  => Yii::t('app', 'Washington'),
            self::WEST_VIRGINIA  => Yii::t('app', 'West Virginia'),
            self::WISCONSIN  => Yii::t('app', 'Wisconsin'),
            self::WYOMING  => Yii::t('app', 'Wyoming'),
            self::ALBERTA  => Yii::t('app', 'Alberta'),
            self::BRITISH_COLUMBIA  => Yii::t('app', 'British Columbia'),
            self::MANITOBA  => Yii::t('app', 'Manitoba'),
            self::NEW_BRUNSWICK  => Yii::t('app', 'New Brunswick'),
            self::NEWFOUNDLAND_AND_LABRADOR  => Yii::t('app', 'Newfoundland and Labrador'),
            self::NORTHWEST_TERRITORIES  => Yii::t('app', 'Northwest Territories'),
            self::NOVA_SCOTIA  => Yii::t('app', 'Nova Scotia'),
            self::NUNAVUT  => Yii::t('app', 'Nunavut'),
            self::ONTARIO  => Yii::t('app', 'Ontario'),
            self::PRINCE_EDWARD_ISLAND  => Yii::t('app', 'Prince Edward Island'),
            self::QUEBEC  => Yii::t('app', 'Quebec'),
            self::SASKATCHEWAN  => Yii::t('app', 'Saskatchewan'),
            self::YUKON  => Yii::t('app', 'Yukon'),
        ];
    }

    /**
     * List of abbreviations state from the USA and Canada.
     * @return array|null data.
     */
    public static function listDataAbbrev()
    {
        return [
            self::ALABAMA  => Yii::t('app', 'Ala.'),
            self::ALASKA  => Yii::t('app', 'Alaska'),
            self::ARIZONA  => Yii::t('app', 'Ariz.'),
            self::ARKANSAS  => Yii::t('app', 'Ark.'),
            self::CALIFORNIA  => Yii::t('app', 'Calif.'),
            self::COLORADO  => Yii::t('app', 'Colo.'),
            self::CONNECTICUT  => Yii::t('app', 'Conn.'),
            self::DELAWARE  => Yii::t('app', 'Del.'),
            self::FLORIDA  => Yii::t('app', 'Fla.'),
            self::GEORGIA  => Yii::t('app', 'Ga.'),
            self::HAWAII  => Yii::t('app', 'Hawaii'),
            self::IDAHO  => Yii::t('app', 'Idaho'),
            self::ILLINOIS  => Yii::t('app', 'Ill.'),
            self::INDIANA  => Yii::t('app', 'Ind.'),
            self::IOWA  => Yii::t('app', 'Iowa'),
            self::KANSAS  => Yii::t('app', 'Kan.'),
            self::KENTUCKY  => Yii::t('app', 'Ky.'),
            self::LOUISIANA  => Yii::t('app', 'La.'),
            self::MAINE  => Yii::t('app', 'Maine'),
            self::MARYLAND  => Yii::t('app', 'Md.'),
            self::MASSACHUSETTS  => Yii::t('app', 'Mass.'),
            self::MICHIGAN  => Yii::t('app', 'Mich.'),
            self::MINNESOTA  => Yii::t('app', 'Minn.'),
            self::MISSISSIPPI  => Yii::t('app', 'Miss.'),
            self::MISSOURI  => Yii::t('app', 'Mo.'),
            self::MONTANA  => Yii::t('app', 'Mont.'),
            self::NEBRASKA  => Yii::t('app', 'Neb.'),
            self::NEVADA  => Yii::t('app', 'Nev.'),
            self::NEW_HAMPSHIRE  => Yii::t('app', 'N.H.'),
            self::NEW_JERSEY  => Yii::t('app', 'N.J.'),
            self::NEW_MEXICO  => Yii::t('app', 'N.M.'),
            self::NEW_YORK  => Yii::t('app', 'N.Y.'),
            self::NORTH_CAROLINA  => Yii::t('app', 'N.C.'),
            self::NORTH_DAKOTA  => Yii::t('app', 'N.D.'),
            self::OHIO  => Yii::t('app', 'Ohio'),
            self::OKLAHOMA  => Yii::t('app', 'Okla.'),
            self::OREGON  => Yii::t('app', 'Ore.'),
            self::PENNSYLVANIA  => Yii::t('app', 'Pa.'),
            self::RHODE_ISLAND  => Yii::t('app', 'R.I.'),
            self::SOUTH_CAROLINA  => Yii::t('app', 'S.C.'),
            self::SOUTH_DAKOTA  => Yii::t('app', 'S.D.'),
            self::TENNESSEE  => Yii::t('app', 'Tenn.'),
            self::TEXAS  => Yii::t('app', 'Texas'),
            self::UTAH  => Yii::t('app', 'Utah'),
            self::VERMONT  => Yii::t('app', 'Vt.'),
            self::VIRGINIA  => Yii::t('app', 'Va.'),
            self::WASHINGTON  => Yii::t('app', 'Wash.'),
            self::WEST_VIRGINIA  => Yii::t('app', 'W.Va.'),
            self::WISCONSIN  => Yii::t('app', 'Wis.'),
            self::WYOMING  => Yii::t('app', 'Wyo.'),
            self::ALBERTA  => Yii::t('app', 'Alta.'),
            self::BRITISH_COLUMBIA  => Yii::t('app', 'B.C.'),
            self::MANITOBA  => Yii::t('app', 'Man.'),
            self::NEW_BRUNSWICK  => Yii::t('app', 'N.B.'),
            self::NEWFOUNDLAND_AND_LABRADOR  => Yii::t('app', 'N.L.*'),
            self::NORTHWEST_TERRITORIES  => Yii::t('app', 'N.W.T.'),
            self::NOVA_SCOTIA  => Yii::t('app', 'N.S.'),
            self::NUNAVUT  => Yii::t('app', 'Nunavut'),
            self::ONTARIO  => Yii::t('app', 'Ont.'),
            self::PRINCE_EDWARD_ISLAND  => Yii::t('app', 'P.E.I.'),
            self::QUEBEC  => Yii::t('app', 'Que.'),
            self::SASKATCHEWAN  => Yii::t('app', 'Sask.'),
            self::YUKON  => Yii::t('app', 'Y.T.'),
        ];
    }

    /**
     * @param string $labelPart index of array from listData()
     * @return string|null index of array from listData()
     */
    public static function idByLabelPart($labelPart)
    {
        if(empty($labelPart)) {
            return null;
        }
        $list = static::listData();
        $ids = array();
        foreach($list as $id => $value) {
            if(stripos($value, $labelPart) === 0) {
                $ids[] = $id;
            }
        }
        if(empty($ids))
            return null;
        else
            return $ids;
    }
}


