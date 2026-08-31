<?php

require 'vendor/autoload.php';

use Illuminate\Support\Str;

class DummyController {
    public function mapLabelToField(string $label): ?string
    {
        $key = Str::of($label)
            ->lower()
            ->replace(['_', '-', '(', ')', '%'], '')
            ->squish()
            ->toString();

        return [
            'proyek' => 'nama_proyek',
            'nama proyek' => 'nama_proyek',
            'nama proyek pekerjaan' => 'nama_proyek',
            'kegiatan' => 'kegiatan',
            'sub kegiatan' => 'sub_kegiatan',
            'pekerjaan' => 'pekerjaan',
            'lokasi' => 'lokasi',
            'kontraktor' => 'kontraktor',
            'kontraktor pelaksana' => 'kontraktor',
            'kontraktor / kontraktor pelaksana' => 'kontraktor',
            'konsultan' => 'konsultan',
            'konsultan pengawas' => 'konsultan',
            'pic' => 'pic',
            'minggu' => 'minggu_ke',
            'minggu ke' => 'minggu_ke',
            'tanggal' => 'tanggal',
            'tanggal yyyymmdd' => 'tanggal',
            'progress' => 'progress',
            'uraian' => 'pekerjaan',
            'jumlah pekerja' => 'jumlah_pekerja',
            'jumlah tukang' => 'jumlah_tukang',
            'jumlah mandor' => 'jumlah_mandor',
            'jam mulai' => 'jam_mulai',
            'jam selesai' => 'jam_selesai',
            'material' => 'material',
            'peralatan' => 'alat',
            'alat' => 'alat',
            'cuaca cerahmendunghujan' => 'cuaca',
            'cuaca' => 'cuaca',
            'kendala' => 'kendala',
            'rencana besok' => 'rencana_besok',
            'keterangan' => 'keterangan',
            'catatan' => 'catatan',
            'tenaga' => 'tenaga',
            'jam kerja' => 'jam_kerja',
        ][$key] ?? null;
    }

