---
title: Kodierungen
page: true
javascript:
    - //cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js
    - //cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js
    - |
        $(document).ready(function() {
            $('.sortable').DataTable({ paging: false, search: false, info: false });
        } );
css: 
    - //cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css
---

**Kodierungen** sind Vorschriften zur Abbildung eines Datenformates oder
-Modells in einem anderen Datenformat. Kodierungen deren Zielformat auf einer
Zeichenkette oder anderen Art von Reihenfolge basiert werden auch
**Serialisierung** genannt. 

## Liste von Kodierungen

Die folgenden Kodierungen von Ausgangs-Modell zu Ziel-Format sind auf dieser Seite dokumentiert.

<div class="alert alert-warning" role="alert">
  <a href="rdf">RDF</a>-basierte Formate sind in dieser Übersicht noch nicht enthalten!
</div>

<codetable/>

## Eigenschaften von Kodierungen

Letzendlich basieren alle Kodierungen über eine oder mehrere Ebenen auf Bytes
(und damit wiederum auf Bits), denn dies ist die einzige Form in der digitale
Daten physikalisch vorliegen.

Kodierungen können in beide Richtungen angewandt werden. Im Englischen wird
zwischen *encoding* (Kodierung, vom Modell zum Format) und *decoding*
(Dekodierung, vom Format zum Modell) unterschieden.

Kodierung sollten für jedes mögliche Dokument des Ausangs-Modells mindestens
ein Dokument im Ziel-Format bereitstellen. Anderfalls ist die Kodierung
*unvollständig*.

Während es bei den meisten Kodierung mehrere alternative Möglichkeiten der
Abbildung gibt (beispielsweise die mögliche Verwendung oder Auslassung
zusätzliche Leerzeichen), sollte die Dekodierung immer *eindeutig* sein.

Im Mathematischen Sinne (also auch so wie Computer die Daten verarbeiten) ist
die Abbildung einer Kodierung eher umgekehrt definiert: als
Dekodierungs-Funktion vom Format zum kodierten Modell.  Die Funktion ist dabei
meist nur partiell, es gibt also Dokumente die sich nicht dekodieren lassen
weil sie der Kodierungsvorschrift nach fehlerhaft sind.

Falls eine Kodierung/Dekodierung in beide Richtungen eindeutig ist, wird sie
auch als *Normalisierung* bezeichnet. Eine Folge normalisierender Kodierungen
bis zur Ebene von Bytes ist notwendig um bei Bedarf gleiche Dokumente anhand
ihrer Prüfsummen identifizieren zu können. In der Praxis ist dies bislang
jedoch nur für die wenigsten Formate möglich.

