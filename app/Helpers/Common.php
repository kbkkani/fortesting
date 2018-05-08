<?php
/**
 * Created by PhpStorm.
 * User: Prathiba
 * Date: 1/14/2018
 * Time: 12:23 AM
 */

namespace App\Helpers;
use Config;

class Common
{
    public static function curl_conn($url, $post_fields = array(), $axtoken = false){
            // Connection settings
//        AXL_API_Token = "D4E9A85F-C343-43A4-9586409C185B6ADF"
            $api_token    = "D4E9A85F-C343-43A4-9586409C185B6ADF";   // AXL_API_Token

            if(isset($axtoken) && $axtoken != ""){
                $ws_token = $axtoken;
                $token_type = "axtoken";
            } else {
                $token_type = "wstoken";
                $ws_token = "731D225A-2150-46FF-B7592205B2B79574";  // AXL_WS_Token
            }
//            $api_url      = "https://admin.axcelerate.com.au/api/"; // AXL_API_URL;
            $api_url = "https://stg.axcelerate.com.au/api/";

            $options = array(
                CURLOPT_HTTPHEADER => array("apitoken: $api_token", "$token_type: $ws_token"),
                CURLOPT_HEADER => false,
                CURLOPT_URL => $api_url.$url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_ENCODING => '',
            );

            // Check is POST Fields set
            $fields_string = "";
            if(count($post_fields) > 0) {

                $fields_string = "";
                foreach($post_fields as $key=>$value) {
                    if($value != "") {
                        $fields_string .= $key.'='.$value.'&';
                    }

                }
                rtrim($fields_string, '&');


                // CURLOPT_HTTPHEADER => array("apitoken: $api_token", "wstoken: $ws_token", "Accept: */*", "Content-Type: application/json;charset=utf-8", "Accept-Language: en-US,en;q=0.8"),
                $options =	array(
                    CURLOPT_HTTPHEADER => array("apitoken: $api_token", "wstoken: $ws_token"),
                    CURLOPT_HEADER =>  false,
                    CURLOPT_URL => $api_url.$url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_ENCODING => '',
                    CURLOPT_POST => count($post_fields),
                    CURLOPT_POSTFIELDS => $fields_string
                );

            }

            $feed = curl_init();
            curl_setopt_array($feed, $options);
            $response = curl_exec($feed);

            curl_close($feed);

            try {
                return $response;
            } catch (Exception $e){
                $date = date('d/m/Y H:i:s');
                $response = json_decode($response);
                error_log("date: $date, message: $response->ErrorMessage, method: $url \r\n", 3, ERROR_LOG_FILE);
                return json_encode(array("error" => "An issue has occurred, please try again. $response->ErrorMessage"));
            }

        }

    public static function curl_conn_put($url, $post_fields = array()){
        // Connection settings
        $api_token    = Config::get('lvs.AXL_API_Token');

        if(isset($axtoken) && $axtoken != ""){
            $ws_token = $axtoken;
            $token_type = "axtoken";
        } else {
            $token_type = "wstoken";
            $ws_token = Config::get('lvs.AXL_WS_Token');
        }
        $api_url      = "https://stg.axcelerate.com.au/api/";

        $options = array(
            CURLOPT_HTTPHEADER => array("apitoken: $api_token", "wstoken: $ws_token"),
            CURLOPT_HEADER => false,
            CURLOPT_URL => $api_url.$url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_ENCODING => '',
        );

        // Check is POST Fields set
        $fields_string = "";
        if(count($post_fields) > 0) {
            $fields_string = "";
            foreach($post_fields as $key=>$value) {
                $fields_string .= $key.'='.$value.'&';
            }
            rtrim($fields_string, '&');

            // CURLOPT_HTTPHEADER => array("apitoken: $api_token", "wstoken: $ws_token", "Accept: */*", "Content-Type: application/json;charset=utf-8", "Accept-Language: en-US,en;q=0.8"),
            $options =	array(
                CURLOPT_HTTPHEADER => array("apitoken: $api_token", "wstoken: $ws_token"),
                CURLOPT_HEADER =>  false,
                CURLOPT_URL => $api_url.$url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_ENCODING => '',
                CURLOPT_CUSTOMREQUEST => "PUT",
                CURLOPT_POSTFIELDS => $fields_string
            );
        }

        $feed = curl_init();
        curl_setopt_array($feed, $options);
        $response = curl_exec($feed);

        curl_close($feed);

        try {
            return $response;
        } catch (Exception $e){
            $date = date('d/m/Y H:i:s');
            $response = json_decode($response);
            error_log("date: $date, message: $response->ErrorMessage, method: $url \r\n", 3, Config::get('lvs.ERROR_LOG_FILE'));
            return json_encode(array("error" => "An issue has occurred, please try again. $response->ErrorMessage"));
        }
    }

