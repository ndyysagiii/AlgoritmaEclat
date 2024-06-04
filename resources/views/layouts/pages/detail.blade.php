@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-header mb-3">
                    <div class="mb-4">
                        <h5 class="card-title fw-semibold">Detail Perhitungan Eclat</h5>
                    </div>
                    <ul class="timeline-widget mb-0 position-relative mb-n5">
                        <li class="timeline-item d-flex position-relative overflow-hidden">
                            <div class="timeline-desc text-dark">
                                Rentang tanggal :
                                {{ \Carbon\Carbon::parse($proses->start)->format('d F Y') }} -
                                {{ \Carbon\Carbon::parse($proses->end)->format('d F Y') }}
                            </div>
                            <div class="timeline-desc text-dark">
                                Min. Support: {{ $proses->min_support }}
                            </div>
                            <div class="timeline-desc text-dark">
                                Min. Confidence: {{ $proses->min_confidence }}
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="card-body p-4">
                    @if ($itemset2->isEmpty() && $itemset3->isEmpty())
                        <p>Tidak ada data itemset yang tersedia untuk proses ini.</p>
                    @else
                        <div class="table-responsive">
                            <h5 class="fw-semibold mb-3">Itemset 2 dan Confidence</h5>
                            <table class="table text-nowrap mb-4 align-middle" id="itemset2Table">
                                <thead class="text-dark fs-4">
                                    <tr>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Jenis Obat</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Jenis Obat</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Support</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Keterangan</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Support xUy</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Support X</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Confidence</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Lift Ratio</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Korelasi</h6>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($itemset2 as $item)
                                        <tr>
                                            <td>{{ $item->atribut }}</td>
                                            <td>{{ $item->support }}</td>
                                            <td>{{ $item->keterangan }}</td>
                                            @if ($item->confidences->isEmpty())
                                                <td colspan="5">Tidak ada data confidence</td>
                                            @else
                                                @foreach ($item->confidences as $confidence)
                                                    <td>{{ $confidence->support_xUy }}</td>
                                                    <td>{{ $confidence->support_x }}</td>
                                                    <td>{{ $confidence->confidence }}</td>
                                                    <td>{{ $confidence->lift_ratio }}</td>
                                                    <td>{{ $confidence->korelasi }}</td>
                                                @endforeach
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <h5 class="fw-semibold mb-3">Itemset 3 dan Confidence</h5>
                            <table class="table text-nowrap mb-0 align-middle" id="itemset3Table">
                                <thead class="text-dark fs-4">
                                    <tr>
                                        <th>Jenis Obat</th>
                                        <th>Support</th>
                                        <th>Keterangan</th>
                                        <th>Support xUy</th>
                                        <th>Support x</th>
                                        <th>Confidence</th>
                                        <th>Lift Ratio</th>
                                        <th>Korelasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($itemset3 as $item)
                                        <tr>
                                            <td>{{ $item->atribut }}</td>
                                            <td>{{ $item->support }}</td>
                                            <td>{{ $item->keterangan }}</td>
                                            @if ($item->confidences->isEmpty())
                                                <td colspan="5">Tidak ada data confidence</td>
                                            @else
                                                @foreach ($item->confidences as $confidence)
                                                    <td>{{ $confidence->support_xUy }}</td>
                                                    <td>{{ $confidence->support_x }}</td>
                                                    <td>{{ $confidence->confidence }}</td>
                                                    <td>{{ $confidence->lift_ratio }}</td>
                                                    <td>{{ $confidence->korelasi }}</td>
                                                @endforeach
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
