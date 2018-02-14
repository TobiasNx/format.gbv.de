<?php declare(strict_types=1);

namespace GBV;

use GBV\YamlHeaderDocument;

/**
 * Set of encodings/decodings.
 */
class Codings
{
    public $codes = [];

    public static $files = []; // TODO: use Cache

    private function __construct()
    {
    }

    public function schemas()
    {
        // TODO: read from cache
        $schemas = [];
        $files = preg_grep('/\.md$/', scandir('../templates/schema'));
        foreach ($files as $file) {
            $metadata = static::metadata(substr($file, 0, -3), '../templates/schema');
            if ($metadata['for']) {
                $schemas[$metadata['local']] = $metadata;
            }
        }
        return $schemas;
    }

    public function codings(array $select = [])
    {
        $codings = [];
        if (!count($select)) {
            $codings = $this->codes;
        } else {
            foreach ($this->codes as $coding) {
                $keep = true;
                foreach ($select as $name => $value) {
                    if ($name === 'model') {
                        $id = 1;
                    } elseif ($name === 'format') {
                        $id = 2;
                    } else {
                        if ($name == 'except' && $value == $coding[0]['local']) {
                            $keep = false;
                        }
                        continue;
                    }
                    if ($select[$name] !== $coding[$id]['local']) {
                        $keep = false;
                    }
                }
                if ($keep) {
                    $codings[] = $coding;
                }
            }
        }
        return $codings;
    }

    public static function metadata($localName, $base = '.')
    {
        if (!isset(static::$files[$localName])) {
            $file = "$base/$localName.md";
            $meta = [ 'title' => $localName ];
            if (file_exists($file)) {
                $doc = YamlHeaderDocument::parseFile($file);
                $meta = $doc->header();
                $meta['local'] = $localName;
            } else {
                error_log("missing file $file");
            }
            static::$files[$localName] = $meta;
        }
        return static::$files[$localName];
    }

    public static function fromDir(string $base)
    {
        /**
         * In der Datei `codes.csv` sind Kodierung mit ihrem Ausgangsmodell und Zielformat
         * erfasst. Alle drei Angaben (`code`, `model`, und `format`) sind Verweise auf
         * einzelne Seiten dieser Webseite. Wenn `code` und `model` gleich sind, handelt
         * es sich bei der Kodierung um die Standard-Syntax des Modells für die keine
         * eigene Seite existiert.
         **/

        $file = "$base/code/codes.csv";

        $lines = file($file);
        array_shift($lines); // header

        $codings = new Codings();

        foreach ($lines as $line) {
            $line = preg_split('/\s*,\s*/', rtrim($line));
            $coding = [
                static::metadata($line[0], $base),
                static::metadata($line[1], $base),
                static::metadata($line[2], $base)
            ];
            if ($coding[0]['local']
                && $coding[0]['title'] == $coding[1]['title']) {
                $coding[0]['title'] .= ' Syntax';
                // $coding[1]['title'] .= ' Modell';
            }
            $codings->codes[] = $coding;
        }

        return $codings;
    }
}