    public static function languages(){
        $languages = array(1101 => "Gaelic (Scotland)", 1102 => "Irish",1103=> "Welsh",1199=>"Celtic, nec",1201 => "English",1301 => "German",
        1302 => "Letzeburgish", 1303=>"Yiddish",1401=> "Dutch","1402"=>"Frisian",1403=>"Afrikaans",1501=>"Danish",1502=>"Icelandic",
            1503=>"Norwegian", 1504=>"Swedish", 1599=>"Scandinavian, nec", 1601 => "Estonian", 1602 => "Finnish",  1699=> "Finnish and Related Languages, nec",
            2101=>"French", 2201=>"Greek", 2301=>"Catalan", 2302=>"Portuguese", 2303=>"Spanish",2399=>"Iberian Romance, nec",2401=>"Italian",
            2501=>"Maltese", 2901=>"Basque", 2902=>"Latin", 2999=>"Other Southern European Languages, nec",3101=>"Latvian", 3102=>"Lithuanian", 3301=>"Hungarian",
            3401=>"Belorussian", 3402=>"Russian",3403=>"Ukrainian",3501=>"Bosnian",3502=>"Bulgarian",3503=>"Croatian",3504=>"Macedonian",3505=>"Serbian",
            3506=>"Slovene",3507=>"Serbo-Croatian/Yugoslavian, so described",3601=>"Czech",3602=>"Polish",3603=>"Slovak",3604=>"Czechoslovakian, so described",
            3901=>"Albanian",3903=>"Aromunian (Macedo-Romanian)",3904=>"Romanian",3905=>"Romany",3999=>"Other Eastern European Languages, nec",
            4101=>"Kurdish",4102=>"Pashto",4104=>"Balochi", 4105=>"Dari", 4106=>"Persian (excluding Dari)",
            4107=>"Hazaraghi", 4199=>"Iranic, nec",4202=>"Arabic", 4204=>"Hebrew", 4206=>"Assyrian Neo-Aramaic", 4207=>"Chaldean Neo-Aramaic",
            4208=>"Mandaean (Mandaic)", 4299=>"Middle Eastern Semitic Languages, nec",4301=>"Turkish",4302=>"Azeri", 4303=>"Tatar",
            4304=>"Turkmen", 4305=>"Uygur",4306=>"Uzbek", 4399=>"Turkic, nec",4901=>"Armenian",4902=>"Georgian",4999=>"Other Southwest and Central Asian Languages, nec",
            5101=>"Kannada", 5102=>"Malayalam",5103=>"Tamil",5104=>"Telugu",5105=>"Tulu",5199=>"Dravidian, nec",5201=>"Bengali",5202=>"Gujarati",            5203=>"Hindi",            5204=>"Konkani",
            5205=>"Marathi",5206=>"Nepali",5207=>"Punjabi", 5208=>"Sindhi",5211=>"Sinhalese",5212=>"Urdu", 5213=>"Assamese", 5214=>"Dhivehi",            5215=>"Kashmiri",            5216=>"Oriya",
            5217=>"Fijian Hindustani",5299=>"Indo-Aryan, nec", 5999=>"Other Southern Asian Languages",6101=>"Burmese", 6102=>"Chin Haka", 6103=>"Karen", 6104=>"Rohingya",6199=>"Burmese and Related Languages, nec",
            6201=>"Hmong",6299=>"Hmong-Mien, nec", 6301=>"Khmer", 6302=>"Vietnamese",6303=>"Mon",6399=>"Mon-Khmer, nec",6401=>"Lao",6402=>"Thai",6499=>"Tai, nec",6501=>"Bisaya",            6502=>"Cebuano",6503=>"IIokano", 6504=>"Indonesian",6505=>"Malay",6507=>"Tetum", 6508=>"Timorese",6511=>"Tagalog",6512=>"Filipino", 6513=>"Acehnese", 6514=>"Balinese", 6515=>"Bikol",
            6516=>"Iban",6517=>"Ilonggo (Hiligaynon)",6518=>"Javanese",6521=>"Pampangan",6599=>"Southeast Asian Austronesian Languages, nec",6999=>"Other Southeast Asian Languages",
            7101=>"Cantonese",7102=>"Hakka",7104=>"Mandarin",7106=>"Wu", 7107=>"Min Nan",7199=>"Chinese, nec",7201=>"Japanese",
            7301=>"Korean", 7901=>"Tibetan",7902=>"Mongolian",7999=>"Other Eastern Asian Languages, nec", 8101=>"Anindilyakwa",
            8111=>"Maung",8113=>"Ngan'gikurunggurr",8114=>"Nunggubuyu",8115=>"Rembarrnga", 8117=>"Tiwi",8121=>"Alawa",8122=>"Dalabon",
            8123=>"Gudanji", 8127=>"Iwaidja",8128=>"Jaminjung", 8131=>"Jawoyn",8132=>"Jingulu",  8133=>"Kunbarlang",8136=>"Larrakiya",8137=>"Malak Malak", 8138=>"Mangarrayi",
            8141=>"Maringarr", 8142=>"Marra",  8143=>"Marrithiyel", 8144=>"Matngala",
            8146=>"Murrinh Patha",            8147=>"Na-kara",            8148=>"Ndjébbana (Gunavidji)",            8151=>"Ngalakgan",
            8152=>"Ngaliwurru",            8153=>"Nungali",            8154=>"Wambaya",            8155=>"Wardaman",            8156=>"Amurdak",
            8157=>"Garrwa",            8158=>"Kuwema",            8161=>"Marramaninyshi",            8162=>"Ngandi",            8163=>"Waanyi",
            8164=>"Wagiman",            8165=>"Yanyuwa",            8166=>"Marridan (Maridan)",            817 =>" Kunwinjkuan",
            8171=>"Gundjeihmi",            8172=>"Kune",            8173=>"Kuninjku",            8174=>"Kunwinjku",            8175=>"Mayali",
            8179=>"Kunwinjkuan, nec",            818 =>" Burarran",            8181=>"Burarra",            8182=>"Gun-nartpa",
            8183=>"Gurr-goni",            8189=>"Burarran, nec",            8199=>"Arnhem Land and Daly River Region Languages, nec",
            8211=>"Galpu",            8212=>"Golumala",            8213=>"Wangurri",            8219=>"Dhangu, nec",
            8221=>"Dhalwangu",            8222=>"Djarrwark",            8229=>"Dhay'yi, nec",            8231=>"Djambarrpuyngu",            8232=>"Djapu",            8233=>"Daatiwuy",            8234=>"Marrangu",            8235=>"Liyagalawumirr",
            8236=>"Liyagawumirr",            8239=>"Dhuwal, nec",            8242=>"Gumatj",            8243=>"Gupapuyngu",
            8244=>"Guyamirrilili",            8246=>"Manggalili",            8247=>"Wubulkarra",            8249=>"Dhuwala, nec",
            8251=>"Wurlaki",            8259=>"Djinang, nec",            8261=>"Ganalbingu",            8262=>"Djinba",            8263=>"Manyjalpingu",
            8269=>"Djinba, nec",            8271=>"Ritharrngu",            8272=>"Wagilak",            8279=>"Yakuy, nec",            8281=>"Nhangu",
            8282=>"Yan-Nhangu",            8289=>"Nhangu, nec",            8291=>"Dhuwaya",            8292=>"Djangu",
            8293=>"Madarrpa",            8294=>"Warramiri",            8295=>"Rirratjingu",            8299=>"Other Yolngu Matha, nec",
            8301=>"Kuku Yalanji",            8302=>"Guugu Yimidhirr",            8303=>"Kuuku-Ya'u",            8304=>"Wik Mungkan",
            8305=>"Djabugay",            8306=>"Dyirbal",            8307=>"Girramay",            8308=>"Koko-Bera",
            8311=>"Kuuk Thayorre",            8312=>"Lamalama",            8313=>"Yidiny",            8314=>"Wik Ngathan",
            8315=>"Alngith",            8316=>"Kugu Muminh",            8317=>"Morrobalama",            8318=>"Thaynakwith",
            8321=>"Yupangathi",            8322=>"Tjungundji",            8399=>"Cape York Peninsula Languages, nec",
            8401=>"Kalaw Kawaw Ya/Kalaw Lagaw Ya",            8402=>"Meriam Mir",            8403=>"Yumplatok (Torres Strait Creole)",
            8504=>"Bilinarra",            8505=>"Gurindji",            8506=>"Gurindji Kriol",            8507=>"Jaru",
            8508=>"Light Warlpiri",            8511=>"Malngin",            8512=>"Mudburra",
            8514=>"Ngardi",            8515=>"Ngarinyman",            8516=>"Walmajarri",            8517=>"Wanyjirra",
            8518=>"Warlmanpa",            8521=>"Warlpiri",            8522=>"Warumungu",
            8599=>"Northern Desert Fringe Area Languages, nec",            8603=>"Alyawarr",            8606=>"Kaytetye",            8607=>"Antekerrepenh",
            8611=>"Central Anmatyerr",            8612=>"Eastern Anmatyerr",            8619=>"Anmatyerr, nec",            8621=>"Eastern Arrernte",
            8622=>"Western Arrarnta",            8629=>"Arrernte, nec",            8699=>"Arandic, nec",            8703=>"Antikarinya",
            8704=>"Kartujarra",8705=>"Kukatha",8706=>"Kukatja",8707=>"Luritja",8708=>"Manyjilyjarra",
            8711=>"Martu Wangka",8712=>"Ngaanyatjarra",8713=>"Pintupi",8714=>"Pitjantjatjara",
            8715=>"Wangkajunga",8716=>"Wangkatha",8717=>"Warnman",8718=>"Yankunytjatjara",
            8721=>"Yulparija",8722=>"Tjupany",8799=>"Western Desert Language, nec",8801=>"Bardi",
            8802=>"Bunuba",8803=>"Gooniyandi",8804=>"Miriwoong",            8805=>"Ngarinyin",
            8806=>"Nyikina",8807=>"Worla",8808=>"Worrorra",8811=>"Wunambal",8812=>"Yawuru",
            8813=>"Gambera",8814=>"Jawi",8815=>"Kija",8899=>"Kimberley Area Languages, nec",
            8901=>"Adnymathanha",8902=>"Arabana",8903=>"Bandjalang",8904=>"Banyjima",8905=>"Batjala",
            8906=>"Bidjara",8907=>"Dhanggatti",            8908=>"Diyari",            8911=>"Gamilaraay",            8913=>"Garuwali",
            8914=>"Githabul",8915=>"Gumbaynggir",            8916=>"Kanai",            8917=>"Karajarri",            8918=>"Kariyarra",
            8921=>"Kaurna",8922=>"Kayardild",            8924=>"Kriol",            8925=>"Lardil",            8926=>"Mangala",
            8927=>"Muruwari",8928=>"Narungga",            8931=>"Ngarluma",            8932=>"Ngarrindjeri",            8933=>"Nyamal",
            8934=>"Nyangumarta",8935=>"Nyungar",            8936=>"Paakantyi",            8937=>"Palyku/Nyiyaparli",            8938=>"Wajarri",
            8941=>"Wiradjuri",8943=>"Yindjibarndi",            8944=>"Yinhawangka",            8945=>"Yorta Yorta",            8946=>"Baanbay",
            8947=>"Badimaya",8948=>"Barababaraba",            8951=>"Dadi Dadi",            8952=>"Dharawal",            8953=>"Djabwurrung",
            8954=>"Gudjal",8955=>"Keerray-Woorroong",            8956=>"Ladji Ladji",            8957=>"Mirning",            8958=>"Ngatjumaya",
            8961=>"Waluwarra",8962=>"Wangkangurru",            8963=>"Wargamay",8964=>"Wergaia", 8998=>"Aboriginal English, so described", 8999=>"Other Australian Indigenous Languages, nec",9101=>"American Languages", 9201=>"Acholi",
            9203=>"Akan", 9205=>"Mauritian Creole", 9206=>"Oromo",9207=>"Shona",9208=>"Somali",  9211=>"Swahili",9212=>"Yoruba", 9213=>"Zulu",
            9214=>"Amharic", 9215=>"Bemba",9216=>"Dinka",9217=>"Ewe",9218=>"Ga", 9221=>"Harari", 9222=>"Hausa", 9223=>"Igbo",
            9224=>"Kikuyu", 9225=>"Krio", 9226=>"Luganda",  9227=>"Luo",9228=>"Ndebele", 9231=>"Nuer",9232=>"Nyanja (Chichewa)",
            9233=>"Shilluk",9234=>"Tigré",9235=>"Tigrinya", 9236=>"Tswana", 9237=>"Xhosa",9238=>"Seychelles Creole",9241=>"Anuak",9242=>"Bari",9243=>"Bassa", 9244=>"Dan (Gio-Dan)",
            9245=>"Fulfulde", 9246=>"Kinyarwanda (Rwanda)",9247=>"Kirundi (Rundi)",9248=>"Kpelle", 9251=>"Krahn",
            9252=>"Liberian (Liberian English)",9253=>"Loma (Lorma)",9254=>"Lumun (Kuku Lumun)",9255=>"Madi",9256=>"Mandinka",
            9257=>"Mann", 9258=>"Moro (Nuba Moro)",9261=>"Themne",9299=>"African Languages, nec",9301=>"Fijian",9302=>"Gilbertese",
            9303=>"Maori (Cook Island)",9304=>"Maori (New Zealand)",9306=>"Nauruan",9307=>"Niue",9308=>"Samoan",9311=>"Tongan",
            9312=>"Rotuman",9313=>"Tokelauan",9314=>"Tuvaluan",9315=>"Yapese",9399=>"Pacific Austronesian Languages, nec",
            9402=>"Bislama",9403=>"Hawaiian English",9404=>"Pitcairnese",9405=>"Solomon Islands Pijin",9499=>"Oceanian Pidgins and Creoles, nec",
            9502=>"Kiwai",9503=>"Motu (HiriMotu)",9504=>"Tok Pisin (Neomelanesian)",9599=>"Papua New Guinea Languages, nec",9601=>"Invented Languages",
            9701=>"Auslan",9702=>"Makaton",9799=>"Sign Languages, nec"
        );
        return $languages;
    }

