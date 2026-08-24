<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Gestión de Ventas</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 30px;
            color: #1f2937;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        h1 {
            margin: 0;
        }

        h2 {
            margin-top: 35px;
        }

        .button {
            display: inline-block;
            padding: 10px 16px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }

        .button:hover {
            background: #1d4ed8;
        }

        .message {
            background: #dcfce7;
            color: #166534;
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .filters {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .filters form {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: end;
        }

        .field {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        label {
            font-size: 14px;
            font-weight: bold;
        }

        select,
        input[type="date"] {
            padding: 9px 10px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
        }

        .filter-button {
            padding: 9px 14px;
            border: none;
            border-radius: 6px;
            background: #111827;
            color: white;
            cursor: pointer;
        }

        .clear-link {
            padding: 9px 0;
            color: #2563eb;
            text-decoration: none;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 25px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .card-title {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 8px;
        }

        .card-value {
            font-size: 24px;
            font-weight: bold;
        }

        .table-container {
            background: white;
            border-radius: 10px;
            overflow-x: auto;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 14px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        th {
            background: #f9fafb;
            font-size: 14px;
        }

        .actions {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .edit-link {
            color: #2563eb;
            text-decoration: none;
        }

        .delete-button {
            border: none;
            background: #dc2626;
            color: white;
            padding: 7px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .empty {
            padding: 25px;
            text-align: center;
            color: #6b7280;
        }

        @media (max-width: 800px) {
            .cards {
                grid-template-columns: 1fr;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">
        <h1>Gestión de Ventas</h1>

        <a href="{{ route('sales.create') }}" class="button">
            Nueva venta
        </a>
    </div>

    @if (session('success'))
        <div class="message">
            {{ session('success') }}
        </div>
    @endif

    <div class="filters">
        <form action="{{ route('sales.index') }}" method="GET">

            <div class="field">
                <label for="product_id">Producto</label>

                <select name="product_id" id="product_id">
                    <option value="">Todos</option>

                    @foreach ($products as $product)
                        <option
                            value="{{ $product->id }}"
                            {{ request('product_id') == $product->id ? 'selected' : '' }}
                        >
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label for="date_from">Desde</label>

                <input
                    type="date"
                    name="date_from"
                    id="date_from"
                    value="{{ request('date_from') }}"
                >
            </div>

            <div class="field">
                <label for="date_to">Hasta</label>

                <input
                    type="date"
                    name="date_to"
                    id="date_to"
                    value="{{ request('date_to') }}"
                >
            </div>

            <button type="submit" class="filter-button">
                Filtrar
            </button>

            <a href="{{ route('sales.index') }}" class="clear-link">
                Limpiar
            </a>

        </form>
    </div>

    <div class="cards">

        <div class="card">
            <div class="card-title">Total vendido</div>
            <div class="card-value">
                ${{ number_format($totalSales, 0, ',', '.') }}
            </div>
        </div>

        <div class="card">
            <div class="card-title">Unidades vendidas</div>
            <div class="card-value">
                {{ $totalUnits }}
            </div>
        </div>

        <div class="card">
            <div class="card-title">Ventas registradas</div>
            <div class="card-value">
                {{ $salesCount }}
            </div>
        </div>

    </div>

    <h2>Ventas</h2>

    <div class="table-container">

        @if ($sales->isEmpty())

            <div class="empty">
                No hay ventas registradas.
            </div>

        @else

            <table>

                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio unitario</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach ($sales as $sale)

                        <tr>

                            <td>{{ $sale->product->name }}</td>

                            <td>{{ $sale->quantity }}</td>

                            <td>
                                ${{ number_format($sale->unit_price, 0, ',', '.') }}
                            </td>

                            <td>
                                ${{ number_format($sale->total, 0, ',', '.') }}
                            </td>

                            <td>

                                <div class="actions">

                                    <a
                                        href="{{ route('sales.edit', $sale) }}"
                                        class="edit-link"
                                    >
                                        Editar
                                    </a>

                                    <form
                                        action="{{ route('sales.destroy', $sale) }}"
                                        method="POST"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="delete-button"
                                            onclick="return confirm('¿Está seguro de eliminar esta venta?')"
                                        >
                                            Eliminar
                                        </button>
                                    </form>

                                </div>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        @endif

    </div>

    <h2>Resumen de ventas por producto</h2>

    <div class="table-container">

        @if ($productReport->isEmpty())

            <div class="empty">
                No hay información para mostrar.
            </div>

        @else

            <table>

                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Unidades vendidas</th>
                        <th>Total vendido</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach ($productReport as $report)

                        <tr>
                            <td>{{ $report->product }}</td>
                            <td>{{ $report->total_quantity }}</td>
                            <td>
                                ${{ number_format($report->total_sales, 0, ',', '.') }}
                            </td>
                        </tr>

                    @endforeach

                </tbody>

            </table>

        @endif

    </div>

</div>

</body>
</html>