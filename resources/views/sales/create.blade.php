<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Nueva venta</title>

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
            max-width: 700px;
            margin: 0 auto;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        h1 {
            margin-top: 0;
            margin-bottom: 25px;
        }

        .field {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-size: 14px;
            font-weight: bold;
        }

        select,
        input[type="number"] {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 15px;
        }

        .error {
            margin-top: 6px;
            color: #dc2626;
            font-size: 14px;
        }

        .actions {
            display: flex;
            gap: 10px;
            align-items: center;
            margin-top: 25px;
        }

        .button {
            display: inline-block;
            padding: 10px 16px;
            border: none;
            border-radius: 6px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            cursor: pointer;
        }

        .button:hover {
            background: #1d4ed8;
        }

        .cancel {
            color: #2563eb;
            text-decoration: none;
        }

        .validation-box {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="card">

        <h1>Registrar nueva venta</h1>

        @if ($errors->any())
            <div class="validation-box">
                <strong>Revisa los siguientes errores:</strong>

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('sales.store') }}" method="POST">

            @csrf

            <div class="field">
                <label for="product_id">Producto</label>

                <select name="product_id" id="product_id" required>
                    <option value="">Seleccione un producto</option>

                    @foreach ($products as $product)
                        <option
                            value="{{ $product->id }}"
                            {{ old('product_id') == $product->id ? 'selected' : '' }}
                        >
                            {{ $product->name }} -
                            ${{ number_format($product->price, 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>

                @error('product_id')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="field">
                <label for="quantity">Cantidad</label>

                <input
                    type="number"
                    name="quantity"
                    id="quantity"
                    min="1"
                    value="{{ old('quantity') }}"
                    required
                >

                @error('quantity')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="actions">

                <button type="submit" class="button">
                    Registrar venta
                </button>

                <a href="{{ route('sales.index') }}" class="cancel">
                    Cancelar
                </a>

            </div>

        </form>

    </div>

</div>

</body>
</html>