<?php

$wikis = array( 'global', 'hu', 'fr', 'en', 'mediawiki', 'commons' );

function generate( $wiki ) {
	if ( ! file_exists( './datasources/mmv_performance_template.json' ) ) {
		echo 'You must run this script from the multimedia-limn folder';
		exit( 0 );
	}

	$templates = array( './datasources/mmv_performance', './graphs/mmv_performance', './datasources/mmv_actions', './graphs/mmv_actions' );

	foreach ( $templates as $template ) {
		$json = file_get_contents( $template . '_template.json' );
		$json = str_replace( '%wiki%', $wiki, $json );
		file_put_contents( $template . '_' . $wiki . '.json', $json );
	}
}

foreach ( $wikis as $wiki ) {
	generate( $wiki );
}

?>