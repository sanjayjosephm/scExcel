


<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$replacePatternArray = array(
    "ETL" => array(
        'ETL' => array(
            'default' => '<i>et al</i>',
        ),
    ),
    "THSE" => array(
        'THSE' => array(
            '$1 contains ^([0-9])([\,]?)([0-9]{3})$' => 'replace_with($1$3)',
            '$1 contains ^([0-9]{2})([\,]?)([0-9]{3})$' => 'replace_with($1&thinsp;$3)',
            '$1 contains ^([0-9]{2})([\,]?)([0-9]{2})([\,]?)([0-9]{3})$' => 'replace_with($1&thinsp;$3&thinsp;$5)',
            '$1 contains ^([0-9])([\,]?)([0-9]{2})([\,]?)([0-9]{3})$' => 'replace_with($1&thinsp;$3&thinsp;$5)',
            '$1 contains ^([0-9]{2})([\,]?)([0-9]{2})([\,]?)([0-9]{2})([\,]?)([0-9]{3})$' => 'replace_with($1&thinsp;$3&thinsp;$5&thinsp;$7)',
            '$1 contains ^([0-9])([\,]?)([0-9]{2})([\,]?)([0-9]{2})([\,]?)([0-9]{3})$' => 'replace_with($1&thinsp;$3&thinsp;$5&thinsp;$7)',
            'default' => 'default',
        ), 
    ),
    "HIGH" => array(
        'HIGH' => array(
                'functionToPerform' => 'addTrackChanges',
                'contains ^after-sales$'=> 'aftersales',
                'contains ^air-flow$'=> 'airflow',
                'contains ^anti-cancer$'=> 'anticancer',
                'contains ^anti-virus$'=> 'antivirus',
                'contains ^audio-visual$'=> 'audiovisual',
                'contains ^by-product$'=> 'byproduct',
                'contains ^cell-phone$'=> 'cellphone',
                'contains ^Dot-com$'=> 'dotcom',
                'contains ^end-point$'=> 'endpoint',
                'contains ^ever-more$'=> 'evermore',
                'contains ^hand-writing$'=> 'handwriting',
                'contains ^hand-written$'=> 'handwritten',
                'contains ^health-care$'=> 'healthcare',
                'contains ^help-desk$'=> 'helpdesk',
                'contains ^immuno-suppressant$'=> 'immunosuppressant',
                'contains ^in-bound$'=> 'inbound',
                'contains ^in-frared$'=> 'infrared',
                'contains ^inter-bank$'=> 'interbank',
                'contains ^inter-dependence$'=> 'interdependence',
                'contains ^inter-operable$'=> 'interoperable',
                'contains ^lap-top$'=> 'laptop',
                'contains ^land-fill$'=> 'landfill',
                'contains ^life-cycle$'=> 'lifecycle',
                'contains ^life-time$'=> 'lifetime',
                'contains ^macro-economic$'=> 'macroeconomic',
                'contains ^market-place$'=> 'marketplace',
                'contains ^multi-dimensional$'=> 'multidimensional',
                'contains ^multi-media$'=> 'multimedia',
                'contains ^multi-national$'=> 'multinational',
                'contains ^on-line$'=> 'online',
                'contains ^out-bound$'=> 'outbound',
                'contains ^out-growth$'=> 'outgrowth',
                'contains ^out-source$'=> 'outsource',
                'contains ^path-way$'=> 'pathway',
                'contains ^post-code$'=> 'postcode',
                'contains ^post-doctoral$'=> 'postdoctoral',
                'contains ^post-war$'=> 'postwar',
                'contains ^power-train$'=> 'powertrain',
                'contains ^pre-clinical$'=> 'preclinical',
                'contains ^pre-diabetes$'=> 'prediabetes',
                'contains ^pro-active$'=> 'proactive',
                'contains ^read-out (n)$'=> 'readout (n)',
                'contains ^re-agent$'=> 'reagent',
                'contains ^re-cycle$'=> 'recycle',
                'contains ^re-print$'=> 'reprint',
                'contains ^roll-out$'=> 'rollout',
                'contains ^set-back$'=> 'setback',
                'contains ^sub-contract$'=> 'subcontract',
                'contains ^through-put$'=> 'throughput',
                'contains ^time-frame$'=> 'timeframe',
                'contains ^time-line$'=> 'timeline',
                'contains ^time-scale$'=> 'timescale',
                'contains ^time-span$'=> 'timespan',
                'contains ^two-fold$'=> 'twofold',
                'contains ^three-fold$'=> 'threefold',
                'contains ^four-fold$'=> 'fourfold',
                'contains ^one-fold$'=> 'onefold',
                'contains ^ultra-violet$'=> 'ultraviolet',
                'contains ^up-sell$'=> 'upsell',
                'contains ^view-point$'=> 'viewpoint',
                'contains ^video-conference$'=> 'videoconference',
                'contains ^waste-water$'=> 'wastewater',
                'contains ^well-being$'=> 'wellbeing',
                'contains ^work-book$'=> 'workbook',
                'contains ^work-force$'=> 'workforce',
                'contains ^world-wide$'=> 'worldwide',
                'contains ^side-effect$'=> 'side effect',
                'contains ^time-out$'=> 'time out',
                'contains ^time-slot$'=> 'time slot',
                'contains ^time-zone$'=> 'time zone',
                'contains ^per cent$'=> 'per cent',
                'contains ^Pythagorean theorem$'=> 'Pythagoras&rsquo; theorem',
                'contains ^pythagorean theorem$'=> 'pythagoras&rsquo; theorem',
                'contains ^&frac14;$'=> 'one-quarter',
                'contains ^¼$'=> 'one-quarter',
                'contains ^&frac12;$'=> 'one-half',
                'contains ^½$'=> 'one-half',
                'contains ^&frac13;$'=> 'one-third',
                'contains ^⅓$'=> 'one-third',
                'contains ^&frac34;$'=> 'three-quarters',
                'contains ^¾$'=> 'three-quarters',
                'contains ^per se$'=> '<i>per se</i>',
                'contains ^a priori$'=> '<i>a priori</i>',
                'contains ^in absentia$'=> '<i>in absentia</i>',
                'contains ^in infinitum$'=> '<i>in infinitum</i>',
                'contains ^in situ$'=> '<i>in situ</i>',
                'contains ^in toto$'=> '<i>in toto</i>',
                'contains ^in utero$'=> '<i>in utero</i>',
                'contains ^in vitro$'=> '<i>in vitro</i>',
                'contains ^in vivo$'=> '<i>in vivo</i>',
                'contains ^pro rata$'=> '<i>pro rata</i>',
                'contains ^sensu$'=> '<i>sensu</i>',
                'contains ^ab initio$'=> '<i>ab initio</i>',
                'contains ^[Ss]tudent(?:[\x{0027}\x{2019}\']?s)? t[\x{2010}\x{2014}\–\-]?test' => array(
                    'replaceWith' => 'Student&#x2019;s <i>t</i>&#x2010;test',
                ),
                'contains ^χ2[\x{2010}\x{2014}\–\-]?test$' => '&chi;<sup>2</sup>&#x2010;test',
                'contains ^t[\x{2010}\x{2014}\–\-]?test$' => '<i>t</i>&#x2010;test',
                'contains ^p[\-\–\x{2010}\x{2014}]?value$' => '<i>p</i>&#x2010;value',
                'contains ^(E\.\s?coli)$' => array(
                    'replaceWith' => 'E. coli',
                    'functionToPerform' => 'addItalics'
                ),
                'default' => '$1',
        ),
    ),
    "VAL,UNT" => array(
        'VAL' => '$1',
        'UNT' => '$unitsArray[$2]',
    ),
    "HYPTOMIN,VAL" => array(
        'HYPTOMIN' => '&minus;',
        'VAL' => array(
            '$2 contains ^([0-9]+)\s%$' => 'replace_with($1%)',
            'default' => '$2',
        ),
    ),
    "VAL,UNT,OPR,VALS,UNTS" => array(
        'VAL' => '$1',
        'UNT' => '$2',
        'OPR' => ' $3 ',
        'VALS' => array(
            '$4 contains ^(?:\-|\x{2010})$' => '&#x2013;',
            'default' => '$4',
        ),
        'UNTS' => '$unitsArray[$5]',
    ),
    "VAL,RNGS,RNGC,RNGE,UNT" => array(
        'VAL' => '$1',
        'RNGS' => '$2',
        'RNGC' => array(
            '$3 contains ^(?:\-|\x{2010})$' => '&#x2013;',
            'default' => '$3',
        ),
        'RNGE' => '$4',
        'UNT' => '$unitsArray[$5]',
    ),
    "APP,PRE,PREP,RNG,SUF,SREP,UNT" => array(
        'APP' => '$1',
        'PRE' => '$2',
        'PREP' => '$3',
        'RNG' => array(
            '$4 contains ^(?:\-|\x{2010})$' => '&#x2013;',
            'default' => '$4',
        ),
        'SUF' => '$5',
        'SREP' => '$6',
        'UNT' => '$unitsArray[$7]',
    ),
    "VAR,OPR,VAL,OPRS,VALS,UNT" => array(
        'VAR' => array(
            '$1 matches ^([\*\,\#\(]*)\s?(P|p)$' => 'replace_with($1<i>p</i>)',
            '$1 matches ^([\*\,\#\(]*)\s?(n)$' => 'replace_with($1<i>n</i>)',
            'default' => '$1',
        ),
        'OPR' => array(
            '$2 matches ^(\s*=\s*)$' => 'replace_with( = )',
            '$2 contains ^\s?(?:\±|\x{00B1})\s?$' => ' $2 ',
            'default' => '$2',
        ),
        'VAL' => array(
            'default' => '$3',
        ),
        'OPRS' => array(
            'default' => 'default',
        ),
        'VALS' => array(
            '$5 contains ^(?:\-|\x{2010})$' => '&#x2013;',
            'default' => '$5',
        ),
        'UNT' => '$unitsArray[$6]',
    ),
    "LQUOTE" => array(
        'LQUOTE' => array(
            'functionToPerform' => 'addTrackChanges',
            'contains \x{201c}' => '&lsquo;',
        ),
    ),
    "RQUOTE" => array(
        'RQUOTE' => array(
            'functionToPerform' => 'addTrackChanges',
            'contains \x{201d}' => '&rsquo;',
        ),
    ),
    "PLBL" => array(
        'PLBL' => array(
            'default' => array(
                'functionToPerform' => 'removeBold',
            ),
        ),
    ),
);

