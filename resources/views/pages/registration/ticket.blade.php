
@extends('layouts.app')

@section('title', 'Tiket Antrean - SIPKlin')

@section('content')
<div class="container-fluid py-4">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-900">Tiket Antrean</h1>
            <p class="text-muted mb-0">Pendaftaran berhasil disimpan.</p>
        </div>

        <div>
            <a href="{{ route('registrations.create') }}"
               class="btn btn-secondary">
                <i class="fas fa-plus mr-1"></i> Pendaftaran Baru
            </a>

            <button type="button" onclick="printTicket()" class="btn btn-sipklin">
                    <i class="fas fa-print mr-1"></i> Cetak Tiket
                    <a href="{{ route('queues.index') }}"></a>
            </button>
        </div>
    </div>

    @php
        $department = $registration->doctorSchedule->doctor->department;
        $queueNumber = optional($registration->queue)->nomor_antrean ?? 0;
        $queueCode = $department->kode_poli ?? 'A';
    @endphp

    <div class="ticket-wrapper">
        <div class="ticket">

            <div class="ticket-header">
                <div class="ticket-logo">
                    <i class="fas fa-heartbeat"></i>
                </div>
                <h2>SIPKlin</h2>
                <p>Sistem Informasi Pelayanan Klinik</p>
                <div class="ticket-divider"></div>
                <h5>TIKET ANTREAN PASIEN</h5>
            </div>

            <div class="ticket-number">
                <span>NOMOR ANTREAN</span>
                <strong>
                    {{ $queueCode }}-{{ str_pad($queueNumber, 3, '0', STR_PAD_LEFT) }}
                </strong>
                <span class="status-badge">
                    {{ ucfirst($registration->status) }}
                </span>
            </div>

            <div class="ticket-details">
                <div class="detail-row">
                    <span>Nama Pasien</span>
                    <strong>{{ $registration->patient->nama ?? '-' }}</strong>
                </div>

                <div class="detail-row">
                    <span>No. Rekam Medis</span>
                    <strong>{{ $registration->patient->no_rm ?? '-' }}</strong>
                </div>

                <div class="detail-row">
                    <span>Tanggal Kunjungan</span>
                    <strong>
                        {{ \Carbon\Carbon::parse($registration->tanggal)->format('d-m-Y') }}
                    </strong>
                </div>

                <div class="detail-row">
                    <span>Poli</span>
                    <strong>{{ $department->name ?? '-' }}</strong>
                </div>

                <div class="detail-row">
                    <span>Dokter</span>
                    <strong>
                        {{ $registration->doctorSchedule->doctor->nama ?? '-' }}
                    </strong>
                </div>

                <div class="detail-row">
                    <span>Jam Praktik</span>
                    <strong>
                        {{ \Carbon\Carbon::parse($registration->doctorSchedule->jam_mulai)->format('H:i') }}
                        -
                        {{ \Carbon\Carbon::parse($registration->doctorSchedule->jam_selesai)->format('H:i') }}
                    </strong>
                </div>
            </div>

            <div class="ticket-footer">
                <p>Harap menunggu hingga nomor antrean dipanggil.</p>
            </div>

        </div>
    </div>

</div>

