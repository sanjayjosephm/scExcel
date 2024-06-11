<?php
	$replacePatternArray = array(
		"PER,VAL,UNT" => array(
			'PER' => '$1',
			'VAL' => ' $2',
			'UNT' => '$unitsArray[$3]',
		),
		"VAL,PER,UNT" => array(
			'VAL' => '$1',
			'PER' => ' $2',
			'UNT' => '$unitsArray[$3]',
		),
		"APP,PRE,PREP,RNG,SUF,SREP,UNT" => array(
			'APP' => '$1',
			'PRE' => array(
					'$4 contains ^\s?[\-\x{2013}\x{00B1}]\s?$' => '$2',
					'default' => '$2$6',
			),
			'PREP' => 'delete',
			'RNG' => array(
					'contains [a-z]' => ' $4 ',
					'contains [\x{00B1}]' => ' $4 ',
					'default' => '&#x2013;',	
			),
			'SUF' => '$5',
			'SREP' => '$6',
			'UNT' => '$unitsArray[$7]',
		),
		"VAL,RNGS,RNGC,RNGE,UNT" => array(
			'VAL' => '$1 ',
			'RNGS' => '$2',
			'RNGC' => array(
					'contains [a-z]' => ' $3 ',
					'default' => '&#x2013;',	
			),
			'RNGE' => '$4',
			'UNT' => '$unitsArray[$5]',
		),
		"VAL,UNT" => array(
			'VAL' => '$1',
			'UNT' => '$unitsArray[$2]',
		),
		"VAR,OPR,VAL,OPRS,VALS,UNT" => array(
			'VAR' => array(
						'$1 matches ^([\*\,\#\(]+)\s(?=p([\-\s]values?)*)' => 'replace_with($1)',
						'contains ^[\*\,\#\(]*\s?p([\-\s]values?)*$' => array(
							'replaceWith' => '$1',
							'functionToPerform' => 'lowercase,removeItalics',
						),
						'default' => '$1',
				),
			'OPR' => array(
						'$2 matches (\+\/[\-\x{2013}\x{2212}])' => 'replace_with(&#x00B1;)',
						'$1 contains ^\(?[\*\,\#]*\s?p([\-\s]values?)*$' => '$2',
						'$2 contains ^\s?\/\s?$' => '$2',
						'$2 contains ^\s?x\s?$' => ' &#x00D7; ',
						'$1 exists' => '&#xA0;$2&#xA0;',
						'$1 is POS' => '&#xA0;$2',
						'$1 not exists' => '$2',
						'default' => 'default',
				),
			'VAL' => array(
						'$3 contains ^\.[0-9]' => '0$3',
						'default' => '$3',
				),
			'OPRS' => array(
						'$4 matches (\+\/[\-\x{2013}\x{2212}])' => 'replace_with(&#x00B1;)',
						'$4 contains ^\s?\/\s?$' => '$4',
						'$4 contains ^\s?x\s?$' => '&#x00D7;',
						'$3 exists' => '&#xA0;$4&#xA0;',
						'default' => 'default',
				),
			'VALS' => array(
						'$5 contains ^\.[0-9]' => '0$5',
						'default' => '$5',
				),
			'UNT' => '$unitsArray[$6]',
		),
		"HYPTOMIN,VAL" => array(
			'HYPTOMIN' => '&minus;',
			'VAL' => array(
						'$2 contains ^\.[0-9]' => '0$2',
						'default' => '$2',
				),
		),
		
		"AMP" => array(
			'AMP' => ' and ',
		),
		"SYM" => array(
				'SYM' => 'delete',
		),
		"THSE" => array(
			'THSE' => array(
				'$1 contains ^([0-9])([\,]?)([0-9]{3})$' => 'replace_with($1$3)',
				'$1 contains ^ ([0-9]+)([\,]?)([0-9]{3})$' => 'replace_with($1,$3)',
				'default' => 'default',
			), 
		),
		"FNW" => array(
			'FNW' => array(
				'default' =>array(
					'functionToPerform' => 'removeItalics',
				),
			),
		),
		"SNUM" => array(
			'SNUM' => array(
				'default' =>array(
					'functionToPerform' => 'numberToText',
				),
			),
		),
		"PLBL" => array(
			'PLBL' => array(
				'default' =>array(
					'functionToPerform' => 'removeBold',
				),
			),
		),
		"ANUM" => array(
			'ANUM' => array(
				'default' =>array(
					'functionToPerform' => 'numberToText',
				),
			),
		),
		"FLOAT" => array(
			'FLOAT' => array(
				"function" => function ($matchValue){
					return array("replaceWith" => "$1","replaceString" => floatval($matchValue[1][0]));
				},
			),
		),
		"COMP" => array(
			"COMP" => array(
				"function" => function ($matchValue){
					$returnString = $matchValue[1][0];	
					preg_match_all('/\d+/',$returnString,$matchNum);
					foreach ($matchNum[0] as $key=>$num){
						$returnString = str_replace($num, number_format($num), $returnString);
					}
					
					return array("replaceWith" => "$0","replaceString" => $returnString);
				},
			),
		),
		"LQUOTE" => array(
			'LQUOTE' => array(
				'contains \x{201c}' => '&lsquo;',
			),
		),
		"RQUOTE" => array(
			'RQUOTE' => array(
				'contains \x{201d}' => '&rsquo;',
			),
		),
		"SUPO,SUPN" => array(
			'SUPO' => '&minus;',
			'SUPN' => '$2',
		),
		"MON" => array(
			'MON' => array(
				"function" => function ($matchValue){
					return array("replaceWith" => "$1","replaceString" => date("F",strtotime($matchValue[1][0])));
				},
			),
		),
		
	);
?>