    public static function countries(){
        $countries = array("1102" =>"Norfolk Island","1199" =>"Australian External Territories, nec","1201" =>"New Zealand",
            "1301" =>"New Caledonia","1302" =>"Papua New Guinea","1303" =>"Solomon Islands","1304" =>"Vanuatu","1401" =>"Guam",
            "1402" =>"Kiribati","1403" =>"Marshall Islands","1404" =>"Micronesia, Federated States of","1405" =>"Nauru",
            "1406" =>"Northern Mariana Islands","1407" =>"Palau","1501" =>"Cook Islands","1502" =>"Fiji","1503" =>"French Polynesia",
            "1504" =>"Niue","1505" =>"Samoa","1506" =>"Samoa, American","1507" =>"Tokelau","1508" =>"Tonga","1511" =>"Tuvalu",
            "1512" =>"Wallis and Futuna","1513" =>"Pitcairn Islands","1599" =>"Polynesia (excludes Hawaii), nec","1601" =>"Adelie Land (France)",
            "1602" =>"Argentinian Antarctic Territory","1603" =>"Australian Antarctic Territory","1604" =>"British Antarctic Territory",
            "1605" =>"Chilean Antarctic Territory","1606" =>"Queen Maud Land (Norway)","1607" =>"Ross Dependency (New Zealand)","2102" =>"England",
            "2103" =>"Isle of Man","2104" =>"Northern Ireland","2105" =>"Scotland","2106" =>"Wales","2107" =>"Guernsey","2108" =>"Jersey",
            "2201" =>"Ireland","2301" =>"Austria","2302" =>"Belgium","2303" =>"France","2304" =>"Germany","2305" =>"Liechtenstein",
            "2306" =>"Luxembourg","2307" =>"Monaco","2308" =>"Netherlands","2311" =>"Switzerland","2401" =>"Denmark","2402" =>"Faroe Islands",
            "2403" =>"Finland","2404" =>"Greenland","2405" =>"Iceland","2406" =>"Norway","2407" =>"Sweden","2408" =>"Aland Islands",
            "3101" =>"Andorra","3102" =>"Gibraltar","3103" =>"Holy See","3104" =>"Italy","3105" =>"Malta","3106" =>"Portugal","3107" =>"San Marino",
            "3108" =>"Spain","3201" =>"Albania","3202" =>"Bosnia and Herzegovina","3203" =>"Bulgaria","3204" =>"Croatia","3205" =>"Cyprus",
            "3206" =>"Former Yugoslav Republic of Macedonia (FYROM)","3207" =>"Greece","3208" =>"Moldova","3211" =>"Romania","3212" =>"Slovenia",
            "3214" =>"Montenegro","3215" =>"Serbia","3216" =>"Kosovo","3301" =>"Belarus","3302" =>"Czech Republic","3303" =>"Estonia",
            "3304" =>"Hungary","3305" =>"Latvia","3306" =>"Lithuania","3307" =>"Poland","3308" =>"Russian Federation","3311" =>"Slovakia",
            "3312" =>"Ukraine","4101" =>"Algeria","4102" =>"Egypt","4103" =>"Libya","4104" =>"Morocco","4105" =>"Sudan","4106" =>"Tunisia",
            "4107" =>"Western Sahara","4108" =>"Spanish North Africa","4111" =>"South Sudan","4201" =>"Bahrain","4202" =>"Gaza Strip and West Bank",
            "4203" =>"Iran","4204" =>"Iraq","4205" =>"Israel","4206" =>"Jordan","4207" =>"Kuwait","4208" =>"Lebanon","4211" =>"Oman",
            "4212" =>"Qatar","4213" =>"Saudi Arabia","4214" =>"Syria","4215" =>"Turkey","4216" =>"United Arab Emirates","4217" =>"Yemen",
            "5101" =>"Myanmar, The Republic of the Union of ","5102" =>"Cambodia","5103" =>"Laos","5104" =>"Thailand","5105" =>"Vietnam",
            "5201" =>"Brunei Darussalam","5202" =>"Indonesia","5203" =>"Malaysia","5204" =>"Philippines","5205" =>"Singapore",
            "5206" =>"Timor-Leste","6101" =>"China (excludes SARs and Taiwan) ","6102" =>"Hong Kong (SAR of China)",
            "6103" =>"Macau (SAR of China)","6104" =>"Mongolia","6105" =>"Taiwan ","6201" =>"Japan",
            "6202" =>"Korea, Democratic People's Republic of (North)","6203" =>"Korea, Republic of (South)","7101" =>"Bangladesh",
            "7102" =>"Bhutan","7103" =>"India","7104" =>"Maldives","7105" =>"Nepal","7106" =>"Pakistan","7107" =>"Sri Lanka",
            "7201" =>"Afghanistan","7202" =>"Armenia","7203" =>"Azerbaijan","7204" =>"Georgia","7205" =>"Kazakhstan","7206" =>"Kyrgyzstan",
            "7207" =>"Tajikistan","7208" =>"Turkmenistan","7211" =>"Uzbekistan","8101" =>"Bermuda","8102" =>"Canada",
            "8103" =>"St Pierre and Miquelon","8104" =>"United States of America","8201" =>"Argentina","8202" =>"Bolivia, Plurinational State of",
            "8203" =>"Brazil","8204" =>"Chile","8205" =>"Colombia","8206" =>"Ecuador","8207" =>"Falkland Islands","8208" =>"French Guiana",
            "8211" =>"Guyana","8212" =>"Paraguay","8213" =>"Peru","8214" =>"Suriname","8215" =>"Uruguay",
            "8216" =>"Venezuela, Bolivarian Republic of","8299" =>"South America, nec","8301" =>"Belize","8302" =>"Costa Rica",
            "8303" =>"El Salvador","8304" =>"Guatemala","8305" =>"Honduras","8306" =>"Mexico","8307" =>"Nicaragua","8308" =>"Panama",
            "8401" =>"Anguilla","8402" =>"Antigua and Barbuda","8403" =>"Aruba","8404" =>"Bahamas","8405" =>"Barbados","8406" =>"Cayman Islands",
            "8407" =>"Cuba","8408" =>"Dominica","8411" =>"Dominican Republic","8412" =>"Grenada","8413" =>"Guadeloupe","8414" =>"Haiti",
            "8415" =>"Jamaica","8416" =>"Martinique","8417" =>"Montserrat","8421" =>"Puerto Rico","8422" =>"St Kitts and Nevis",
            "8423" =>"St Lucia","8424" =>"St Vincent and the Grenadines","8425" =>"Trinidad and Tobago","8426" =>"Turks and Caicos Islands",
            "8427" =>"Virgin Islands, British ","8428" =>"Virgin Islands, United States","8431" =>"St Barthelemy",
            "8432" =>"St Martin (French part)","8433" =>"Bonaire, Sint Eustatius and Saba","8434" =>"Curacao","8435" =>"Sint Maarten (Dutch part)",
            "9101" =>"Benin","9102" =>"Burkina Faso","9103" =>"Cameroon","9104" =>"Cabo Verde","9105" =>"Central African Republic",
            "9106" =>"Chad","9107" =>"Congo, Republic of","9108" =>"Congo, Democratic Republic of","9111" =>"Cote d'Ivoire",
            "9112" =>"Equatorial Guinea","9113" =>"Gabon","9114" =>"Gambia","9115" =>"Ghana","9116" =>"Guinea","9117" =>"Guinea-Bissau",
            "9118" =>"Liberia","9121" =>"Mali","9122" =>"Mauritania","9123" =>"Niger","9124" =>"Nigeria","9125" =>"Sao Tome and Principe",
            "9126" =>"Senegal","9127" =>"Sierra Leone","9128" =>"Togo","9201" =>"Angola","9202" =>"Botswana","9203" =>"Burundi",
            "9204" =>"Comoros","9205" =>"Djibouti","9206" =>"Eritrea","9207" =>"Ethiopia","9208" =>"Kenya","9211" =>"Lesotho",
            "9212" =>"Madagascar","9213" =>"Malawi","9214" =>"Mauritius","9215" =>"Mayotte","9216" =>"Mozambique","9217" =>"Namibia",
            "9218" =>"Reunion","9221" =>"Rwanda","9222" =>"St Helena","9223" =>"Seychelles","9224" =>"Somalia","9225" =>"South Africa",
            "9226" =>"Swaziland","9227" =>"Tanzania","9228" =>"Uganda","9231" =>"Zambia","9232" =>"Zimbabwe",
            "9299" =>"Southern and East Africa, nec");
        asort($countries);
        return $countries;
    }

    public static function disabilityType(){
        $disability = array(12 => "Physical",11 => "Hearing/Deaf", 13 => "Intellectual", 16 => "Acquired Brain Impairment",
        15=> "Mental Illness", 14=> "Learning",18 => "Medical Condition", 19 => "Other");
        return $disability;
    }

    public static function schools(){
        $schools = array(12 => "Year 12 or equivalent",11 => "Year 11 or equivalent", 10 => "Year 10 or equivalent",
            9 => "Year 9 or equivalent", 8 => "Year 8 or below", 2=> "Did not go to school");
        return $schools;
    }

    public static function education(){
        $education = array("008" => "Bachelor Degree or Higher", "410" => "Advanced Diploma or Associate Degree",
            "420" => "Diploma","511" => "Certificate IV","514" => "Certificate III", "521" => "Certificate II",
            "524" => "Certificate I", "990" => "Certificate other than above");

        return $education;
    }

}