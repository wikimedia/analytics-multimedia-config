#!/usr/bin/env python

import os
import sys

wikis = [
    'global',
    'cawiki',
    'commonswiki',
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
]

performance_metrics = {
    'userinfo': 'API call fetching information about users. Mainly used for correct gender-based localization of text',
    'imageinfo': 'API call fetching general information about the image',
    'thumbnailinfo': 'API call fetching information about a thumbnail of a specific size for the image',
    'filerepoinfo': 'API call fetching information about a file repository',
    'imageusage': 'API call fetching file usage information on the local wiki',
    'globalusage': 'API call fetching file usage information on all wikis but the local one',
    'image': 'images shown in Media Viewer',
    'imagehit': 'images shown in Media Viewer, cache hit (image didn\'t have to be generated on the fly)',
    'imagemiss': 'images shown in Media Viewer, cache miss (image had to be generated on the fly)',
}

geoperformance_metrics = {
    'api': 'Average duration of API calls per country, in milliseconds. The lower, the better.',
    'image': 'Average duration of image loads per country, in milliseconds. The lower, the better.',
}

templates = {
    './dashboards/mmv':  None,
    './datasources/mmv_performance': performance_metrics,
    './graphs/mmv_performance': performance_metrics,
    './datasources/mmv_geoperformance': geoperformance_metrics,
    './graphs/mmv_geoperformance': geoperformance_metrics,
    './datasources/mmv_actions': None,
    './graphs/mmv_actions': None,
    './graphs/mmv_actions_download': None,
    './graphs/mmv_actions_share': None,
    './graphs/mmv_actions_embed': None,
    './graphs/mmv_opt_inout': None,
    './datasources/mmv_optout': None,
    './graphs/mmv_optout': None,
    './datasources/mmv_duration': None,
    './graphs/mmv_duration': None,
}

def generate(wiki, templates):
    if not os.path.isfile('./datasources/mmv_performance_template.json'):
        print('You must run this script from the multimedia-limn folder')
        sys.exit(1);

    for template, metrics in templates.items():
        json = open(template + '_template.json').read(100000)
        json = json.replace('%wiki%', wiki)

        if metrics:
            for metric, metric_description in metrics.items():
                metric_json = json.replace('%metric%', metric).replace('%metricdescription%', metric_description)
                with open(template + '_' + metric + '_' + wiki + '.json', 'w') as f:
                    f.write(metric_json)
        else:
            with open(template + '_' + wiki + '.json', 'w') as f:
                f.write(json)

for wiki in wikis:
    generate(wiki, templates)