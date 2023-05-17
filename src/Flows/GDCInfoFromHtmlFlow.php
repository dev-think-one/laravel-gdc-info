<?php


namespace GDCInfo\Flows;

use Carbon\Carbon;
use DOMDocument;
use DOMXPath;
use GDCInfo\Exceptions\FindGDCInfoException;
use GDCInfo\Exceptions\NotFoundGDCInfoException;
use GDCInfo\GDCInfo;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class GDCInfoFromHtmlFlow
{

    public static function make(...$arguments)
    {
        return new static(...$arguments);
    }

    public function get(string $gdcNumber): GDCInfo
    {
        $response = Http::timeout(20)
            ->get('https://olr.gdc-uk.org/SearchRegister/SearchResult', [
                'RegistrationNumber' => $gdcNumber,
            ]);

        if (!$response->successful()) {
            throw new FindGDCInfoException("Response error with status [{$response->status()}]. We can't parse html");
        }

        $domDocument = new DOMDocument();
        @$domDocument->loadHTML($response->body());
        $xpath = new DOMXpath($domDocument);
        $heads = $xpath->query('/html/head/title');
        if (!$heads || !($head = $heads->item(0)) || !$head->nodeValue) {
            throw new FindGDCInfoException("'Head' elements not exists. Error on parsing data");
        }

        if ($head->nodeValue === 'No Results') {
            throw new NotFoundGDCInfoException("Invalid gdc number [{$gdcNumber}].");
        }

        $data = [
            ...$this->parseName($xpath),
            ...$this->parseInfo($xpath),
        ];

        return GDCInfo::fromArray($data);
    }

    protected function parseName(DOMXPath $xpath): array
    {
        $names = $xpath->query('/html/body/div/main/div/div/div/div/div/div/div/h2');
        if (!$names || !($name = $names->item(0)) || !$name->nodeValue) {
            throw new FindGDCInfoException("'Name item not found' elements not exists. Error on parsing data");
        }

        $data      = [];
        $firstName = $name->childNodes->item(1)?->nodeValue;
        if ($firstName) {
            $data['first_name'] = trim($firstName);
        }
        $lastName = $name->childNodes->item(2)?->nodeValue;
        if ($lastName) {
            $data['last_name'] = trim($lastName);
        }

        return $data;
    }

    protected function parseInfo(DOMXPath $xpath): array
    {
        /** @var \DOMNodeList $items */
        $items = $xpath->query('/html/body/div/main/div/div/div/div/div/div/div/div');
        if (!$items) {
            throw new FindGDCInfoException("'Info items not found' elements not exists. Error on parsing data");
        }

        $data = [];

        for ($i = 1; $i < $items->count(); $i++) {
            $item = $items->item($i);
            if (!$item) {
                continue;
            }
            $key   = rtrim(trim((string)$item->childNodes->item(1)?->nodeValue), ':');
            $value = rtrim(trim((string)$item->childNodes->item(3)?->nodeValue), ':');
            if (!$key || !$value) {
                continue;
            }

            $data[Str::snake($key)] = $value;
        }

        if (isset($data['first_registered_on'])) {
            $date = $data['first_registered_on'];
            unset($data['first_registered_on']);

            try {
                $date = Carbon::createFromFormat('d M Y', $date);
                if ($date) {
                    $data['first_registered_on'] = $date;
                }
            } catch (\Exception $e) {

            }
        }

        if (isset($data['current_period_of_registration_from'])) {
            $dateData = $data['current_period_of_registration_from'];
            unset($data['current_period_of_registration_from']);
            if (Str::contains($dateData, 'until:')) {
                $dateData = array_map('trim', explode('until:', $dateData));
                if (count($dateData) == 2) {
                    $date = $dateData[0];

                    try {
                        $date = Carbon::createFromFormat('d M Y', $date);
                        if ($date) {
                            $data['current_period_from'] = $date;
                        }
                    } catch (\Exception $e) {
                    }

                    $date = $dateData[1];

                    try {
                        $date = Carbon::createFromFormat('d M Y', $date);
                        if ($date) {
                            $data['current_period_until'] = $date;
                        }
                    } catch (\Exception $e) {
                    }
                }
            }
        }

        return $data;
    }
}
