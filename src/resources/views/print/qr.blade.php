<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>In QR Code - {{ $table->name }}</title>
    <style>
        @page {
            size: A6;
            margin: 0;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            text-align: center;
            margin: 0;
            padding: 10mm;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            box-sizing: border-box;
            background: white;
        }
        .logo {
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .qr-code {
            margin: 10px 0;
            border: 2px solid #000;
            padding: 5px;
            border-radius: 8px;
        }
        .qr-code svg {
            width: 100%;
            height: auto;
            max-width: 250px;
        }
        .table-name {
            font-size: 28px;
            font-weight: 900;
            margin-top: 5px;
            border: 2px solid black;
            padding: 5px 20px;
            border-radius: 50px;
            display: inline-block;
        }
        .guide {
            margin-top: 15px;
            font-size: 16px;
            font-weight: 600;
        }
        .sub-guide {
            font-size: 12px;
            color: #555;
            margin-bottom: 20px;
        }
        .wifi-info {
            margin-top: auto;
            border-top: 1px dashed #999;
            padding-top: 10px;
            width: 100%;
            font-size: 12px;
        }
        .no-print {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #333;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-family: sans-serif;
            font-size: 14px;
        }
        @media print {
            .no-print {
                display: none;
            }
            body {
                height: 100%; 
            }
        }
    </style>
</head>
<body onload="setTimeout(() => window.print(), 500)">

    <div class="logo">Suối Đá Hòn Giao</div>
    <div>Nhà Hàng Sinh Thái</div>

    <div class="qr-code">
        {!! $qrCode !!}
    </div>

    <div class="guide">QUÉT MÃ ĐỂ GỌI MÓN</div>
    
    <div class="table-name">{{ $table->name }}</div>

    <div class="wifi-info">
        <p><strong>Wifi Miễn Phí</strong></p>
        <p>SSID: SuoiDaHonGiao / Pass: 12345678</p>
    </div>

    <a href="javascript:window.print()" class="no-print">🖨 In QR Code</a>

</body>
</html>
