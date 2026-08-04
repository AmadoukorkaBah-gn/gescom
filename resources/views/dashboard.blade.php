@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- Cartes -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-gradient-to-br from-indigo-500 to-blue-400 shadow-lg rounded-xl p-3 text-white flex flex-col items-start justify-between h-24">
                <span class="text-xs font-medium opacity-80 mb-1">Ventes totales</span>
                <span class="mt-auto text-lg font-bold flex items-center gap-1">
                    {{ number_format($totalSales, 0, ',', ' ') }}
                    <span class="text-xs font-semibold bg-white/20 px-2 py-0.5 rounded">GNF</span>
                </span>
            </div>
            <div class="bg-gradient-to-br from-green-400 to-emerald-500 shadow-lg rounded-xl p-3 text-white flex flex-col items-start justify-between h-24">
                <span class="text-xs font-medium opacity-80 mb-1">Ventes aujourd'hui</span>
                <span class="mt-auto text-lg font-bold flex items-center gap-1">
                    {{ number_format($todaySales, 0, ',', ' ') }}
                    <span class="text-xs font-semibold bg-white/20 px-2 py-0.5 rounded">GNF</span>
                </span>
            </div>
            <div class="bg-gradient-to-br from-yellow-400 to-orange-500 shadow-lg rounded-xl p-3 text-white flex flex-col items-start justify-between h-24">
                <span class="text-xs font-medium opacity-80 mb-1">Bénéfice aujourd'hui</span>
                <span class="mt-auto text-lg font-bold flex items-center gap-1">
                    {{ number_format($benefice, 0, ',', ' ') }}
                    <span class="text-xs font-semibold bg-white/20 px-2 py-0.5 rounded">GNF</span>
                </span>
            </div>
            <div class="bg-gradient-to-br from-pink-500 to-fuchsia-500 shadow-lg rounded-xl p-3 text-white flex flex-col items-start justify-between h-24">
                <span class="text-xs font-medium opacity-80 mb-1">Bénéfice total</span>
                <span class="mt-auto text-lg font-bold flex items-center gap-1">
                    {{ number_format($beneficeTotal, 0, ',', ' ') }}
                    <span class="text-xs font-semibold bg-white/20 px-2 py-0.5 rounded">GNF</span>
                </span>
            </div>
        </div>

        <!-- Graphique + alertes -->
        <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 bg-white shadow-lg rounded-xl p-8">
                <h3 class="text-xl font-bold mb-6 text-indigo-700 flex items-center gap-2">
                    <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1a2 2 0 002 2h1m10-3h1a2 2 0 012 2v1m0 10v1a2 2 0 01-2 2h-1m-10 3h-1a2 2 0 01-2-2v-1m16-10V7a2 2 0 00-2-2h-1m-10 0H5a2 2 0 00-2 2v1m0 10v1a2 2 0 002 2h1m10 0h1a2 2 0 002-2v-1"/></svg>
                    Ventes des 30 derniers jours
                </h3>
                <canvas id="salesChart" class="w-full h-64"></canvas>
            </div>
            <div class="bg-white shadow-lg rounded-xl p-8 flex flex-col min-h-[200px]">
                <h3 class="text-xl font-bold text-emerald-700 mb-6 flex items-center gap-2">
                    <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    Produits les plus vendus
                </h3>
                <div class="grid grid-cols-1 gap-4">
                    @foreach($topProducts as $product)
                        <div class="bg-gradient-to-br from-emerald-100 to-emerald-50 p-4 rounded-xl shadow flex flex-col items-start">
                            <div class="font-bold text-emerald-700 text-base">{{ $product->nom_produit }}</div>
                            <div class="text-xs text-gray-500 mb-1">{{ $product->total_vendu }} vendus</div>
                            <div class="text-sm font-semibold text-emerald-900">
                                {{ number_format($product->total_revenue, 0, ',', ' ') }} GNF
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Top produits -->


    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const salesData = @json($salesLast30Days ?? []);
    const labels = salesData.map(item => item.date);
    const values = salesData.map(item => item.total);
    const ctx = document.getElementById('salesChart').getContext('2d');
    Chart.register(ChartDataLabels);
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Ventes',
                data: values,
                backgroundColor: '#6366F1',
                borderColor: '#4F46E5',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                datalabels: {
                    color: '#111827',
                    anchor: 'end',
                    align: 'end',
                    formatter: value => new Intl.NumberFormat('fr-FR').format(value) + ' GNF'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
</script>
@endsection
