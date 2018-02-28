<?php

$fields = [
    'created'   => 'erstellt',
    'modified'  => 'aktualisiert',
    'creator'   => 'Autor',
    'publisher' => 'Herausgeber',
#    'base'      => ['Format', '<a href="%s'],
#    'homepage' => 'Homepage',
#    'wikidata' => 'Wikidata/pedia',
];

$infobox = [];
foreach ($fields as $name => $value) {
    if (${$name}) {
        if (is_array($value)) {
            $infobox[$value[0]] = ${$name}; # TODO
        } else {
            $infobox[$value] = ${$name};
        }
    }
}

if (count($schemas ?? [])) {
    $items = [];
    foreach ($schemas as $schema) {
        $language = 'schema/'.$schema['type'];
        $language = $PAGES->get($language);
        $language = $language['short'] ?? $language['title'];
        $items[] = "<a href='{$schema['url']}'>$language</a>";
    }
    if (count($items)) {
        $html = implode('<br>', $items);
        $infobox[count($schemas) > 1 ? 'Schemas' : 'Schema'] = $html;
    }
}

if (count($infobox)) { ?>
  <table class="table table-sm">
    <thead>
      <tr><th colspan="2"><?=$title?></th></tr>
    </thead>
    <tbody>
<?php foreach ($infobox as $key => $value) {
    echo "<tr><td>$key</td><td>$value</td></tr>\n";
} ?>
    </tbody>
  </table>
<?php }
