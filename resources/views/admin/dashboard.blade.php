@extends('admin.layouts.master', ['title' => 'Dashboard'])
@section('content')
<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card bg-primary text-white mb-4">
            <div class="card-body">Sudah Bayar</div>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-3 border-light">
                {{$count['paid']}}
            </span>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="/admin/orders?status=paid">Lihat selengkapnya...</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-warning text-white mb-4">
            <div class="card-body">Belum bayar</div>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-3 border-light">
                {{$count['unpaid']}}
            </span>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="/admin/orders?status=unpaid">Lihat selengkapnya...</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-secondary text-white mb-4">
            <div class="card-body">Kedaluwarsa</div>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-3 border-light">
                {{$count['expired']}}
            </span>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="/admin/orders?status=expired">Lihat selengkapnya...</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-danger text-white mb-4">
            <div class="card-body">Gagal</div>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-3 border-light">
                {{$count['failed']}}
            </span>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="/admin/orders?status=failed">Lihat selengkapnya...</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-12 col-md-12">
        <div class="card bg-light mb-4">
            <div class="card-header">
                <h5>
                    Pendapatan tiap bulan
                </h5>
            </div>
            <div class="card-body">
                <div class="d-flex float-end align-items-center gap-2">
                    <label>
                        Tahun:
                    </label>
                    <select class="form-select form-select-sm income" style="width: min-content;" aria-label=".form-select-sm example">
                        @for($i=date('Y'); $i >= 2000; $i--)
                        <option value="{{$i}}">{{$i}}</option>
                        @endfor
                    </select>
                </div>
                <canvas height="100" id="myChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-xl-12 col-md-12">
        <div class="card bg-light mb-4">
            <div class="card-header">
                <h5>
                    Penyewaan tiap bulan
                </h5>
            </div>
            <div class="card-body">
                <div class="d-flex float-end align-items-center gap-2">
                    <label>
                        Tahun:
                    </label>
                    <select class="form-select form-select-sm order" style="width: min-content;" aria-label=".form-select-sm example">
                        @for($i=date('Y'); $i >= 2000; $i--)
                        <option value="{{$i}}">{{$i}}</option>
                        @endfor
                    </select>
                </div>
                <canvas height="100" id="myChart2"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    function getDataIncomes(year) {
        return fetch('http://127.0.0.1:8000/admin/dashboard/charts/monthly/incomes?year=' + year)
            .then(response => response.json())
    }

    function getDataOrders(year) {
        return fetch('http://127.0.0.1:8000/admin/dashboard/charts/monthly/orders?year=' + year)
            .then(response => response.json())
    }

    async function updateData(chart, year, getFunction) {
        const result = await getFunction(year);
        const incomes = result.incomes;
        chart.data.datasets.forEach((dataset) => {
            dataset.data = incomes;
        });
        chart.update();
    }

    async function incomes() {
        const result = await getDataIncomes('');
        const labels = result.months;
        const incomes = result.incomes;
        const data = {
            labels: labels,
            datasets: [{
                label: 'Pendapatan',
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: incomes,
            }]
        };
        const config = {
            type: 'line',
            data,
            options: {
                scales: {
                    y: {
                        suggestedMin: 0,
                        suggestedMax: 100000
                    }
                }
            }
        };
        var myChart = new Chart(
            document.getElementById('myChart'),
            config
        );

        $('.income').change(function() {
            updateData(myChart, $(this).val(), getDataIncomes);
        })
    }

    async function orders() {
        const result = await getDataOrders('');
        const labels = result.months;
        const incomes = result.incomes;
        const data = {
            labels: labels,
            datasets: [{
                label: 'Penyewaan',
                backgroundColor: '#3a9bdc',
                borderColor: '#3a9bdc',
                data: incomes,
            }]
        };
        const config = {
            type: 'line',
            data,
            options: {
                scales: {
                    y: {
                        suggestedMin: 0,
                        suggestedMax: 20
                    }
                }
            }
        };
        var myChart2 = new Chart(
            document.getElementById('myChart2'),
            config
        );

        $('.order').change(function() {
            updateData(myChart2, $(this).val(), getDataOrders);
        })
    }

    incomes();
    orders();
</script>

@endsection