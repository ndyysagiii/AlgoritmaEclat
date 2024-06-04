<?php

namespace App\Http\Controllers;

use App\Models\Confidence;
use App\Models\Itemset1;
use App\Models\Itemset2;
use App\Models\Itemset3;
use App\Models\Proses;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class ProsesController extends Controller
{
    public function index()
    {
        return view('layouts.pages.algoritma');
    }

    public function filter(Request $request)
    {
        $tanggal_dari = $request->input('tanggal_dari');
        $tanggal_sampai = $request->input('tanggal_sampai');
        $min_support = $request->input('min_support');
        $min_confidance = $request->input('min_confidance');

        $proses = Proses::create([
            'start' => $tanggal_dari,
            'end' => $tanggal_sampai,
            'min_support' => $min_support,
            'min_confidence' => $min_confidance,
        ]);

        $transaksi = Transaksi::whereBetween('tanggal', [$tanggal_dari, $tanggal_sampai])->get();

        $totalTransactions = $transaksi->count();
        $itemsets = $this->generateItemsets($transaksi);

        list($itemset1, $itemset2, $itemset3, $confidenceResults) = $this->calculateEclat($itemsets, $min_support, $min_confidance, $totalTransactions);
        foreach ($itemset1 as $item) {
            Itemset1::create([
                'atribut' => $item['item'],
                'support' => $item['support'],
                'keterangan' => $item['keterangan'],
                'proses_id' => $proses->id,
            ]);
        }
        foreach ($itemset2 as $item) {
            $itemset2Record = Itemset2::create([
                'atribut' => $item['items'],
                'support' => $item['support'],
                'keterangan' => $item['keterangan'],
                'proses_id' => $proses->id,
            ]);

            // Simpan confidence untuk itemset2
            foreach ($confidenceResults as $confidence) {
                if ($confidence['itemset'] === $item['items']) {
                    Confidence::create([
                        'items' => $item['items'],
                        'support_xUy' => $confidence['support_xUy'],
                        'support_x' => $confidence['support_x'],
                        'confidence' => $confidence['confidence'],
                        'lift_ratio' => $confidence['lift_ratio'],
                        'korelasi' => $confidence['korelasi'],
                        'itemset2_id' => $itemset2Record->id,
                    ]);
                }
            }
        }
        foreach ($itemset3 as $item) {
            $itemset3Record = Itemset3::create([
                'atribut' => $item['items'],
                'support' => $item['support'],
                'keterangan' => $item['keterangan'],
                'proses_id' => $proses->id,
            ]);

            // Simpan confidence untuk itemset3
            foreach ($confidenceResults as $confidence) {
                if ($confidence['itemset'] === $item['items']) {
                    Confidence::create([
                        'items' => $item['items'],
                        'support_xUy' => $confidence['support_xUy'],
                        'support_x' => $confidence['support_x'],
                        'confidence' => $confidence['confidence'],
                        'lift_ratio' => $confidence['lift_ratio'],
                        'korelasi' => $confidence['korelasi'],
                        'itemset3_id' => $itemset3Record->id,
                    ]);
                }
            }
        }
        return view('layouts.pages.algoritma', compact('itemset1', 'itemset2', 'itemset3', 'confidenceResults'));
    }

    private function generateItemsets($transaksi)
    {
        $itemsets = [];

        foreach ($transaksi as $trans) {
            $items = explode(', ', $trans->obat);
            foreach ($items as $item) {
                if (!isset($itemsets[$item])) {
                    $itemsets[$item] = [];
                }
                $itemsets[$item][] = $trans->id;
            }
        }

        return $itemsets;
    }

    private function calculateEclat($itemsets, $min_support, $min_confidance, $totalTransactions)
    {
        $min_support_count = $min_support * $totalTransactions;
        $itemset1 = [];
        $itemset2 = [];
        $itemset3 = [];
        $confidenceResults = [];

        // Calculate 1-itemsets
        foreach ($itemsets as $item => $transactions) {
            $support = count($transactions);
            $supportValue = $support / $totalTransactions;
            $itemset1[] = [
                'item' => $item,
                'support' => $supportValue,
                'keterangan' => $supportValue >= $min_support ? 'Lolos' : 'Tidak Lolos'
            ];
        }

        // Generate 2-itemsets and calculate support
        $items = array_keys($itemsets);
        for ($i = 0; $i < count($items); $i++) {
            for ($j = $i + 1; $j < count($items); $j++) {
                $itemA = $items[$i];
                $itemB = $items[$j];
                $transactionsA = $itemsets[$itemA];
                $transactionsB = $itemsets[$itemB];
                $commonTransactions = array_intersect($transactionsA, $transactionsB);
                $support = count($commonTransactions);
                $supportValue = $support / $totalTransactions;

                $confidence = $support / count($transactionsA);
                $liftRatio = $supportValue / ((count($transactionsA) / $totalTransactions) * (count($transactionsB) / $totalTransactions));
                $keterangan = ($supportValue >= $min_support && $confidence >= $min_confidance) ? 'Lolos' : 'Tidak Lolos';

                $itemset2[] = [
                    'items' => "$itemA, $itemB",
                    'support_xUy' => $supportValue,
                    'support' => $supportValue,
                    'confidence' => $confidence,
                    'lift_ratio' => $liftRatio,
                    'keterangan' => $keterangan
                ];

                if ($supportValue >= $min_support) {
                    // Calculate confidence and lift ratio for 2-itemsets
                    if ($confidence >= $min_confidance) {
                        $confidenceResults[] = [
                            'itemset' => "$itemA, $itemB",
                            // 'kombinasi2' => $itemB,
                            'support_xUy' => $supportValue,
                            'support_x' => count($transactionsA) / $totalTransactions,
                            'confidence' => $confidence,
                            'lift_ratio' => $liftRatio,
                            'korelasi' => $liftRatio > 1 ? 'Positif' : 'Negatif'
                        ];
                    }
                }
            }
        }

        // Generate 3-itemsets and calculate support
        for ($i = 0; $i < count($items); $i++) {
            for ($j = $i + 1; $j < count($items); $j++) {
                for ($k = $j + 1; $k < count($items); $k++) {
                    $itemA = $items[$i];
                    $itemB = $items[$j];
                    $itemC = $items[$k];
                    $transactionsA = $itemsets[$itemA];
                    $transactionsB = $itemsets[$itemB];
                    $transactionsC = $itemsets[$itemC];
                    $commonTransactions = array_intersect($transactionsA, $transactionsB, $transactionsC);
                    $support = count($commonTransactions);
                    $supportValue = $support / $totalTransactions;

                    $confidence = $support / count($transactionsA);
                    $liftRatio = $supportValue / ((count($transactionsA) / $totalTransactions) * (count($transactionsB) / $totalTransactions) * (count($transactionsC) / $totalTransactions));
                    $keterangan = ($supportValue >= $min_support && $confidence >= $min_confidance) ? 'Lolos' : 'Tidak Lolos';

                    $itemset3[] = [
                        'items' => "$itemA, $itemB, $itemC",
                        'support_xUy' => $supportValue,
                        'support' => $supportValue,
                        'confidence' => $confidence,
                        'lift_ratio' => $liftRatio,
                        'keterangan' => $keterangan
                    ];

                    if ($supportValue >= $min_support) {
                        // Calculate confidence and lift ratio for 3-itemsets
                        if ($confidence >= $min_confidance) {
                            $confidenceResults[] = [
                                'itemset' => "$itemA, $itemB, $itemC",
                                // 'kombinasi2' => $itemC,
                                'support_xUy' => $supportValue,
                                'support_x' => count($transactionsA) / $totalTransactions,
                                'confidence' => $confidence,
                                'lift_ratio' => $liftRatio,
                                'korelasi' => $liftRatio > 1 ? 'Positif' : 'Negatif'
                            ];
                        }
                    }
                }
            }
        }

        return [$itemset1, $itemset2, $itemset3, $confidenceResults];
    }
}