    public function parseReport(string $message): array
    {
        $report = [];
        $section = 'general';
        $currentMaterial = [];
        $currentAlat = [];
        
        $materials = [];
        $alats = [];
        $pekerjaanYangDilakukan = [];

        foreach (preg_split('/\R+/', $message) ?: [] as $line) {
            $lineTrim = trim($line);
            if (empty($lineTrim)) continue;

            $lowerLine = Str::lower($lineTrim);
            
            // Detect sections
            if (preg_match('/^pekerjaan\s+yang\s+dilakukan\s*:?/i', $lineTrim)) {
                $section = 'pekerjaan';
                continue;
            } elseif (preg_match('/^(?:bahan|material)(?:\s*\/\s*(?:bahan|material))?\s*:?/i', $lineTrim)) {
                $section = 'material';
                if (!empty($currentMaterial)) $materials[] = $currentMaterial;
                $currentMaterial = [];
                continue;
            } elseif (preg_match('/^(?:per)?alat(?:an)?\s*:?/i', $lineTrim)) {
                $section = 'alat';
                if (!empty($currentAlat)) $alats[] = $currentAlat;
                $currentAlat = [];
                continue;
            } elseif (preg_match('/^tenaga\s+kerja\s*:?/i', $lineTrim)) {
                $section = 'tenaga';
                continue;
            } elseif (preg_match('/^kendala\s*:?/i', $lineTrim)) {
                $section = 'kendala';
                $lineTrim = trim(preg_replace('/^kendala\s*:?/i', '', $lineTrim));
                if ($lineTrim === '') continue;
            } elseif (preg_match('/^keterangan\s*:?/i', $lineTrim)) {
                $section = 'keterangan';
                $lineTrim = trim(preg_replace('/^keterangan\s*:?/i', '', $lineTrim));
                if ($lineTrim === '') continue;
            } elseif (preg_match('/^(catatan(?:\s*\/\s*progress)?|progress)\s*:?/i', $lineTrim)) {
                $section = 'catatan_progress';
                $lineTrim = trim(preg_replace('/^(catatan(?:\s*\/\s*progress)?|progress)\s*:?/i', '', $lineTrim));
                if ($lineTrim === '') continue;
            }

            // Parse based on section
            $hasColon = str_contains($lineTrim, ':');
            if (!$hasColon && str_contains($lineTrim, '=')) {
                $hasColon = true;
                $lineTrim = str_replace('=', ':', $lineTrim);
            }
            
            // Prevent taking over valid general fields
            if ($hasColon && in_array($section, ['kendala', 'keterangan', 'catatan', 'progress', 'catatan_progress', 'pekerjaan'])) {
                $testLabel = explode(':', $lineTrim, 2)[0];
                if ($this->mapLabelToField(trim(preg_replace('/^[\-\d\.]+\s*/', '', $testLabel)))) {
                    $section = 'general';
                }
            }

            if (in_array($section, ['kendala', 'keterangan', 'catatan', 'progress', 'catatan_progress'])) {
                $targetField = in_array($section, ['progress', 'catatan_progress', 'catatan']) ? 'catatan' : $section;
                
                if (in_array($section, ['progress', 'catatan_progress'])) {
                    if (preg_match('/(?:progress|mencapai)[^:]*?:?\s*([\d,\.]+)\s*%/i', $lineTrim, $matches)) {
                        if (stripos($lineTrim, 'harian') === false && stripos($lineTrim, 'target') === false) {
                            $report['progress'] = (int) str_replace(',', '.', $matches[1]);
                        }
                    }
                }

                $report[$targetField] = isset($report[$targetField]) ? $report[$targetField] . "\n" . $lineTrim : $lineTrim;
                continue;
            }

            if ($section === 'pekerjaan') {
                $pekerjaanYangDilakukan[] = preg_replace('/^[\-\*\d\.]+\s*/', '', $lineTrim);
                continue;
            }

            if ($hasColon) {
                [$label, $value] = array_map('trim', explode(':', $lineTrim, 2));
                $labelClean = preg_replace('/^[\-\d\.]+\s*/', '', $label); // remove list hyphen and numbers
                $labelClean = trim($labelClean);
                $value = trim($value);

                if ($section === 'material') {
                    $lowerLabel = strtolower($labelClean);
                    if ($lowerLabel === 'nama material' || $lowerLabel === 'material') {
                        if (!empty($currentMaterial)) $materials[] = $currentMaterial; // push previous
                        $currentMaterial = ['nama_material' => $value, 'volume' => 0, 'satuan' => 'ls'];
                    } elseif ($lowerLabel === 'volume') {
                        $currentMaterial['volume'] = (float) str_replace(',', '.', $value);
                    } elseif ($lowerLabel === 'satuan') {
                        $currentMaterial['satuan'] = $value;
                    } else {
                        // Label is not a standard keyword, treat as "Name : Volume Unit"
                        $nama = preg_replace('/^[\-\*\d\.]+\s*/', '', $label); // strip leading bullets
                        $vol = 1;
                        $sat = 'ls';
                        if (preg_match('/^([\d,\.]+)\s*(.*)$/', $value, $m)) {
                            $vol = (float) str_replace(',', '.', $m[1]);
                            $sat = trim($m[2]) ?: 'ls';
                        }
                        if (!empty($currentMaterial)) $materials[] = $currentMaterial;
                        $currentMaterial = ['nama_material' => trim($nama), 'volume' => $vol, 'satuan' => $sat];
                    }
                } elseif ($section === 'alat') {
                    $lowerLabel = strtolower($labelClean);
                    if ($lowerLabel === 'nama alat' || $lowerLabel === 'alat') {
                        if (!empty($currentAlat)) $alats[] = $currentAlat; // push previous
                        $currentAlat = ['nama_alat' => $value, 'jumlah' => 1];
                    } elseif ($lowerLabel === 'jumlah') {
                        $currentAlat['jumlah'] = (int) $value;
                    } else {
                        // Label is not a standard keyword, treat as "Name : Jumlah Unit"
                        $nama = preg_replace('/^[\-\*\d\.]+\s*/', '', $label); // strip leading bullets
                        $jum = 1;
                        if (preg_match('/^([\d,\.]+)\s*(.*)$/', $value, $m)) {
                            $jum = (int) str_replace(',', '.', $m[1]);
                        }
                        if (!empty($currentAlat)) $alats[] = $currentAlat;
                        $currentAlat = ['nama_alat' => trim($nama), 'jumlah' => $jum];
                    }
                } elseif ($section === 'tenaga') {
                     $lowerLabel = strtolower($labelClean);
                     if (in_array($lowerLabel, ['pekerja', 'tukang', 'mandor', 'pelaksana'])) {
                         $report['jumlah_' . $lowerLabel] = (int) $value;
                     } else {
                         $field = $this->mapLabelToField($labelClean);
                         if ($field) $report[$field] = $value;
                     }
                } else {
                    $field = $this->mapLabelToField($labelClean);
                    if ($field === 'jam_kerja') {
                        $value = str_replace(['–', '—'], '-', $value); // Replace en-dash/em-dash with standard hyphen
                        $parts = explode('-', $value);
                        if (count($parts) >= 2) {
                            $report['jam_mulai'] = trim($parts[0]);
                            $report['jam_selesai'] = trim($parts[1]);
                        } else {
                            $report['jam_mulai'] = trim($value);
                        }
                    } elseif ($field && $value !== '') {
                        $report[$field] = $value;
                    }
                }
            } else {
                // Fallback for inline items like "Semen PCC (100 sak)" or "1 Unit Concrete Pump"
                $inlineText = preg_replace('/^[\-\*\d\.]+\s*/', '', $lineTrim); // remove numbering
                if ($section === 'material') {
                    $vol = 1;
                    $sat = 'ls';
                    $nama = $inlineText;
                    if (preg_match('/^(.*?)\s*\(?([\d,\.]+)\s*([a-zA-Z²³]+)\)?$/', $inlineText, $m)) {
                        $nama = trim($m[1]);
                        $vol = (float) str_replace(',', '.', $m[2]);
                        $sat = trim($m[3]);
                    }
                    if (!empty($currentMaterial)) $materials[] = $currentMaterial;
                    $currentMaterial = ['nama_material' => $nama, 'volume' => $vol, 'satuan' => $sat];
                } elseif ($section === 'alat') {
                    $jum = 1;
                    $nama = $inlineText;
                    if (preg_match('/^([\d]+)\s*(?:unit|buah|set)?\s*(.*)$/i', $inlineText, $m)) {
                        $jum = (int) $m[1];
                        $nama = trim($m[2]);
                    } elseif (preg_match('/^(.*?)\s*\(?([\d]+)\s*(?:unit|buah|set)?\)?$/i', $inlineText, $m)) {
                        $nama = trim($m[1]);
                        $jum = (int) $m[2];
                    }
                    if (!empty($currentAlat)) $alats[] = $currentAlat;
                    $currentAlat = ['nama_alat' => $nama, 'jumlah' => $jum];
                }
            }
        }
        
        // Push last material/alat
        if (!empty($currentMaterial)) $materials[] = $currentMaterial;
        if (!empty($currentAlat)) $alats[] = $currentAlat;
        
        $report['materials_parsed'] = $materials;
        $report['alats_parsed'] = $alats;
        $report['pekerjaan_yang_dilakukan'] = $pekerjaanYangDilakukan;

        return $report;
    }
}

