@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Tableau de Bord Super Admin</h1>
        <a href="{{ route('super-admin.create-admin') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
            ➕ Créer un Admin
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Statistiques principales -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Clients -->
        <div class="bg-white shadow-md rounded-lg p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Clients</p>
                    <p class="text-3xl font-bold text-blue-600">{{ number_format($totalClients, 0) }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Admins Actifs -->
        <div class="bg-white shadow-md rounded-lg p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Admins Actifs</p>
                    <p class="text-3xl font-bold text-green-600">{{ $adminsActifs }}</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Abonnements Actifs -->
        <div class="bg-white shadow-md rounded-lg p-6 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Abonnements Actifs</p>
                    <p class="text-3xl font-bold text-purple-600">{{ $abonnesActifs }}</p>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Abonnements Expirés -->
        <div class="bg-white shadow-md rounded-lg p-6 border-l-4 border-orange-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Abonnements Expirés</p>
                    <p class="text-3xl font-bold text-orange-600">{{ $abonnesExpires }}</p>
                </div>
                <div class="bg-orange-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenus -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white shadow-md rounded-lg p-6 border-l-4 border-green-500">
            <p class="text-gray-500 text-sm mb-2">Revenu Aujourd'hui</p>
            <p class="text-2xl font-bold text-green-600">{{ number_format($revenuAujourdhui, 0, ',', ' ') }} GNF</p>
        </div>
        <div class="bg-white shadow-md rounded-lg p-6 border-l-4 border-blue-500">
            <p class="text-gray-500 text-sm mb-2">Revenu Ce Mois</p>
            <p class="text-2xl font-bold text-blue-600">{{ number_format($revenuCeMois, 0, ',', ' ') }} GNF</p>
        </div>
        <div class="bg-white shadow-md rounded-lg p-6 border-l-4 border-purple-500">
            <p class="text-gray-500 text-sm mb-2">Revenu Total</p>
            <p class="text-2xl font-bold text-purple-600">{{ number_format($revenuTotal, 0, ',', ' ') }} GNF</p>
        </div>
    </div>

    <!-- Graphiques -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Évolution des abonnements -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Évolution des Abonnements (12 mois)</h2>
            <canvas id="evolutionAbonnementsChart" height="100"></canvas>
        </div>

        <!-- Revenu mensuel -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Revenu Mensuel (12 mois)</h2>
            <canvas id="revenuMensuelChart" height="100"></canvas>
        </div>
    </div>

    <!-- Alertes -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Abonnements expirés -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                <span class="bg-orange-100 text-orange-600 px-2 py-1 rounded-full text-sm mr-2">{{ $alertesAbonnementsExpires->count() }}</span>
                Abonnements Expirés
            </h2>
            <div class="space-y-2 max-h-64 overflow-y-auto">
                @forelse($alertesAbonnementsExpires as $user)
                <div class="p-3 bg-orange-50 border-l-4 border-orange-500 rounded">
                    <p class="font-semibold">{{ $user->name }}</p>
                    <p class="text-sm text-gray-600">{{ $user->email }}</p>
                    <p class="text-xs text-orange-600">Expiré le: {{ $user->date_fin_abonnement ? $user->date_fin_abonnement->format('d/m/Y') : 'N/A' }}</p>
                </div>
                @empty
                <p class="text-gray-500 text-center py-4">Aucun abonnement expiré</p>
                @endforelse
            </div>
        </div>

        <!-- Paiements en retard -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                <span class="bg-red-100 text-red-600 px-2 py-1 rounded-full text-sm mr-2">{{ $alertesPaiementsRetard->count() }}</span>
                Paiements en Retard
            </h2>
            <div class="space-y-2 max-h-64 overflow-y-auto">
                @forelse($alertesPaiementsRetard as $user)
                <div class="p-3 bg-red-50 border-l-4 border-red-500 rounded">
                    <p class="font-semibold">{{ $user->name }}</p>
                    <p class="text-sm text-gray-600">{{ $user->email }}</p>
                    <p class="text-xs text-red-600">
                        Retard: {{ $user->date_fin_abonnement ? abs(now()->diffInDays($user->date_fin_abonnement, false)) : 0 }} jours
                    </p>
                </div>
                @empty
                <p class="text-gray-500 text-center py-4">Aucun paiement en retard</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Résumé des abonnements -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-8">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Résumé des Abonnements</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="text-center p-4 bg-green-50 rounded-lg">
                <p class="text-2xl font-bold text-green-600">{{ $abonnesActifs }}</p>
                <p class="text-sm text-gray-600">Actifs</p>
            </div>
            <div class="text-center p-4 bg-orange-50 rounded-lg">
                <p class="text-2xl font-bold text-orange-600">{{ $abonnesExpires }}</p>
                <p class="text-sm text-gray-600">Expirés</p>
            </div>
            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <p class="text-2xl font-bold text-gray-600">{{ $abonnesEnAttente }}</p>
                <p class="text-sm text-gray-600">En Attente</p>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script id="evolution-labels" type="application/json">@json($evolutionAbonnements->pluck('mois'))</script>
<script id="evolution-data" type="application/json">@json($evolutionAbonnements->pluck('total'))</script>
<script id="revenu-labels" type="application/json">@json($revenuMensuel->pluck('mois'))</script>
<script id="revenu-data" type="application/json">@json($revenuMensuel->pluck('total'))</script>
<script type="text/javascript">
// Récupération des données JSON générées côté Blade
var evolutionLabels = JSON.parse(document.getElementById('evolution-labels').textContent);
var evolutionData = JSON.parse(document.getElementById('evolution-data').textContent);
var revenuLabels = JSON.parse(document.getElementById('revenu-labels').textContent);
var revenuData = JSON.parse(document.getElementById('revenu-data').textContent);

// Évolution des abonnements
const evolutionCtx = document.getElementById('evolutionAbonnementsChart').getContext('2d');
new Chart(evolutionCtx, {
    type: 'line',
    data: {
        labels: evolutionLabels,
        datasets: [{
            label: 'Nouveaux abonnements',
            data: evolutionData,
            borderColor: 'rgb(59, 130, 246)',
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Revenu mensuel
const revenuCtx = document.getElementById('revenuMensuelChart').getContext('2d');
new Chart(revenuCtx, {
    type: 'bar',
    data: {
        labels: revenuLabels,
        datasets: [{
            label: 'Revenu (GNF)',
            data: revenuData,
            backgroundColor: 'rgba(34, 197, 94, 0.5)',
            borderColor: 'rgb(34, 197, 94)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
@endsection
