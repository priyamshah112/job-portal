<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('countries')->delete();
        $countries = [
            ['id' => 1, 'code' => 'AF', 'name' => "Afghanistan"],
            ['id' => 2, 'code' => 'AL', 'name' => "Albania"],
            ['id' => 3, 'code' => 'DZ', 'name' => "Algeria"],
            ['id' => 4, 'code' => 'AS', 'name' => "American Samoa"],
            ['id' => 5, 'code' => 'AD', 'name' => "Andorra"],
            ['id' => 6, 'code' => 'AO', 'name' => "Angola"],
            ['id' => 7, 'code' => 'AI', 'name' => "Anguilla"],
            ['id' => 8, 'code' => 'AQ', 'name' => "Antarctica"],
            ['id' => 9, 'code' => 'AG', 'name' => "Antigua And Barbuda"],
            ['id' => 10, 'code' => 'AR', 'name' => "Argentina"],
            ['id' => 11, 'code' => 'AM', 'name' => "Armenia"],
            ['id' => 12, 'code' => 'AW', 'name' => "Aruba"],
            ['id' => 13, 'code' => 'AU', 'name' => "Australia"],
            ['id' => 14, 'code' => 'AT', 'name' => "Austria"],
            ['id' => 15, 'code' => 'AZ', 'name' => "Azerbaijan"],
            ['id' => 16, 'code' => 'BS', 'name' => "Bahamas The"],
            ['id' => 17, 'code' => 'BH', 'name' => "Bahrain"],
            ['id' => 18, 'code' => 'BD', 'name' => "Bangladesh"],
            ['id' => 19, 'code' => 'BB', 'name' => "Barbados"],
            ['id' => 20, 'code' => 'BY', 'name' => "Belarus"],
            ['id' => 21, 'code' => 'BE', 'name' => "Belgium"],
            ['id' => 22, 'code' => 'BZ', 'name' => "Belize"],
            ['id' => 23, 'code' => 'BJ', 'name' => "Benin"],
            ['id' => 24, 'code' => 'BM', 'name' => "Bermuda"],
            ['id' => 25, 'code' => 'BT', 'name' => "Bhutan"],
            ['id' => 26, 'code' => 'BO', 'name' => "Bolivia"],
            ['id' => 27, 'code' => 'BA', 'name' => "Bosnia and Herzegovina"],
            ['id' => 28, 'code' => 'BW', 'name' => "Botswana"],
            ['id' => 29, 'code' => 'BV', 'name' => "Bouvet Island"],
            ['id' => 30, 'code' => 'BR', 'name' => "Brazil"],
            ['id' => 31, 'code' => 'IO', 'name' => "British Indian Ocean Territory"],
            ['id' => 32, 'code' => 'BN', 'name' => "Brunei"],
            ['id' => 33, 'code' => 'BG', 'name' => "Bulgaria"],
            ['id' => 34, 'code' => 'BF', 'name' => "Burkina Faso"],
            ['id' => 35, 'code' => 'BI', 'name' => "Burundi"],
            ['id' => 36, 'code' => 'KH', 'name' => "Cambodia"],
            ['id' => 37, 'code' => 'CM', 'name' => "Cameroon"],
            ['id' => 38, 'code' => 'CA', 'name' => "Canada"],
            ['id' => 39, 'code' => 'CV', 'name' => "Cape Verde"],
            ['id' => 40, 'code' => 'KY', 'name' => "Cayman Islands"],
            ['id' => 41, 'code' => 'CF', 'name' => "Central African Republic"],
            ['id' => 42, 'code' => 'TD', 'name' => "Chad"],
            ['id' => 43, 'code' => 'CL', 'name' => "Chile"],
            ['id' => 44, 'code' => 'CN', 'name' => "China"],
            ['id' => 45, 'code' => 'CX', 'name' => "Christmas Island"],
            ['id' => 46, 'code' => 'CC', 'name' => "Cocos (Keeling) Islands"],
            ['id' => 47, 'code' => 'CO', 'name' => "Colombia"],
            ['id' => 48, 'code' => 'KM', 'name' => "Comoros"],
            ['id' => 49, 'code' => 'CG', 'name' => "Congo"],
            ['id' => 50, 'code' => 'CD', 'name' => "Congo The Democratic Republic Of The"],
            ['id' => 51, 'code' => 'CK', 'name' => "Cook Islands"],
            ['id' => 52, 'code' => 'CR', 'name' => "Costa Rica"],
            ['id' => 53, 'code' => 'CI', 'name' => "Cote D Ivoire (Ivory Coast)"],
            ['id' => 54, 'code' => 'HR', 'name' => "Croatia (Hrvatska)"],
            ['id' => 55, 'code' => 'CU', 'name' => "Cuba"],
            ['id' => 56, 'code' => 'CY', 'name' => "Cyprus"],
            ['id' => 57, 'code' => 'CZ', 'name' => "Czech Republic"],
            ['id' => 58, 'code' => 'DK', 'name' => "Denmark"],
            ['id' => 59, 'code' => 'DJ', 'name' => "Djibouti"],
            ['id' => 60, 'code' => 'DM', 'name' => "Dominica"],
            ['id' => 61, 'code' => 'DO', 'name' => "Dominican Republic"],
            ['id' => 62, 'code' => 'TP', 'name' => "East Timor"],
            ['id' => 63, 'code' => 'EC', 'name' => "Ecuador"],
            ['id' => 64, 'code' => 'EG', 'name' => "Egypt"],
            ['id' => 65, 'code' => 'SV', 'name' => "El Salvador"],
            ['id' => 66, 'code' => 'GQ', 'name' => "Equatorial Guinea"],
            ['id' => 67, 'code' => 'ER', 'name' => "Eritrea"],
            ['id' => 68, 'code' => 'EE', 'name' => "Estonia"],
            ['id' => 69, 'code' => 'ET', 'name' => "Ethiopia"],
            ['id' => 70, 'code' => 'XA', 'name' => "External Territories of Australia"],
            ['id' => 71, 'code' => 'FK', 'name' => "Falkland Islands"],
            ['id' => 72, 'code' => 'FO', 'name' => "Faroe Islands"],
            ['id' => 73, 'code' => 'FJ', 'name' => "Fiji Islands"],
            ['id' => 74, 'code' => 'FI', 'name' => "Finland"],
            ['id' => 75, 'code' => 'FR', 'name' => "France"],
            ['id' => 76, 'code' => 'GF', 'name' => "French Guiana"],
            ['id' => 77, 'code' => 'PF', 'name' => "French Polynesia"],
            ['id' => 78, 'code' => 'TF', 'name' => "French Southern Territories"],
            ['id' => 79, 'code' => 'GA', 'name' => "Gabon"],
            ['id' => 80, 'code' => 'GM', 'name' => "Gambia The"],
            ['id' => 81, 'code' => 'GE', 'name' => "Georgia"],
            ['id' => 82, 'code' => 'DE', 'name' => "Germany"],
            ['id' => 83, 'code' => 'GH', 'name' => "Ghana"],
            ['id' => 84, 'code' => 'GI', 'name' => "Gibraltar"],
            ['id' => 85, 'code' => 'GR', 'name' => "Greece"],
            ['id' => 86, 'code' => 'GL', 'name' => "Greenland"],
            ['id' => 87, 'code' => 'GD', 'name' => "Grenada"],
            ['id' => 88, 'code' => 'GP', 'name' => "Guadeloupe"],
            ['id' => 89, 'code' => 'GU', 'name' => "Guam"],
            ['id' => 90, 'code' => 'GT', 'name' => "Guatemala"],
            ['id' => 91, 'code' => 'XU', 'name' => "Guernsey and Alderney"],
            ['id' => 92, 'code' => 'GN', 'name' => "Guinea"],
            ['id' => 93, 'code' => 'GW', 'name' => "Guinea-Bissau"],
            ['id' => 94, 'code' => 'GY', 'name' => "Guyana"],
            ['id' => 95, 'code' => 'HT', 'name' => "Haiti"],
            ['id' => 96, 'code' => 'HM', 'name' => "Heard and McDonald Islands"],
            ['id' => 97, 'code' => 'HN', 'name' => "Honduras"],
            ['id' => 98, 'code' => 'HK', 'name' => "Hong Kong S.A.R."],
            ['id' => 99, 'code' => 'HU', 'name' => "Hungary"],
            ['id' => 100, 'code' => 'IS', 'name' => "Iceland"],
            ['id' => 101, 'code' => 'IN', 'name' => "India"],
            ['id' => 102, 'code' => 'ID', 'name' => "Indonesia"],
            ['id' => 103, 'code' => 'IR', 'name' => "Iran"],
            ['id' => 104, 'code' => 'IQ', 'name' => "Iraq"],
            ['id' => 105, 'code' => 'IE', 'name' => "Ireland"],
            ['id' => 106, 'code' => 'IL', 'name' => "Israel"],
            ['id' => 107, 'code' => 'IT', 'name' => "Italy"],
            ['id' => 108, 'code' => 'JM', 'name' => "Jamaica"],
            ['id' => 109, 'code' => 'JP', 'name' => "Japan"],
            ['id' => 110, 'code' => 'XJ', 'name' => "Jersey"],
            ['id' => 111, 'code' => 'JO', 'name' => "Jordan"],
            ['id' => 112, 'code' => 'KZ', 'name' => "Kazakhstan"],
            ['id' => 113, 'code' => 'KE', 'name' => "Kenya"],
            ['id' => 114, 'code' => 'KI', 'name' => "Kiribati"],
            ['id' => 115, 'code' => 'KP', 'name' => "Korea North"],
            ['id' => 116, 'code' => 'KR', 'name' => "Korea South"],
            ['id' => 117, 'code' => 'KW', 'name' => "Kuwait"],
            ['id' => 118, 'code' => 'KG', 'name' => "Kyrgyzstan"],
            ['id' => 119, 'code' => 'LA', 'name' => "Laos"],
            ['id' => 120, 'code' => 'LV', 'name' => "Latvia"],
            ['id' => 121, 'code' => 'LB', 'name' => "Lebanon"],
            ['id' => 122, 'code' => 'LS', 'name' => "Lesotho"],
            ['id' => 123, 'code' => 'LR', 'name' => "Liberia"],
            ['id' => 124, 'code' => 'LY', 'name' => "Libya"],
            ['id' => 125, 'code' => 'LI', 'name' => "Liechtenstein"],
            ['id' => 126, 'code' => 'LT', 'name' => "Lithuania"],
            ['id' => 127, 'code' => 'LU', 'name' => "Luxembourg"],
            ['id' => 128, 'code' => 'MO', 'name' => "Macau S.A.R."],
            ['id' => 129, 'code' => 'MK', 'name' => "Macedonia"],
            ['id' => 130, 'code' => 'MG', 'name' => "Madagascar"],
            ['id' => 131, 'code' => 'MW', 'name' => "Malawi"],
            ['id' => 132, 'code' => 'MY', 'name' => "Malaysia"],
            ['id' => 133, 'code' => 'MV', 'name' => "Maldives"],
            ['id' => 134, 'code' => 'ML', 'name' => "Mali"],
            ['id' => 135, 'code' => 'MT', 'name' => "Malta"],
            ['id' => 136, 'code' => 'XM', 'name' => "Man (Isle of)"],
            ['id' => 137, 'code' => 'MH', 'name' => "Marshall Islands"],
            ['id' => 138, 'code' => 'MQ', 'name' => "Martinique"],
            ['id' => 139, 'code' => 'MR', 'name' => "Mauritania"],
            ['id' => 140, 'code' => 'MU', 'name' => "Mauritius"],
            ['id' => 141, 'code' => 'YT', 'name' => "Mayotte"],
            ['id' => 142, 'code' => 'MX', 'name' => "Mexico"],
            ['id' => 143, 'code' => 'FM', 'name' => "Micronesia"],
            ['id' => 144, 'code' => 'MD', 'name' => "Moldova"],
            ['id' => 145, 'code' => 'MC', 'name' => "Monaco"],
            ['id' => 146, 'code' => 'MN', 'name' => "Mongolia"],
            ['id' => 147, 'code' => 'MS', 'name' => "Montserrat"],
            ['id' => 148, 'code' => 'MA', 'name' => "Morocco"],
            ['id' => 149, 'code' => 'MZ', 'name' => "Mozambique"],
            ['id' => 150, 'code' => 'MM', 'name' => "Myanmar"],
            ['id' => 151, 'code' => 'NA', 'name' => "Namibia"],
            ['id' => 152, 'code' => 'NR', 'name' => "Nauru"],
            ['id' => 153, 'code' => 'NP', 'name' => "Nepal"],
            ['id' => 154, 'code' => 'AN', 'name' => "Netherlands Antilles"],
            ['id' => 155, 'code' => 'NL', 'name' => "Netherlands The"],
            ['id' => 156, 'code' => 'NC', 'name' => "New Caledonia"],
            ['id' => 157, 'code' => 'NZ', 'name' => "New Zealand"],
            ['id' => 158, 'code' => 'NI', 'name' => "Nicaragua"],
            ['id' => 159, 'code' => 'NE', 'name' => "Niger"],
            ['id' => 160, 'code' => 'NG', 'name' => "Nigeria"],
            ['id' => 161, 'code' => 'NU', 'name' => "Niue"],
            ['id' => 162, 'code' => 'NF', 'name' => "Norfolk Island"],
            ['id' => 163, 'code' => 'MP', 'name' => "Northern Mariana Islands"],
            ['id' => 164, 'code' => 'NO', 'name' => "Norway"],
            ['id' => 165, 'code' => 'OM', 'name' => "Oman"],
            ['id' => 166, 'code' => 'PK', 'name' => "Pakistan"],
            ['id' => 167, 'code' => 'PW', 'name' => "Palau"],
            ['id' => 168, 'code' => 'PS', 'name' => "Palestinian Territory Occupied"],
            ['id' => 169, 'code' => 'PA', 'name' => "Panama"],
            ['id' => 170, 'code' => 'PG', 'name' => "Papua new Guinea"],
            ['id' => 171, 'code' => 'PY', 'name' => "Paraguay"],
            ['id' => 172, 'code' => 'PE', 'name' => "Peru"],
            ['id' => 173, 'code' => 'PH', 'name' => "Philippines"],
            ['id' => 174, 'code' => 'PN', 'name' => "Pitcairn Island"],
            ['id' => 175, 'code' => 'PL', 'name' => "Poland"],
            ['id' => 176, 'code' => 'PT', 'name' => "Portugal"],
            ['id' => 177, 'code' => 'PR', 'name' => "Puerto Rico"],
            ['id' => 178, 'code' => 'QA', 'name' => "Qatar"],
            ['id' => 179, 'code' => 'RE', 'name' => "Reunion"],
            ['id' => 180, 'code' => 'RO', 'name' => "Romania"],
            ['id' => 181, 'code' => 'RU', 'name' => "Russia"],
            ['id' => 182, 'code' => 'RW', 'name' => "Rwanda"],
            ['id' => 183, 'code' => 'SH', 'name' => "Saint Helena"],
            ['id' => 184, 'code' => 'KN', 'name' => "Saint Kitts And Nevis"],
            ['id' => 185, 'code' => 'LC', 'name' => "Saint Lucia"],
            ['id' => 186, 'code' => 'PM', 'name' => "Saint Pierre and Miquelon"],
            ['id' => 187, 'code' => 'VC', 'name' => "Saint Vincent And The Grenadines"],
            ['id' => 188, 'code' => 'WS', 'name' => "Samoa"],
            ['id' => 189, 'code' => 'SM', 'name' => "San Marino"],
            ['id' => 190, 'code' => 'ST', 'name' => "Sao Tome and Principe"],
            ['id' => 191, 'code' => 'SA', 'name' => "Saudi Arabia"],
            ['id' => 192, 'code' => 'SN', 'name' => "Senegal"],
            ['id' => 193, 'code' => 'RS', 'name' => "Serbia"],
            ['id' => 194, 'code' => 'SC', 'name' => "Seychelles"],
            ['id' => 195, 'code' => 'SL', 'name' => "Sierra Leone"],
            ['id' => 196, 'code' => 'SG', 'name' => "Singapore"],
            ['id' => 197, 'code' => 'SK', 'name' => "Slovakia"],
            ['id' => 198, 'code' => 'SI', 'name' => "Slovenia"],
            ['id' => 199, 'code' => 'XG', 'name' => "Smaller Territories of the UK"],
            ['id' => 200, 'code' => 'SB', 'name' => "Solomon Islands"],
            ['id' => 201, 'code' => 'SO', 'name' => "Somalia"],
            ['id' => 202, 'code' => 'ZA', 'name' => "South Africa"],
            ['id' => 203, 'code' => 'GS', 'name' => "South Georgia"],
            ['id' => 204, 'code' => 'SS', 'name' => "South Sudan"],
            ['id' => 205, 'code' => 'ES', 'name' => "Spain"],
            ['id' => 206, 'code' => 'LK', 'name' => "Sri Lanka"],
            ['id' => 207, 'code' => 'SD', 'name' => "Sudan"],
            ['id' => 208, 'code' => 'SR', 'name' => "Suriname"],
            ['id' => 209, 'code' => 'SJ', 'name' => "Svalbard And Jan Mayen Islands"],
            ['id' => 210, 'code' => 'SZ', 'name' => "Swaziland"],
            ['id' => 211, 'code' => 'SE', 'name' => "Sweden"],
            ['id' => 212, 'code' => 'CH', 'name' => "Switzerland"],
            ['id' => 213, 'code' => 'SY', 'name' => "Syria"],
            ['id' => 214, 'code' => 'TW', 'name' => "Taiwan"],
            ['id' => 215, 'code' => 'TJ', 'name' => "Tajikistan"],
            ['id' => 216, 'code' => 'TZ', 'name' => "Tanzania"],
            ['id' => 217, 'code' => 'TH', 'name' => "Thailand"],
            ['id' => 218, 'code' => 'TG', 'name' => "Togo"],
            ['id' => 219, 'code' => 'TK', 'name' => "Tokelau"],
            ['id' => 220, 'code' => 'TO', 'name' => "Tonga"],
            ['id' => 221, 'code' => 'TT', 'name' => "Trinidad And Tobago"],
            ['id' => 222, 'code' => 'TN', 'name' => "Tunisia"],
            ['id' => 223, 'code' => 'TR', 'name' => "Turkey"],
            ['id' => 224, 'code' => 'TM', 'name' => "Turkmenistan"],
            ['id' => 225, 'code' => 'TC', 'name' => "Turks And Caicos Islands"],
            ['id' => 226, 'code' => 'TV', 'name' => "Tuvalu"],
            ['id' => 227, 'code' => 'UG', 'name' => "Uganda"],
            ['id' => 228, 'code' => 'UA', 'name' => "Ukraine"],
            ['id' => 229, 'code' => 'AE', 'name' => "United Arab Emirates"],
            ['id' => 230, 'code' => 'GB', 'name' => "United Kingdom"],
            ['id' => 231, 'code' => 'US', 'name' => "United States"],
            ['id' => 232, 'code' => 'UM', 'name' => "United States Minor Outlying Islands"],
            ['id' => 233, 'code' => 'UY', 'name' => "Uruguay"],
            ['id' => 234, 'code' => 'UZ', 'name' => "Uzbekistan"],
            ['id' => 235, 'code' => 'VU', 'name' => "Vanuatu"],
            ['id' => 236, 'code' => 'VA', 'name' => "Vatican City State (Holy See)"],
            ['id' => 237, 'code' => 'VE', 'name' => "Venezuela"],
            ['id' => 238, 'code' => 'VN', 'name' => "Vietnam"],
            ['id' => 239, 'code' => 'VG', 'name' => "Virgin Islands (British)"],
            ['id' => 240, 'code' => 'VI', 'name' => "Virgin Islands (US)"],
            ['id' => 241, 'code' => 'WF', 'name' => "Wallis And Futuna Islands"],
            ['id' => 242, 'code' => 'EH', 'name' => "Western Sahara"],
            ['id' => 243, 'code' => 'YE', 'name' => "Yemen"],
            ['id' => 244, 'code' => 'YU', 'name' => "Yugoslavia"],
            ['id' => 245, 'code' => 'ZM', 'name' => "Zambia"],
            ['id' => 246, 'code' => 'ZW', 'name' => "Zimbabwe"],
        ];
        DB::table('countries')->insert($countries);
    }
}
