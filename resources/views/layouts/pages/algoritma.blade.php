@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-header" style="background: white">
                    <h5 class="card-title fw-semibold mb-4">Proses Perhitungan</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('transaksi.filter') }}" method="GET">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row align-items-center">
                                    <div class="col-md-4 form-group mb-3">
                                        <label for="first-date">Tanggal Dari</label>
                                        <input type="date" id="first-date" required class="form-control mt-2"
                                            name="tanggal_dari" required />
                                    </div>
                                    <div class="col-md-4 form-group mb-3">
                                        <label for="second-date">Tanggal Sampai</label>
                                        <input type="date" id="second-date" required class="form-control mt-2"
                                            name="tanggal_sampai" required />
                                    </div>
                                </div>
                                <h5><em>Range Min Coffidance: 0.10-1.00</em></h5>
                                <h5><em>Jumlah Data: {{ $totalTransactions ?? '' }} </em></h5>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-4 form-group mb-3">
                                    <label for="first-date">Min Support</label>
                                    <input type="text" id="first-date" required class="form-control mt-2"
                                        name="min_support" required />
                                </div>
                                <div class="col-md-4 form-group mb-3">
                                    <label for="first-date">Min Confidance</label>
                                    <input type="text" id="first-date" required class="form-control mt-2"
                                        name="min_confidance" required />
                                </div>
                                <button type="submit" class="btn btn-primary">Proses Data</button>
                            </div>
                    </form>
                </div>
                @if (isset($itemset1))
                    <h2>Itemset 1</h2>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Support</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($itemset1 as $item)
                                <tr>
                                    <td>{{ $item['item'] }}</td>
                                    <td>{{ $item['support'] }}</td>
                                    <td>{{ $item['keterangan'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
                @if (isset($itemset2))
                    <h2>Itemset 2</h2>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Items</th>
                                <th>Support</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($itemset2 as $item)
                                <tr>
                                    <td>{{ $item['items'] }}</td>
                                    <td>{{ $item['support'] }}</td>
                                    <td>{{ $item['keterangan'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
                @if (isset($itemset3))
                    <h2>Itemset 3</h2>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Items</th>
                                <th>Support</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($itemset3 as $item)
                                <tr>
                                    <td>{{ $item['items'] }}</td>
                                    <td>{{ $item['support'] }}</td>
                                    <td>{{ $item['keterangan'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

                @if (isset($confidenceResults))
                    <h2>Confidence Result</h2>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Itemset</th>
                                <th>Support X∪Y</th>
                                <th>Support X</th>
                                <th>Confidence</th>
                                <th>Lift Ratio</th>
                                <th>Korelasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($confidenceResults as $result)
                                <tr>
                                    <td>{{ $result['itemset'] }}</td>
                                    <td>{{ $result['support_xUy'] }}</td>
                                    <td>{{ $result['support_x'] }}</td>
                                    <td>{{ $result['confidence'] }}</td>
                                    <td>{{ $result['lift_ratio'] }}</td>
                                    <td>{{ $result['korelasi'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
    @if (session('message'))
        <div class="alert alert-info">
            {{ session('message') }}
        </div>
    @endif
@endsection
