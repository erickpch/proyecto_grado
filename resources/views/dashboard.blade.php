@extends('layout.navbar')

@section('titulo', 'Dashboard')

@section('contenido')
<div class="dashboard-container">
    
    <div class="top-cards">
        <div class="card">
            <h3>Cantidad de Ventas</h3>
            <p class="value">{{ $cantidad_ventas }}</p>
        </div>

        <div class="card">
            <h3>Servicios más vendidos</h3>
            <ul>
                @foreach ($servicio_mas_vendido as $servicio)
                    <li>{{ $servicio->nombre }} <span>({{ $servicio->total }})</span></li>
                @endforeach
            </ul>
        </div>

        <div class="card">
            <h3>Ganancia Total</h3>
            <p class="value">Bs {{ number_format($ganancia_total, 2) }}</p>
        </div>
    </div>

    <div class="bottom-section">
        <div class="chart-card">
            <h3>Cantidad de Clientes</h3>
            <canvas id="clientesChart"></canvas>
            <p class="small-text">Últimos 7 días</p>
        </div>

        <div class="card trabajadores">
            <h3>5 trabajadores con más ventas</h3>
            <ul>
                @foreach ($trabajadores_mas_ventas as $trabajador)
                    <li>{{ $trabajador->nombre }} {{ $trabajador->apellido }} — {{ $trabajador->total }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

<!-- Librería Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('clientesChart');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode($labels) !!},
        datasets: [{
            label: 'Clientes únicos por día',
            data: {!! json_encode($data) !!},
            borderColor: '#555',
            backgroundColor: 'rgba(100,100,100,0.2)',
            borderWidth: 2,
            tension: 0.3,
            pointRadius: 4
        }]
    },
    options: {
        scales: {
            y: { beginAtZero: true }
        },
        plugins: {
            legend: { display: false }
        }
    }
});
</script>
@endsection

<style>
    .dashboard-container {
  display: flex;
  flex-direction: column;
  gap: 2rem;
  padding: 30px;
  font-family: 'Poppins', sans-serif;
  color: #333;
}

/* --- Tarjetas superiores --- */
.top-cards {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1.5rem;
}

.card {
  background: linear-gradient(145deg, #f2f2f2, #e0e0e0);
  border: 1px solid #ccc;
  border-radius: 15px;
  padding: 20px;
  text-align: center;
  box-shadow: 3px 3px 8px rgba(0,0,0,0.1);
  transition: transform 0.3s;
}

.card:hover {
  transform: translateY(-5px);
}

.card h3 {
  margin-bottom: 10px;
  font-weight: 600;
}

.card .value {
  font-size: 2rem;
  font-weight: 700;
  color: #111;
}

.card ul {
  list-style: none;
  padding: 0;
}

.card ul li {
  padding: 4px 0;
  border-bottom: 1px solid #ddd;
}

.card ul li span {
  color: #555;
  font-size: 0.9rem;
}

/* --- Sección inferior --- */
.bottom-section {
  display: grid;
  grid-template-columns: 2fr 1fr;
  gap: 2rem;
}

.chart-card {
  background: linear-gradient(145deg, #f0f0f0, #dcdcdc);
  border-radius: 15px;
  padding: 20px;
  box-shadow: 3px 3px 8px rgba(0,0,0,0.1);
}

.chart-card h3 {
  text-align: center;
  margin-bottom: 10px;
}

.chart-card .small-text {
  text-align: center;
  font-size: 0.9rem;
  color: #777;
  margin-top: 10px;
}

.trabajadores {
  background: linear-gradient(145deg, #f7f7f7, #e3e3e3);
}

.trabajadores ul li {
  text-align: left;
  padding: 6px 0;
  border-bottom: 1px solid #ccc;
}




</style>