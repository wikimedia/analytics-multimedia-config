<?php

$wikis = array(
	'global',
	'cawiki',
	'commonswiki',
	'czwiki',
	'dewiki',
	'enwiki',
	'enwikivoyage',
	'eswiki',
	'etwiki',
	'fiwiki',
	'frwiki',
	'hewiki',
	'huwiki',
	'itwiki',
	'jawiki',
	'kowiki',
	'mediawikiwiki',
	'nlwiki',
	'plwiki',
	'ptwiki',
	'rowiki',
	'ruwiki',
	'skwiki',
	'svwiki',
	'tewiki',
	'thwiki',
	'viwiki',
);

$performance_metrics = array(
	'userinfo' => 'API call fetching information about users. Mainly used for correct gender-based localization of text',
	'imageinfo' => 'API call fetching general information about the image',
	'thumbnailinfo' => 'API call fetching information about a thumbnail of a specific size for the image',
	'filerepoinfo' => 'API call fetching information about a file repository',
	'imageusage' => 'API call fetching file usage information on the local wiki',
	'globalusage' => 'API call fetching file usage information on all wikis but the local one',
	'image' => 'images shown in Media Viewer',
	'imagehit' => 'images shown in Media Viewer, cache hit (image didn\'t have to be generated on the fly)',
	'imagemiss' => 'images shown in Media Viewer, cache miss (image had to be generated on the fly)',
);

$geoperformance_metrics = array(
	'api' => 'Average duration of API calls per country, in milliseconds. The lower, the better.',
	'image' => 'Average duration of image loads per country, in milliseconds. The lower, the better.'
);

$templates = array(
	'./dashboards/mmv' => null,
	'./datasources/mmv_performance' => $performance_metrics,
	'./graphs/mmv_performance' => $performance_metrics,
	'./datasources/mmv_geoperformance' => $geoperformance_metrics,
	'./graphs/mmv_geoperformance' => $geoperformance_metrics,
	'./datasources/mmv_actions' => null,
	'./graphs/mmv_actions' => null,
	'./graphs/mmv_opt_inout' => null,
);

function generate( $wiki, $templates ) {
	if ( ! file_exists( './datasources/mmv_performance_template.json' ) ) {
		echo 'You must run this script from the multimedia-limn folder';
		exit( 0 );
	}

	foreach ( $templates as $template => $metrics ) {
		$json = file_get_contents( $template . '_template.json' );
		$json = str_replace( '%wiki%', $wiki, $json );

		if ( empty( $metrics ) ) {
			file_put_contents( $template . '_' . $wiki . '.json', $json );
		} else {
			foreach ( $metrics as $metric => $metric_description ) {
				$metric_json = str_replace( '%metric%', $metric, $json );
				$metric_json = str_replace( '%metricdescription%', $metric_description, $metric_json );
				file_put_contents( $template . '_' . $metric . '_' . $wiki . '.json', $metric_json );
			}
		}
	}
}

foreach ( $wikis as $wiki ) {
	generate( $wiki, $templates );
}

?>