<style>
    .btn-sipklin {
        background-color: #06285c !important;
        border-color: #06285c !important;
        color: white !important;
    }

    .ticket-wrapper {
        display: flex;
        justify-content: center;
        padding: 10px 0 30px;
    }

    .ticket {
        width: 100%;
        max-width: 500px;
        padding: 28px;
        background: #fff;
        border: 1px dashed #06285c;
        border-radius: 12px;
        box-shadow: 0 4px 18px rgba(0, 0, 0, .08);
        color: #06285c;
    }

    .ticket-header {
        text-align: center;
    }

    .ticket-logo {
        font-size: 38px;
        color: #06285c;
    }

   .ticket-header h2 {
        margin: 5px 0;
        font-size: 32px;
        font-weight: 800;
        letter-spacing: 1px;
    }

    .ticket-header p {
        color: #6c757d;
        font-size: 15px;
        margin-bottom: 15px;
    }

    .ticket-divider {
        border-top: 1px dashed #aab5c5;
        margin: 16px 0;
    }

   .ticket-header h5 {
        font-size: 17px;
        font-weight: 800;
    }

    .ticket-number {
        text-align: center;
        padding: 20px 10px;
        margin: 20px 0;
        background: #edf3fc;
        border-radius: 8px;
    }

    .ticket-number span {
        display: block;
        font-size: 14px;
        font-weight: 700;
    }

    .ticket-number strong {
        display: block;
        font-size: 36px;
        line-height: 1.4;
        font-weight: 800;
        letter-spacing: 2px;
    }

    .ticket-number .status-badge {
        display: inline-block;
        margin-top: 8px;
        padding: 5px 12px;
        border-radius: 20px;
        background: #fff0c2;
        color: #765500;
    }

    .ticket-details {
        margin-top: 15px;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        gap: 15px;
        padding: 10px 0;
        border-bottom: 1px solid #e9edf3;
        font-size: 15px;
    }

    .detail-row span {
        color: #6c757d;
        flex: 1;
    }

    .detail-row strong {
        flex: 1.2;
        text-align: right;
        overflow-wrap: anywhere;
    }

    .ticket-footer {
        text-align: center;
        margin-top: 22px;
        padding-top: 15px;
        border-top: 1px dashed #aab5c5;
    }

    .ticket-footer p {
        font-size: 14px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .ticket-footer small {
        color: #6c757d;
        font-size: 10px;
    }

        
    @media print {
        @page {
            size: 80mm auto;
            margin: 5mm;
        }

        html,
        body {
            width: 100% !important;
            height: auto !important;
            margin: 0 !important;
            padding: 0 !important;
            background: #fff !important;
        }

        body * {
            visibility: hidden !important;
        }

        .ticket-wrapper,
        .ticket-wrapper * {
            visibility: visible !important;
        }

        .ticket-wrapper {
            position: absolute !important;
            top: 0 !important;
            left: 0 !important;
            display: flex !important;
            justify-content: center !important;
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .ticket {
            display: block !important;
            width: 100% !important;
            max-width: none !important;
            margin: 0 auto !important;
            padding: 5px !important;
            border: none !important;
            border-radius: 0 !important;
            box-shadow: none !important;
            background: #fff !important;
            color: #06285c !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .no-print {
            display: none !important;
        }
    }

</style>
@endsection


<script>
    function printTicket() {
        const ticket = document.querySelector('.ticket');

        if (!ticket) {
            alert('Tiket antrean tidak ditemukan.');
            return;
        }

        const printWindow = window.open(
            '',
            '_blank',
            'width=1100,height=850'
        );

        if (printWindow) {
            printWindow.moveTo(0, 0);
            printWindow.resizeTo(
                screen.availWidth,
                screen.availHeight
            );
        }

        if (!printWindow) {
            alert('Izinkan pop-up di browser untuk mencetak tiket.');
            return;
        }

        printWindow.document.open();
        printWindow.document.write(`
            <!DOCTYPE html>
            <html lang="id">
            <head>
                <meta charset="UTF-8">
                <title>Tiket Antrean SIPKlin</title>
                <style>
                    @page {
                        size: 58mm 160mm;
                        margin: 2mm;
                    }

                    * {
                        box-sizing: border-box;
                    }

                    body {
                        width: 54mm;
                        margin: 0 auto;
                        padding: 0;
                        font-family: Arial, sans-serif;
                        color: #06285c;
                        background: white;
                    }

                    .ticket {
                        box-sizing: border-box;
                        width: 54mm;
                        max-width: 54mm;
                        padding: 4mm 3mm;
                        margin: 0 auto;
                        border: 1px dashed #06285c;
                        color: #06285c;
                        background: white;
                        overflow-wrap: anywhere;
                    }

                    .ticket-header {
                        text-align: center;
                    }

                    .ticket-logo {
                        font-size: 32px;
                        color: #06285c;
                    }

                    .ticket-header h2 {
                        margin: 5px 0;
                        font-size: 24px;
                    }

                    .ticket-header p {
                        margin-bottom: 15px;
                        font-size: 11px;
                        color: #666;
                    }

                    .ticket-divider {
                        border-top: 1px dashed #aaa;
                        margin: 14px 0;
                    }

                    .ticket-header h5 {
                        font-size: 13px;
                    }

                    .ticket-number {
                        text-align: center;
                        padding: 15px 5px;
                        margin: 15px 0;
                        background: #edf3fc;
                        border-radius: 6px;
                    }

                    .ticket-number span {
                        display: block;
                        font-size: 10px;
                    }

                    .ticket-number strong {
                        display: block;
                        font-size: 30px;
                        margin: 5px 0;
                    }

                    .status-badge {
                        margin-top: 5px;
                    }

                    .detail-row {
                        display: flex;
                        justify-content: space-between;
                        gap: 8px;
                        padding: 9px 0;
                        border-bottom: 1px solid #eee;
                        font-size: 11px;
                    }

                    .detail-row span {
                        flex: 1;
                        color: #666;
                    }

                    .detail-row strong {
                        flex: 1.2;
                        text-align: right;
                        overflow-wrap: anywhere;
                    }

                    .ticket-footer {
                        margin-top: 18px;
                        padding-top: 12px;
                        text-align: center;
                        border-top: 1px dashed #aaa;
                    }

                    .ticket-footer p {
                        font-size: 11px;
                        font-weight: bold;
                    }

                    .ticket-footer small {
                        font-size: 9px;
                    }

                    @media print {
                        body {
                            -webkit-print-color-adjust: exact;
                            print-color-adjust: exact;
                        }
                    }
                </style>
            </head>
            <body>
                ${ticket.outerHTML}
            </body>
            </html>
        `);

        printWindow.document.close();
        printWindow.focus();

        printWindow.onload = function () {
            printWindow.print();
        };
    }
</script>

