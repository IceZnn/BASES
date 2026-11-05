<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body  { font-family: DejaVu Sans, sans-serif; color: #2d0a12; }
        h1    { color: #4a0012; font-size: 22px; margin-bottom: 5px; }
        small { font-size: 11px; color: #c06070; display: block; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; font-size: 11px; }
        th    { background: #4a0012; color: white; padding: 8px 10px; text-align: left; }
        td    { padding: 8px 10px; border-bottom: 1px solid #ead1d1; vertical-align: top; }
        tr:nth-child(even) td { background: #fff9f5; }
        .total { margin-top: 16px; font-size: 12px; color: #4a0012; font-weight: bold; }
    </style>
</head>
<body>
    <h1>EVERSWEET — Relatório de Doces</h1>
    <small>Gerado em {{ now()->format('d/m/Y H:i') }}</small>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nome</th>
                <th>Sabor</th>
                <th>Ingredientes</th>
                <th>Alérgicos</th>
                <th>Qtd</th>
                <th>Preço</th>
                <th>Cadastrado em</th>
            </tr>
        </thead>
        <tbody>
            @foreach($doces as $i => $doce)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $doce->Nome }}</td>
                <td>{{ $doce->Sabor }}</td>
                <td>{{ $doce->Ingredientes }}</td>
                <td>{{ $doce->Alergicos ?? '—' }}</td>
                <td>{{ $doce->Quantidade }}</td>
                <td>R$ {{ number_format($doce->Preco, 2, ',', '.') }}</td>
                <td>{{ \Carbon\Carbon::parse($doce->created_at)->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p class="total">Total: {{ count($doces) }} doce(s)</p>
</body>
</html>