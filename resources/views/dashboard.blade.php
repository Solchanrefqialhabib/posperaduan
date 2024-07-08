@extends('layouts.app')

@section('content')
<section class="section">
  <div class="section-body">
    <div class="row">
      <div class="col-lg-12">
        <div class="alert-body">
          <!-- <div class="alert-title">Selamat Datang, {{ auth()->user()->role->role }}</div>
          Sekarang, anda sedang Login di aplikasi Point Of Sales {{ auth()->user()->cabang->cabang }}
          </div> -->
        </div>
      </div>

      <!-- Statistik Transaksi -->
      <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
        <div class="card card-statistic-1">
          <div class="card-icon bg-danger">
            <i class="fas fa-exchange-alt"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Total Transaksi</h4>
            </div>
            <div class="card-body">
              {{ $totalTransaksi }}
            </div>
          </div>
        </div>
      </div>

      <!-- Pemasukan Hari Ini -->
      <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
        <div class="card card-statistic-1">
          <div class="card-icon bg-warning">
            <i class="fas fa-file-alt"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Pemasukan Hari Ini</h4>
            </div>
            <div class="card-body">
              Rp. {{ number_format($pemasukanHariIni, 0, ',', '.') }}
            </div>
          </div>
        </div>
      </div>

      <!-- Pemasukan Perbulan -->
      <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
        <div class="card card-statistic-1">
          <div class="card-icon bg-primary">
            <i class="fas fa-calendar-alt"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Pemasukan Bulan Ini</h4>
            </div>
            <div class="card-body">
              Rp. {{ number_format($pemasukanBulanIni, 0, ',', '.') }}
            </div>
          </div>
        </div>
      </div>

      <!-- Total Pemasukan -->
      <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
        <div class="card card-statistic-1">
          <div class="card-icon bg-success">
            <i class="fas fa-file-invoice-dollar"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Total Pemasukan</h4>
            </div>
            <div class="card-body">
              Rp. {{ number_format($semuaPemasukan, 0, ',', '.') }}
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Grafik Transaksi Harian dan Pemasukan per-Cabang -->
    <div class="row">
      <!-- Grafik Transaksi Harian -->
      <div class="col-lg-8">
        <div class="card">
          <div class="card-header">
            <h4>Grafik Transaksi Harian</h4>
          </div>
          <div class="card-body">
            <canvas id="grafikPenjualan"></canvas>
          </div>
        </div>
      </div>

      <!-- Grafik Pemasukan per-Cabang -->
      <div class="col-lg-4">
        <div class="card">
          <div class="card-header">
            <h4>Pemasukan per-Cabang</h4>
          </div>
          <div class="card-body">
            <canvas id="pemasukanCabang"></canvas>
          </div>
        </div>
      </div>
    </div>

    <!-- Grafik Transaksi Bulanan -->
    <div class="row">
      <div class="col-lg-8">
        <div class="card">
          <div class="card-header">
            <h4>Grafik Transaksi Bulanan</h4>
          </div>
          <div class="card-body">
            <canvas id="grafikBulanan"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-chart-3d"></script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Inisialisasi grafik transaksi harian
    const ctx = document.getElementById('grafikPenjualan').getContext('2d');
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: [
          @foreach($grafikPenjualan as $data)
          '{{ \Carbon\Carbon::parse($data->date)->translatedFormat('dddd') }}',
          @endforeach
        ],
        datasets: [{
          label: 'Grafik Penjualan Harian',
          data: [
            @foreach($grafikPenjualan as $data)
              {{ $data->total }},
            @endforeach
          ],
          backgroundColor: 'rgba(75, 192, 192, 0.2)', // Warna background baru
          borderColor: 'rgba(0,0,0)', // Warna border baru
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        animation: {
          duration: 1000, // Durasi animasi dalam milidetik
          easing: 'easeOutBounce', // Tipe easing animasi
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: function(value) {
                return value.toLocaleString();
              }
            }
          }
        },
        plugins: {
          tooltip: {
            callbacks: {
              label: function(tooltipItem) {
                return tooltipItem.raw.toLocaleString();
              }
            }
          }
        }
      }
    });

    // Inisialisasi grafik pemasukan per-cabang
    const ctxCabang = document.getElementById('pemasukanCabang').getContext('2d');
    new Chart(ctxCabang, {
      type: 'pie',
      data: {
        labels: [
          @foreach($cabangNames as $id => $name)
          '{{ $name }}',
          @endforeach
        ],
        datasets: [{
          label: 'Pemasukan per-Cabang',
          data: [
            @foreach($cabangNames as $id => $name)
              {{ $pemasukanPerCabang[$id] }},
            @endforeach
          ],
          backgroundColor: [
            'rgba(255, 99, 132, 0.2)', // Merah muda
            'rgba(54, 162, 235, 0.2)', // Biru
            'rgba(255, 206, 86, 0.2)', // Kuning
            'rgba(75, 192, 192, 0.2)', // Hijau
            'rgba(153, 102, 255, 0.2)', // Ungu
            'rgba(255, 159, 64, 0.2)' // Oranye
          ],
          borderColor: [
            'rgba(0,0,0)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)'
          ],
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        animation: {
          duration: 1000,
          easing: 'easeOutBounce',
        },
        plugins: {
          tooltip: {
            callbacks: {
              label: function(tooltipItem) {
                return tooltipItem.raw.toLocaleString();
              }
            }
          }
        }
      }
    });

    // Inisialisasi grafik transaksi bulanan
    const ctxMonthly = document.getElementById('grafikBulanan').getContext('2d');
    new Chart(ctxMonthly, {
      type: 'line', // Mengubah 'colum' menjadi 'bar'
      data: {
        labels: [
          @foreach($grafikBulanan as $data)
          '{{ \Carbon\Carbon::parse($data->month)->translatedFormat('F Y') }}',
          @endforeach
        ],
        datasets: [{
          label: 'Grafik Bulanan',
          data: [
            @foreach($grafikBulanan as $data)
              {{ $data->total }},
            @endforeach
          ],
          backgroundColor: 'rgba(153, 102, 255, 0.2)', // Warna background baru
          borderColor: 'rgba(0,0,0)', // Warna border baru
          borderWidth: 1,
          fill: true,
        }]
      },
      options: {
        responsive: true,
        animation: {
          duration: 1000,
          easing: 'easeOutBounce',
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: function(value) {
                return value.toLocaleString();
              }
            }
          }
        },
        plugins: {
          tooltip: {
            callbacks: {
              label: function(tooltipItem) {
                return tooltipItem.raw.toLocaleString();
              }
            }
          }
        }
      }
    });
  });
</script>
@endpush