$text = <<<TEXT
LAPORAN HARIAN

Pekerjaan : Pemasangan Paving Block
Lokasi : Halaman Gedung Utama
Tanggal : 20 Agustus 2026
Minggu Ke : 3
Kontraktor Pelaksana : CV Maju Jaya
Konsultan Pengawas : PT Konsultan Teknik Bali

Pekerjaan Yang Dilakukan :

* Persiapan dan pembersihan area pemasangan.
* Pemasangan paving block pada area halaman.

Bahan / Material :

* Paving block = 150 m²
* Pasir urug = 5 m³

Tenaga Kerja :
Pekerja = 8 orang
Tukang = 4 orang
Mandor = 1 orang
Pelaksana = 1 orang

Alat :

* Gerobak sorong = 3 unit
* Stamper = 1 unit

Jam Kerja : 08.00–17.00 WITA
Cuaca : Cerah berawan

Kendala :

* Beberapa pekerja kurang disiplin dan bekerja dengan lambat sehingga progres pekerjaan tidak maksimal.

Keterangan :

* Pekerjaan tetap berjalan, namun perlu peningkatan kedisiplinan tenaga kerja.

Catatan / Progress :

* Progress hari ini sekitar 65%.
* Pekerjaan dilanjutkan pada hari berikutnya.
TEXT;

$obj = new DummyController();
print_r($obj->parseReport($text));