// $unitsArray = array(
//     'oc' => '&#xB0;C',
//     '°c' => '&#xB0;C',
//     'default' => array(
//         'contains ^\s?[\x{02DA}\x{00B0}]c$' => '&#xB0;C',
//         'contains ^\s?%$' => '%',
//         'contains ^\s?percent$' => '%',
//         'contains ^\s?[A-Z]$' => 'default',
//         'default' => ' $UNT',
//     ),
// );

// Create a new spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set header row
$sheet->setCellValue('A1', 'Category');
$sheet->setCellValue('B1', 'Subcategory');
$sheet->setCellValue('C1', 'Pattern');
$sheet->setCellValue('D1', 'Replacement');

// Flatten the array and write data to the sheet
$row = 2;
foreach ($replacePatternArray as $category => $subArray) {
    foreach ($subArray as $subcategory => $patterns) {
        foreach ($patterns as $pattern => $replacement) {
            if (is_array($replacement)) {
                $replacement = json_encode($replacement);
            }
            $sheet->setCellValue('A' . $row, $category);
            $sheet->setCellValue('B' . $row, $subcategory);
            $sheet->setCellValue('C' . $row, $pattern);
            $sheet->setCellValue('D' . $row, $replacement);
            $row++;
        }
    }
}

// Save the spreadsheet to a file
$writer = new Xlsx($spreadsheet);
$writer->save('replacePatternArray.xlsx');

echo "Data has been written to replacePatternArray.xlsx\n";
?>
